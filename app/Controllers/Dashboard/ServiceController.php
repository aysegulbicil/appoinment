<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\BusinessModel;
use App\Models\BusinessServiceModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ServiceController extends BaseController
{
    public function index(): string
    {
        $businesses = $this->visibleBusinesses();
        $selectedBusiness = $this->selectedBusiness($businesses);
        $services = [];

        if ($selectedBusiness !== null) {
            $services = (new BusinessServiceModel())
                ->where('business_id', $selectedBusiness['id'])
                ->orderBy('id', 'DESC')
                ->findAll();
        }

        return $this->render('dashboard/services/index', [
            'pageTitle'        => 'Hizmetler',
            'businesses'       => $businesses,
            'selectedBusiness' => $selectedBusiness,
            'services'         => $services,
            'statusLabels'     => $this->statusLabels(),
        ]);
    }

    public function store()
    {
        $business = $this->findAccessibleBusiness((int) $this->request->getPost('business_id'));

        if (! $this->validate($this->serviceRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new BusinessServiceModel())->insert([
            'business_id'       => $business['id'],
            'title'             => trim((string) $this->request->getPost('title')),
            'description'       => trim((string) $this->request->getPost('description')),
            'duration_minutes'  => $this->nullableInt('duration_minutes'),
            'price'             => $this->nullableDecimal('price'),
            'status'            => $this->validServiceStatus((string) $this->request->getPost('status')),
        ]);

        return redirect()->to(base_url('dashboard/services?business_id=' . $business['id']))
            ->with('success', 'Hizmet eklendi.');
    }

    public function update(int $serviceId)
    {
        $service = $this->findAccessibleService($serviceId);
        $business = $this->findAccessibleBusiness((int) $service['business_id']);

        if (! $this->validate($this->serviceRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new BusinessServiceModel())->update($service['id'], [
            'title'             => trim((string) $this->request->getPost('title')),
            'description'       => trim((string) $this->request->getPost('description')),
            'duration_minutes'  => $this->nullableInt('duration_minutes'),
            'price'             => $this->nullableDecimal('price'),
            'status'            => $this->validServiceStatus((string) $this->request->getPost('status')),
        ]);

        return redirect()->to(base_url('dashboard/services?business_id=' . $business['id']))
            ->with('success', 'Hizmet güncellendi.');
    }

    public function toggleStatus(int $serviceId)
    {
        $service = $this->findAccessibleService($serviceId);
        $status = ($service['status'] ?? 'active') === 'active' ? 'passive' : 'active';

        (new BusinessServiceModel())->update($service['id'], ['status' => $status]);

        return redirect()->to(base_url('dashboard/services?business_id=' . $service['business_id']))
            ->with('success', 'Hizmet durumu güncellendi.');
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
    private function findAccessibleBusiness(int $businessId): array
    {
        $query = (new BusinessModel())->where('businesses.id', $businessId);

        if (! $this->isAdmin()) {
            $query->accessibleByUser($this->userId(), $this->userEmail());
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
    private function findAccessibleService(int $serviceId): array
    {
        $service = (new BusinessServiceModel())->find($serviceId);

        if ($service === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $this->findAccessibleBusiness((int) $service['business_id']);

        return $service;
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

    private function serviceRules(): array
    {
        return [
            'title'            => 'required|min_length[2]|max_length[160]',
            'description'      => 'permit_empty|max_length[1000]',
            'duration_minutes' => 'permit_empty|integer|greater_than[0]',
            'price'            => 'permit_empty|decimal',
            'status'           => 'permit_empty|in_list[active,passive]',
        ];
    }

    private function validServiceStatus(string $status): string
    {
        return in_array($status, ['active', 'passive'], true) ? $status : 'active';
    }

    private function nullableInt(string $field): ?int
    {
        $value = trim((string) $this->request->getPost($field));

        return $value === '' ? null : (int) $value;
    }

    private function nullableDecimal(string $field): ?string
    {
        $value = trim(str_replace(',', '.', (string) $this->request->getPost($field)));

        return $value === '' ? null : $value;
    }

    private function statusLabels(): array
    {
        return [
            'active'  => 'Aktif',
            'passive' => 'Pasif',
        ];
    }
}
