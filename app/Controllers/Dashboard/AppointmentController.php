<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\AppointmentModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AppointmentController extends BaseController
{
    public function index(): string
    {
        $appointmentQuery = (new AppointmentModel())
            ->select('appointments.*, businesses.name AS business_name, businesses.owner_user_id, businesses.user_id AS business_user_id, business_services.title AS service_title')
            ->distinct()
            ->join('businesses', 'businesses.id = appointments.business_id', 'left')
            ->join('business_staff', "business_staff.business_id = businesses.id AND business_staff.status = 'active'", 'left')
            ->join('business_services', 'business_services.id = appointments.business_service_id', 'left')
            ->orderBy('appointments.appointment_date', 'DESC')
            ->orderBy('appointments.appointment_time', 'DESC');

        if (! $this->isAdmin()) {
            $appointmentQuery
                ->groupStart()
                ->where('businesses.owner_user_id', $this->userId())
                ->orWhere('businesses.user_id', $this->userId())
                ->orWhere('business_staff.user_id', $this->userId())
                ->orWhere('business_staff.email', $this->userEmail())
                ->groupEnd();
        }

        return $this->render('dashboard/appointments/index', [
            'pageTitle'    => 'Randevular',
            'appointments' => $appointmentQuery->findAll(),
            'statusLabels' => $this->statusLabels(),
        ]);
    }

    public function update(int $id)
    {
        $appointment = $this->findVisibleAppointment($id);

        $rules = [
            'status'           => 'required|in_list[pending,approved,rejected,cancelled]',
            'rejection_reason' => 'permit_empty|max_length[1000]',
            'suggested_date'   => 'permit_empty|valid_date[Y-m-d]',
            'suggested_time'   => 'permit_empty|regex_match[/^([01][0-9]|2[0-3]):[0-5][0-9]$/]',
            'admin_note'       => 'permit_empty|max_length[1000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $suggestedTime = trim((string) $this->request->getPost('suggested_time'));

        (new AppointmentModel())->update($appointment['id'], [
            'status'           => (string) $this->request->getPost('status'),
            'rejection_reason' => trim((string) $this->request->getPost('rejection_reason')) ?: null,
            'suggested_date'   => trim((string) $this->request->getPost('suggested_date')) ?: null,
            'suggested_time'   => $suggestedTime === '' ? null : $suggestedTime . ':00',
            'admin_note'       => trim((string) $this->request->getPost('admin_note')) ?: null,
        ]);

        return redirect()->back()->with('success', 'Randevu guncellendi.');
    }

    private function findVisibleAppointment(int $id): array
    {
        $query = (new AppointmentModel())
            ->select('appointments.*, businesses.owner_user_id, businesses.user_id AS business_user_id')
            ->join('businesses', 'businesses.id = appointments.business_id', 'left')
            ->join('business_staff', "business_staff.business_id = businesses.id AND business_staff.status = 'active'", 'left')
            ->where('appointments.id', $id);

        if (! $this->isAdmin()) {
            $query
                ->groupStart()
                ->where('businesses.owner_user_id', $this->userId())
                ->orWhere('businesses.user_id', $this->userId())
                ->orWhere('business_staff.user_id', $this->userId())
                ->orWhere('business_staff.email', $this->userEmail())
                ->groupEnd();
        }

        $appointment = $query->first();

        if ($appointment === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $appointment;
    }

    private function render(string $view, array $contentData): string
    {
        return view('public/home/index', [
            'contentView' => $view,
            'contentData' => $contentData,
        ]);
    }

    private function userId(): int
    {
        return (int) session()->get('userId');
    }

    private function userEmail(): string
    {
        return (string) session()->get('userEmail');
    }

    private function isAdmin(): bool
    {
        return (string) session()->get('userRole') === 'admin';
    }

    private function statusLabels(): array
    {
        return [
            'pending'   => 'Bekliyor',
            'approved'  => 'Onaylandi',
            'rejected'  => 'Reddedildi',
            'cancelled' => 'Iptal Edildi',
        ];
    }
}
