<?php

namespace App\Controllers\Public;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $data = [
            'pageTitle' => 'Smart Appointment Platform',
            'featuredBusinesses' => [
                [
                    'name' => 'Glow Beauty Studio',
                    'category' => 'Güzellik Salonu',
                    'description' => 'Cilt bakımı, saç ve profesyonel randevu yönetimi.',
                ],
                [
                    'name' => 'Dental Care Plus',
                    'category' => 'Klinik',
                    'description' => 'Hızlı rezervasyon ve uygun saat önerileri.',
                ],
                [
                    'name' => 'Fit Motion PT',
                    'category' => 'Spor & Danışmanlık',
                    'description' => 'Kişisel antrenman ve seans planlama.',
                ],
            ],
        ];

        return view('public/home/index', $data);
    }
}
