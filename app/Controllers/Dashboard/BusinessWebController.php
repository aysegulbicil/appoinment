<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\BusinessModel;

class BusinessWebController extends BaseController
{
    public function index(): string
    {
        $query = (new BusinessModel())->orderBy('id', 'DESC');

        if (! $this->isAdmin()) {
            $query->accessibleByUser($this->userId(), $this->userEmail());
        }

        return $this->render('dashboard/web/index', [
            'pageTitle'  => 'Web Ayarları',
            'businesses' => $query->findAll(),
        ]);
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
}
