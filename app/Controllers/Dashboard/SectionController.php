<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
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

        return view('public/home/index', [
            'contentView' => 'dashboard/section',
            'contentData' => [
                'pageTitle'   => $sections[$section],
                'sectionName' => $sections[$section],
            ],
        ]);
    }
}
