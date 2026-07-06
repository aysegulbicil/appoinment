<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\BusinessModel;
use App\Models\BusinessWebSettingModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\Files\UploadedFile;

class BusinessWebSettingController extends BaseController
{
    public function index(int $businessId): string
    {
        $business = $this->findAccessibleBusiness($businessId);

        return $this->render('dashboard/web/settings/index', [
            'pageTitle' => 'Web Ayarları',
            'business'  => $business,
            'settings'  => $this->webSettings($business['id']),
        ]);
    }

    public function general(int $businessId): string
    {
        $business = $this->findAccessibleBusiness($businessId);

        return $this->render('dashboard/web/settings/general', [
            'pageTitle' => 'Genel Ayarlar',
            'business'  => $business,
            'settings'  => $this->webSettings($business['id']),
        ]);
    }

    public function menu(int $businessId): string
    {
        $business = $this->findAccessibleBusiness($businessId);

        return $this->render('dashboard/web/settings/menu', [
            'pageTitle' => 'Menü Ayarları',
            'business'  => $business,
            'settings'  => $this->webSettings($business['id']),
        ]);
    }

    public function seo(int $businessId): string
    {
        $business = $this->findAccessibleBusiness($businessId);

        return $this->render('dashboard/web/settings/seo', [
            'pageTitle' => 'SEO Ayarları',
            'business'  => $business,
            'settings'  => $this->webSettings($business['id']),
        ]);
    }

    public function updateGeneral(int $businessId)
    {
        $business = $this->findAccessibleBusiness($businessId);

        if (! $this->validate([
            'site_title'       => 'permit_empty|max_length[180]',
            'site_description' => 'permit_empty|max_length[2000]',
            'footer_text'      => 'permit_empty|max_length[2000]',
            'primary_color'    => 'permit_empty|max_length[24]',
            'secondary_color'  => 'permit_empty|max_length[24]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $settings = $this->webSettings($business['id']);
        $logoImage = $settings['logo_image'] ?? null;

        if ($uploaded = $this->request->getFile('logo_image_file')) {
            $uploadedPath = $this->uploadImageIfValid($business, $uploaded, 'logo');
            if ($uploadedPath !== null) {
                $logoImage = $uploadedPath;
            }
        }

        (new BusinessWebSettingModel())->update($settings['id'], [
            'site_title'      => trim((string) $this->request->getPost('site_title')) ?: null,
            'site_description'=> trim((string) $this->request->getPost('site_description')) ?: null,
            'logo_image'      => $logoImage,
            'footer_text'     => trim((string) $this->request->getPost('footer_text')) ?: null,
            'primary_color'   => trim((string) $this->request->getPost('primary_color')) ?: null,
            'secondary_color' => trim((string) $this->request->getPost('secondary_color')) ?: null,
        ]);

        return redirect()->to(base_url('dashboard/businesses/' . $business['id'] . '/web-settings/general'))
            ->with('success', 'Genel ayarlar kaydedildi.');
    }

    public function updateMenu(int $businessId)
    {
        $business = $this->findAccessibleBusiness($businessId);

        if (! $this->validate([
            'show_services' => 'permit_empty',
            'show_staff'    => 'permit_empty',
            'show_prices'   => 'permit_empty',
            'show_contact'  => 'permit_empty',
            'show_map'      => 'permit_empty',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $settings = $this->webSettings($business['id']);

        (new BusinessWebSettingModel())->update($settings['id'], [
            'show_services' => $this->checkbox('show_services'),
            'show_staff'    => $this->checkbox('show_staff'),
            'show_prices'   => $this->checkbox('show_prices'),
            'show_contact'  => $this->checkbox('show_contact'),
            'show_map'      => $this->checkbox('show_map'),
        ]);

        return redirect()->to(base_url('dashboard/businesses/' . $business['id'] . '/web-settings/menu'))
            ->with('success', 'Menü ayarları kaydedildi.');
    }

    public function updateSeo(int $businessId)
    {
        $business = $this->findAccessibleBusiness($businessId);

        if (! $this->validate([
            'default_seo_title'       => 'permit_empty|max_length[180]',
            'default_seo_description' => 'permit_empty|max_length[2000]',
            'default_seo_keywords'    => 'permit_empty|max_length[2000]',
            'canonical_url'           => 'permit_empty|valid_url_strict|max_length[255]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $settings = $this->webSettings($business['id']);
        $socialImage = $settings['default_social_image'] ?? null;

        if ($uploaded = $this->request->getFile('default_social_image_file')) {
            $uploadedPath = $this->uploadImageIfValid($business, $uploaded, 'seo-social');
            if ($uploadedPath !== null) {
                $socialImage = $uploadedPath;
            }
        }

        (new BusinessWebSettingModel())->update($settings['id'], [
            'default_seo_title'       => trim((string) $this->request->getPost('default_seo_title')) ?: null,
            'default_seo_description' => trim((string) $this->request->getPost('default_seo_description')) ?: null,
            'default_seo_keywords'    => trim((string) $this->request->getPost('default_seo_keywords')) ?: null,
            'default_social_image'     => $socialImage,
        ]);

        return redirect()->to(base_url('dashboard/businesses/' . $business['id'] . '/web-settings/seo'))
            ->with('success', 'SEO ayarları kaydedildi.');
    }

    private function findAccessibleBusiness(int $id): array
    {
        $query = (new BusinessModel())->where('businesses.id', $id);

        if (! $this->isAdmin()) {
            $query->accessibleByUser($this->userId(), $this->userEmail());
        }

        $business = $query->first();

        if ($business === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $business;
    }

    private function webSettings(int $businessId): array
    {
        $model = new BusinessWebSettingModel();
        $settings = $model->where('business_id', $businessId)->first();

        if ($settings !== null) {
            return $settings;
        }

        $id = $model->insert([
            'business_id'   => $businessId,
            'show_services'  => 1,
            'show_staff'     => 1,
            'show_prices'    => 1,
            'show_contact'   => 1,
            'show_map'       => 0,
        ], true);

        return $model->find($id) ?? [];
    }

    private function uploadImageIfValid(array $business, ?UploadedFile $file, string $prefix): ?string
    {
        if (! $file || ! $file->isValid() || $file->hasMoved()) {
            return null;
        }

        $extension = strtolower($file->getExtension() ?: $file->guessExtension() ?: '');
        if (! in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true) || ! str_starts_with((string) $file->getMimeType(), 'image/')) {
            return null;
        }

        $targetDirectory = FCPATH . 'uploads/businesses/' . ($business['slug'] ?? $business['id']);
        if (! is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        $fileName = $prefix . '-' . date('YmdHis') . '-' . bin2hex(random_bytes(4)) . '.' . $extension;
        $file->move($targetDirectory, $fileName, true);

        return 'uploads/businesses/' . ($business['slug'] ?? $business['id']) . '/' . $fileName;
    }

    private function checkbox(string $field): int
    {
        return $this->request->getPost($field) ? 1 : 0;
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
