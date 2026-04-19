<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Libraries\MailService;
use App\Models\BusinessModel;
use App\Models\BusinessStaffModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\I18n\Time;

class EmployeeController extends BaseController
{
    public function index(): string
    {
        $businesses = $this->visibleBusinesses();
        $selectedBusiness = $this->selectedBusiness($businesses);
        $staff = [];

        if ($selectedBusiness !== null) {
            $staff = (new BusinessStaffModel())
                ->select('business_staff.*, users.email_verified_at')
                ->join('users', 'users.id = business_staff.user_id', 'left')
                ->forBusiness((int) $selectedBusiness['id'])
                ->orderBy('business_staff.id', 'DESC')
                ->findAll();
        }

        return $this->render('dashboard/employees/index', [
            'pageTitle'        => 'Calisanlar',
            'businesses'       => $businesses,
            'selectedBusiness' => $selectedBusiness,
            'staff'            => $staff,
            'roleLabels'       => $this->roleLabels(),
            'statusLabels'     => $this->statusLabels(),
            'canManageStaff'   => $selectedBusiness !== null && $this->canManageStaff($selectedBusiness),
        ]);
    }

    public function store()
    {
        $business = $this->findManageableBusiness((int) $this->request->getPost('business_id'));

        $rules = [
            'name'  => 'required|min_length[3]|max_length[120]',
            'email' => 'required|valid_email|max_length[160]',
            'phone' => 'permit_empty|max_length[25]',
            'role'  => 'required|in_list[manager,staff]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = BusinessStaffModel::normalizeEmail((string) $this->request->getPost('email'));

        if ($email === BusinessStaffModel::normalizeEmail((string) session()->get('userEmail'))) {
            return redirect()->back()->withInput()->with('errors', [
                'email' => 'Kendi hesabınızı çalışan olarak ekleyemezsiniz.',
            ]);
        }

        $staffModel = new BusinessStaffModel();
        $existing = $staffModel
            ->where('business_id', $business['id'])
            ->where('email', $email)
            ->first();

        if ($existing !== null) {
            return redirect()->back()->withInput()->with('errors', [
                'email' => 'Bu e-posta adresi bu işletmeye zaten eklenmiş.',
            ]);
        }

        $user = (new UserModel())->where('email', $email)->first();
        $role = (string) $this->request->getPost('role');
        $now = Time::now()->toDateTimeString();

        $staffModel->insert([
            'business_id' => $business['id'],
            'user_id'     => $user['id'] ?? null,
            'name'        => trim((string) $this->request->getPost('name')),
            'email'       => $email,
            'phone'       => trim((string) $this->request->getPost('phone')) ?: null,
            'role'        => $role,
            'status'      => 'active',
            'invited_at'  => $now,
            'accepted_at' => $user !== null ? $now : null,
        ]);

        $mailSent = (new MailService())->sendStaffInvitation(
            $email,
            trim((string) $this->request->getPost('name')),
            $business['name'],
            $this->roleLabels()[$role] ?? $role
        );

        $message = $mailSent
            ? 'Çalışan eklendi ve davet e-postası gönderildi.'
            : 'Çalışan eklendi fakat davet e-postası gönderilemedi. SMTP ayarlarını kontrol edin.';

        return redirect()->to(base_url('dashboard/employees?business_id=' . $business['id']))
            ->with($mailSent ? 'success' : 'error', $message);
    }

    public function update(int $id)
    {
        $staff = $this->findStaff($id);
        $business = $this->findManageableBusiness((int) $staff['business_id']);

        $rules = [
            'name'   => 'required|min_length[3]|max_length[120]',
            'phone'  => 'permit_empty|max_length[25]',
            'role'   => 'required|in_list[manager,staff]',
            'status' => 'required|in_list[active,passive]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new BusinessStaffModel())->update($staff['id'], [
            'name'   => trim((string) $this->request->getPost('name')),
            'phone'  => trim((string) $this->request->getPost('phone')) ?: null,
            'role'   => (string) $this->request->getPost('role'),
            'status' => (string) $this->request->getPost('status'),
        ]);

        return redirect()->to(base_url('dashboard/employees?business_id=' . $business['id']))
            ->with('success', 'Çalışan bilgileri güncellendi.');
    }

    public function toggleStatus(int $id)
    {
        $staff = $this->findStaff($id);
        $business = $this->findManageableBusiness((int) $staff['business_id']);
        $status = ($staff['status'] ?? 'active') === 'active' ? 'passive' : 'active';

        (new BusinessStaffModel())->update($staff['id'], ['status' => $status]);

        return redirect()->to(base_url('dashboard/employees?business_id=' . $business['id']))
            ->with('success', 'Çalışan durumu güncellendi.');
    }

    /**
     * @param array<int, array<string, mixed>> $businesses
     * @return array<string, mixed>|null
     */
    private function selectedBusiness(array $businesses): ?array
    {
        if ($businesses === []) {
            return null;
        }

        $requestedId = (int) $this->request->getGet('business_id');
        foreach ($businesses as $business) {
            if ($requestedId > 0 && (int) $business['id'] === $requestedId) {
                return $business;
            }
        }

        return $businesses[0];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function visibleBusinesses(): array
    {
        $query = (new BusinessModel())->orderBy('businesses.id', 'DESC');

        if (! $this->isAdmin()) {
            $query->accessibleByUser($this->userId(), $this->userEmail());
        }

        return $query->findAll();
    }

    /**
     * @return array<string, mixed>
     */
    private function findManageableBusiness(int $businessId): array
    {
        $query = (new BusinessModel())->where('businesses.id', $businessId);

        if (! $this->isAdmin()) {
            $query->ownedByUser($this->userId());
        }

        $business = $query->first();

        if ($business === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $business;
    }

    /**
     * @return array<string, mixed>
     */
    private function findStaff(int $id): array
    {
        $staff = (new BusinessStaffModel())->find($id);

        if ($staff === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $staff;
    }

    /**
     * @param array<string, mixed> $business
     */
    private function canManageStaff(array $business): bool
    {
        return $this->isAdmin()
            || (int) ($business['owner_user_id'] ?? 0) === $this->userId()
            || (int) ($business['user_id'] ?? 0) === $this->userId();
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

    private function roleLabels(): array
    {
        return [
            'manager' => 'Yönetici',
            'staff'   => 'Çalışan',
        ];
    }

    private function statusLabels(): array
    {
        return [
            'active'  => 'Aktif',
            'passive' => 'Pasif',
        ];
    }
}
