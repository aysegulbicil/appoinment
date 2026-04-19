<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Libraries\PackageCatalog;
use App\Models\BusinessModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class SectionController extends BaseController
{
    public function show(string $section): string
    {
        $sections = [
            'business'       => 'İşletmem',
            'services'       => 'Hizmetler',
            'employees'      => 'Çalışanlar',
            'availabilities' => 'Çalışma Saatleri',
            'appointments'   => 'Randevular',
            'settings'       => 'Ayarlar',
        ];

        if (! array_key_exists($section, $sections)) {
            throw PageNotFoundException::forPageNotFound();
        }

        $contentData = [
            'pageTitle'   => $sections[$section],
            'sectionName' => $sections[$section],
            'sectionKey'  => $section,
        ];

        if ($section === 'business') {
            $businessModel   = new BusinessModel();
            $selectedPackage = PackageCatalog::find((string) session()->get('userPackageCode'))
                ?? PackageCatalog::find((string) session()->get(PackageCatalog::SESSION_KEY))
                ?? PackageCatalog::default();

            $contentData['selectedPackage'] = $selectedPackage;
            $contentData['businesses'] = $businessModel
                ->where('user_id', (int) session()->get('userId'))
                ->orderBy('id', 'DESC')
                ->findAll();
        }

        return view('public/home/index', [
            'contentView' => 'dashboard/section',
            'contentData' => $contentData,
        ]);
    }

    public function saveBusiness()
    {
        $rules = [
            'name'     => 'required|min_length[3]|max_length[160]',
            'phone'    => 'permit_empty|min_length[10]|max_length[25]',
            'email'    => 'permit_empty|valid_email|max_length[160]',
            'city'     => 'permit_empty|max_length[100]',
            'district' => 'permit_empty|max_length[100]',
            'address'  => 'permit_empty|max_length[2000]',
            'notes'    => 'permit_empty|max_length[2000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $selectedPackage = PackageCatalog::find((string) session()->get('userPackageCode'))
            ?? PackageCatalog::find((string) session()->get(PackageCatalog::SESSION_KEY))
            ?? PackageCatalog::default();

        $businessModel = new BusinessModel();
        $businessModel->insert([
            'user_id'      => (int) session()->get('userId'),
            'package_code' => $selectedPackage['code'],
            'name'         => (string) $this->request->getPost('name'),
            'phone'        => (string) $this->request->getPost('phone'),
            'email'        => (string) $this->request->getPost('email'),
            'city'         => (string) $this->request->getPost('city'),
            'district'     => (string) $this->request->getPost('district'),
            'address'      => (string) $this->request->getPost('address'),
            'notes'        => (string) $this->request->getPost('notes'),
            'is_active'    => 1,
        ]);

        return redirect()->to(base_url('/business'))
            ->with('success', 'İşletme bilgileri kaydedildi.');
    }
}