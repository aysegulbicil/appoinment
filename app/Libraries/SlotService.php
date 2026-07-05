<?php

namespace App\Libraries;

use App\Models\AppointmentModel;
use App\Models\BusinessStaffModel;
use App\Models\BusinessWorkingHourModel;
use DateTimeImmutable;

/**
 * Çalışma saatlerinden randevu slotları üretir ve çakışma kontrolü yapar.
 *
 * Kurallar:
 * - Slotlar hizmet süresi adımıyla üretilir (süre yoksa 30 dk).
 * - Geçmiş saatler ve minimum hazırlık süresine (lead time) yetişmeyen
 *   saatler kapalı sayılır.
 * - Aynı anda alınabilecek randevu sayısı (kapasite) işletmenin aktif
 *   çalışan sayısıdır; hiç çalışan tanımlı değilse 1 kabul edilir.
 * - pending ve approved durumundaki randevular slotu meşgul eder.
 */
class SlotService
{
    public const DEFAULT_DURATION_MINUTES = 30;
    public const MAX_BOOKING_DAYS         = 60;
    public const MIN_LEAD_MINUTES         = 60;

    private const BUSY_STATUSES = ['pending', 'approved'];

    /**
     * Bir tarih için slot listesi döndürür.
     *
     * @return array{closed: bool, error: ?string, slots: array<int, array{time: string, available: bool}>}
     */
    public function getSlotsForDate(array $business, array $service, string $date): array
    {
        $day = $this->parseDate($date);

        if ($day === null) {
            return ['closed' => false, 'error' => 'Geçersiz tarih.', 'slots' => []];
        }

        if ($rangeError = $this->dateRangeError($day)) {
            return ['closed' => false, 'error' => $rangeError, 'slots' => []];
        }

        $hours = (new BusinessWorkingHourModel())->scheduleForBusiness((int) $business['id']);
        $dayHours = $hours[(int) $day->format('N')] ?? null;

        if ($dayHours === null || ! $dayHours['is_open'] || $dayHours['start_time'] === null || $dayHours['end_time'] === null) {
            return ['closed' => true, 'error' => null, 'slots' => []];
        }

        $duration = $this->serviceDuration($service);
        $openAt   = $this->toMinutes($dayHours['start_time']);
        $closeAt  = $this->toMinutes($dayHours['end_time']);

        if ($openAt === null || $closeAt === null || $closeAt <= $openAt) {
            return ['closed' => true, 'error' => null, 'slots' => []];
        }

        $capacity      = $this->capacity((int) $business['id']);
        $busyIntervals = $this->busyIntervals((int) $business['id'], $day->format('Y-m-d'));
        $earliestStart = $this->earliestBookableMinute($day);

        $slots = [];

        for ($start = $openAt; $start + $duration <= $closeAt; $start += $duration) {
            $overlapping = 0;

            foreach ($busyIntervals as [$busyStart, $busyEnd]) {
                if ($busyStart < $start + $duration && $start < $busyEnd) {
                    $overlapping++;
                }
            }

            $slots[] = [
                'time'      => $this->toTimeString($start),
                'available' => $start >= $earliestStart && $overlapping < $capacity,
            ];
        }

        return ['closed' => false, 'error' => null, 'slots' => $slots];
    }

    /**
     * Randevu kaydından hemen önce çağrılır; sorun yoksa null,
     * varsa kullanıcıya gösterilecek hata metni döner.
     */
    public function validateBookingSlot(array $business, array $service, string $date, string $time): ?string
    {
        $result = $this->getSlotsForDate($business, $service, $date);

        if ($result['error'] !== null) {
            return $result['error'];
        }

        if ($result['closed'] || $result['slots'] === []) {
            return 'İşletme seçtiğiniz tarihte kapalı. Lütfen başka bir gün seçin.';
        }

        foreach ($result['slots'] as $slot) {
            if ($slot['time'] === $time) {
                return $slot['available']
                    ? null
                    : 'Seçtiğiniz saat dolu veya geçti. Lütfen uygun bir saat seçin.';
            }
        }

        return 'Seçtiğiniz saat bu hizmetin randevu takvimiyle uyuşmuyor. Lütfen listeden bir saat seçin.';
    }

    public function serviceDuration(array $service): int
    {
        $duration = (int) ($service['duration_minutes'] ?? 0);

        return $duration > 0 ? $duration : self::DEFAULT_DURATION_MINUTES;
    }

    private function parseDate(string $date): ?DateTimeImmutable
    {
        $parsed = DateTimeImmutable::createFromFormat('!Y-m-d', $date);

        return ($parsed !== false && $parsed->format('Y-m-d') === $date) ? $parsed : null;
    }

    private function dateRangeError(DateTimeImmutable $day): ?string
    {
        $today = new DateTimeImmutable('today');

        if ($day < $today) {
            return 'Geçmiş bir tarihe randevu alınamaz.';
        }

        if ($day > $today->modify('+' . self::MAX_BOOKING_DAYS . ' days')) {
            return 'En fazla ' . self::MAX_BOOKING_DAYS . ' gün sonrasına randevu alabilirsiniz.';
        }

        return null;
    }

    /**
     * Bugünse şimdi + lead time'dan erken slotları eler; ileri tarihlerde sınır yok.
     */
    private function earliestBookableMinute(DateTimeImmutable $day): int
    {
        if ($day->format('Y-m-d') !== date('Y-m-d')) {
            return 0;
        }

        return ((int) date('H')) * 60 + (int) date('i') + self::MIN_LEAD_MINUTES;
    }

    private function capacity(int $businessId): int
    {
        $activeStaff = (new BusinessStaffModel())
            ->where('business_id', $businessId)
            ->where('status', 'active')
            ->countAllResults();

        return max(1, $activeStaff);
    }

    /**
     * Günün meşgul aralıkları: [başlangıç dk, bitiş dk] çiftleri.
     *
     * @return array<int, array{0: int, 1: int}>
     */
    private function busyIntervals(int $businessId, string $date): array
    {
        $appointments = (new AppointmentModel())
            ->select('appointments.appointment_time, business_services.duration_minutes')
            ->join('business_services', 'business_services.id = appointments.business_service_id', 'left')
            ->where('appointments.business_id', $businessId)
            ->where('appointments.appointment_date', $date)
            ->whereIn('appointments.status', self::BUSY_STATUSES)
            ->findAll();

        $intervals = [];

        foreach ($appointments as $appointment) {
            $start = $this->toMinutes((string) $appointment['appointment_time']);

            if ($start === null) {
                continue;
            }

            $duration = (int) ($appointment['duration_minutes'] ?? 0);
            $intervals[] = [$start, $start + ($duration > 0 ? $duration : self::DEFAULT_DURATION_MINUTES)];
        }

        return $intervals;
    }

    private function toMinutes(string $time): ?int
    {
        if (! preg_match('/^(\d{2}):(\d{2})/', $time, $matches)) {
            return null;
        }

        return ((int) $matches[1]) * 60 + (int) $matches[2];
    }

    private function toTimeString(int $minutes): string
    {
        return sprintf('%02d:%02d', intdiv($minutes, 60), $minutes % 60);
    }
}
