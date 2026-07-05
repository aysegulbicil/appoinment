<?php

namespace App\Models;

use CodeIgniter\Model;

class BusinessWorkingHourModel extends Model
{
    protected $table         = 'business_working_hours';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'business_id',
        'day_of_week',
        'is_open',
        'start_time',
        'end_time',
    ];

    protected $useTimestamps = true;

    protected array $casts = [
        'business_id' => 'integer',
        'day_of_week' => 'integer',
        'is_open'     => 'integer',
    ];

    public const DAY_LABELS = [
        1 => 'Pazartesi',
        2 => 'Salı',
        3 => 'Çarşamba',
        4 => 'Perşembe',
        5 => 'Cuma',
        6 => 'Cumartesi',
        7 => 'Pazar',
    ];

    /**
     * İşletme henüz saat kaydetmediyse geçerli olan varsayılan program.
     *
     * @return array<int, array{day_of_week: int, is_open: int, start_time: ?string, end_time: ?string}>
     */
    public static function defaultSchedule(): array
    {
        $schedule = [];

        foreach (array_keys(self::DAY_LABELS) as $day) {
            if ($day <= 5) {
                $schedule[$day] = ['day_of_week' => $day, 'is_open' => 1, 'start_time' => '09:00:00', 'end_time' => '18:00:00'];
            } elseif ($day === 6) {
                $schedule[$day] = ['day_of_week' => $day, 'is_open' => 1, 'start_time' => '10:00:00', 'end_time' => '16:00:00'];
            } else {
                $schedule[$day] = ['day_of_week' => $day, 'is_open' => 0, 'start_time' => null, 'end_time' => null];
            }
        }

        return $schedule;
    }

    /**
     * İşletmenin haftalık programını 1-7 gün anahtarlı döndürür;
     * kayıt yoksa varsayılan programa düşer.
     *
     * @return array<int, array{day_of_week: int, is_open: int, start_time: ?string, end_time: ?string}>
     */
    public function scheduleForBusiness(int $businessId): array
    {
        $rows = $this->where('business_id', $businessId)->findAll();

        if ($rows === []) {
            return self::defaultSchedule();
        }

        $schedule = self::defaultSchedule();

        foreach ($schedule as $day => $defaults) {
            $schedule[$day] = ['day_of_week' => $day, 'is_open' => 0, 'start_time' => null, 'end_time' => null];
        }

        foreach ($rows as $row) {
            $day = (int) $row['day_of_week'];

            if ($day < 1 || $day > 7) {
                continue;
            }

            $schedule[$day] = [
                'day_of_week' => $day,
                'is_open'     => (int) $row['is_open'],
                'start_time'  => $row['start_time'],
                'end_time'    => $row['end_time'],
            ];
        }

        return $schedule;
    }

    /**
     * Haftalık programın tamamını tek seferde değiştirir.
     *
     * @param array<int, array{is_open: int, start_time: ?string, end_time: ?string}> $schedule 1-7 gün anahtarlı
     */
    public function replaceScheduleForBusiness(int $businessId, array $schedule): bool
    {
        $db = $this->db;
        $db->transStart();

        $this->where('business_id', $businessId)->delete();

        foreach ($schedule as $day => $row) {
            $this->insert([
                'business_id' => $businessId,
                'day_of_week' => (int) $day,
                'is_open'     => (int) ($row['is_open'] ?? 0),
                'start_time'  => $row['start_time'] ?? null,
                'end_time'    => $row['end_time'] ?? null,
            ]);
        }

        $db->transComplete();

        return $db->transStatus();
    }
}
