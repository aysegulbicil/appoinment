<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Libraries\PackageCatalog;
use App\Models\BusinessModel;
use App\Models\BusinessServiceModel;
use App\Models\BusinessWebSettingModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\Files\UploadedFile;

class BusinessController extends BaseController
{
    public function legacyRedirect()
    {
        return redirect()->to(base_url('dashboard/businesses'));
    }

    public function index(): string
    {
        $businessQuery = (new BusinessModel())->orderBy('id', 'DESC');

        if (! $this->isAdmin()) {
            $businessQuery->forOwner($this->userId());
        }

        $businesses = $businessQuery->findAll();

        return $this->render('dashboard/businesses/index', [
            'pageTitle'       => 'Isletmelerim',
            'businesses'      => $businesses,
            'selectedPackage' => $this->selectedPackage(),
            'pageStyles'      => '<link href="' . base_url('assets/vendor/datatables/css/jquery.dataTables.min.css') . '" rel="stylesheet">',
            'pageScripts'     => '<script src="' . base_url('assets/vendor/datatables/js/jquery.dataTables.min.js') . '"></script>' . PHP_EOL
                . '<script src="' . base_url('assets/js/plugins-init/datatables.init.js') . '"></script>',
        ]);
    }

    public function create(): string
    {
        return $this->render('dashboard/businesses/create', [
            'pageTitle'       => 'Yeni Isletme Ekle',
            'categories'      => $this->categories(),
            'selectedPackage' => $this->selectedPackage(),
        ]);
    }

    public function store()
    {
        if (! $this->validate($this->businessRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model   = new BusinessModel();
        $package = $this->selectedPackage();
        $name    = trim((string) $this->request->getPost('name'));
        $category = $this->resolveCategory();

        $businessId = $model->insert([
            'user_id'           => $this->userId(),
            'owner_user_id'     => $this->userId(),
            'package_code'      => $package['code'],
            'name'              => $name,
            'slug'              => $this->createUniqueSlug($name),
            'category'          => $category,
            'phone'             => trim((string) $this->request->getPost('phone')),
            'email'             => trim((string) $this->request->getPost('email')),
            'city'              => trim((string) $this->request->getPost('city')),
            'district'          => trim((string) $this->request->getPost('district')),
            'short_description' => trim((string) $this->request->getPost('short_description')),
            'status'            => 'active',
            'is_active'         => 1,
        ], true);

        (new BusinessWebSettingModel())->insert([
            'business_id'    => $businessId,
            'page_title'     => $name,
            'short_intro'    => trim((string) $this->request->getPost('short_description')),
            'show_services'  => 1,
            'show_staff'     => 1,
            'show_prices'    => 1,
            'show_contact'   => 1,
            'show_map'       => 0,
        ]);

        return redirect()->to(base_url('dashboard/businesses'))
            ->with('success', 'Isletme basariyla olusturuldu.');
    }

    public function show(int $id): string
    {
        $business = $this->findOwnedBusiness($id);
        $tab      = (string) ($this->request->getGet('tab') ?: 'general');

        if (! in_array($tab, ['general', 'web-settings', 'services', 'staff'], true)) {
            $tab = 'general';
        }

        return $this->render('dashboard/businesses/show', [
            'pageTitle'       => 'Isletme Detayi',
            'business'        => $business,
            'webSettings'     => $this->webSettings($id),
            'services'        => $this->businessServices($id),
            'currentTab'      => $tab,
            'categories'      => $this->categories(),
            'selectedPackage' => $this->selectedPackage(),
        ]);
    }

    public function update(int $id)
    {
        $business = $this->findOwnedBusiness($id);
        $section  = (string) $this->request->getPost('section');

        if ($section === 'web_settings') {
            return $this->updateWebSettings($business);
        }

        return $this->updateGeneral($business);
    }

    public function toggleStatus(int $id)
    {
        $business = $this->findOwnedBusiness($id);
        $status   = ($business['status'] ?? 'active') === 'active' ? 'passive' : 'active';

        (new BusinessModel())->update($id, [
            'status'    => $status,
            'is_active' => $status === 'active' ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Isletme durumu guncellendi.');
    }

    public function uploadEditorImage(int $id)
    {
        $business = $this->findOwnedBusiness($id);
        $file     = $this->request->getFile('file');

        if (! $file || ! $file->isValid() || $file->hasMoved() || ! $this->isAllowedImage($file)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['error' => 'Gecersiz gorsel dosyasi.']);
        }

        $path = $this->storeBusinessAsset($business, $file, 'editor');

        return $this->response->setJSON([
            'location' => base_url($path),
        ]);
    }

    public function storeService(int $businessId)
    {
        $business = $this->findOwnedBusiness($businessId);

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

        return redirect()->to(base_url('dashboard/businesses/' . $business['id'] . '?tab=services'))
            ->with('success', 'Hizmet eklendi.');
    }

    public function updateService(int $serviceId)
    {
        $service = $this->findOwnedService($serviceId);
        $business = $this->findOwnedBusiness((int) $service['business_id']);

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

        return redirect()->to(base_url('dashboard/businesses/' . $business['id'] . '?tab=services'))
            ->with('success', 'Hizmet guncellendi.');
    }

    public function toggleServiceStatus(int $serviceId)
    {
        $service = $this->findOwnedService($serviceId);
        $status = ($service['status'] ?? 'active') === 'active' ? 'passive' : 'active';

        (new BusinessServiceModel())->update($service['id'], ['status' => $status]);

        return redirect()->to(base_url('dashboard/businesses/' . $service['business_id'] . '?tab=services'))
            ->with('success', 'Hizmet durumu guncellendi.');
    }

    private function updateGeneral(array $business)
    {
        if (! $this->validate($this->businessRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $status = (string) $this->request->getPost('status');
        if (! in_array($status, ['active', 'passive'], true)) {
            $status = 'active';
        }

        (new BusinessModel())->update($business['id'], [
            'name'              => trim((string) $this->request->getPost('name')),
            'category'          => $this->resolveCategory(),
            'phone'             => trim((string) $this->request->getPost('phone')),
            'email'             => trim((string) $this->request->getPost('email')),
            'city'              => trim((string) $this->request->getPost('city')),
            'district'          => trim((string) $this->request->getPost('district')),
            'short_description' => trim((string) $this->request->getPost('short_description')),
            'status'            => $status,
            'is_active'         => $status === 'active' ? 1 : 0,
        ]);

        return redirect()->to(base_url('dashboard/businesses/' . $business['id'] . '?tab=general'))
            ->with('success', 'Genel bilgiler guncellendi.');
    }

    private function updateWebSettings(array $business)
    {
        $rules = [
            'page_title'  => 'permit_empty|max_length[180]',
            'short_intro' => 'permit_empty|max_length[1000]',
            'content'     => 'permit_empty',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $settings = $this->webSettings((int) $business['id']);
        $coverImage = $settings['cover_image'] ?? null;
        $introImage = $settings['intro_image'] ?? null;

        $uploadedCover = $this->request->getFile('cover_image_file');
        if ($uploadedCover && $uploadedCover->isValid() && ! $uploadedCover->hasMoved()) {
            if (! $this->isAllowedImage($uploadedCover)) {
                return redirect()->back()->withInput()->with('errors', ['cover_image_file' => 'Kapak gorseli jpg, png, webp veya gif olmalidir.']);
            }

            $coverImage = $this->storeBusinessAsset($business, $uploadedCover, 'cover');
        }

        $uploadedIntro = $this->request->getFile('intro_image_file');
        if ($uploadedIntro && $uploadedIntro->isValid() && ! $uploadedIntro->hasMoved()) {
            if (! $this->isAllowedImage($uploadedIntro)) {
                return redirect()->back()->withInput()->with('errors', ['intro_image_file' => 'Tanitim gorseli jpg, png, webp veya gif olmalidir.']);
            }

            $introImage = $this->storeBusinessAsset($business, $uploadedIntro, 'intro');
        }

        $retainedGallery = $this->normalizeGalleryImages($this->request->getPost('retained_gallery_images'));
        $galleryUploads   = $this->request->getFiles()['gallery_images_files'] ?? [];

        foreach ($galleryUploads as $index => $galleryFile) {
            if (! $galleryFile || ! $galleryFile->isValid() || $galleryFile->hasMoved()) {
                continue;
            }

            if (! $this->isAllowedImage($galleryFile)) {
                return redirect()->back()->withInput()->with('errors', ['gallery_images_files' => 'Galeri gorselleri jpg, png, webp veya gif olmalidir.']);
            }

            $retainedGallery[] = $this->storeBusinessAsset($business, $galleryFile, 'gallery-' . $index);
        }

        (new BusinessWebSettingModel())->update($settings['id'], [
            'page_title'    => trim((string) $this->request->getPost('page_title')),
            'short_intro'   => trim((string) $this->request->getPost('short_intro')),
            'content'       => $this->sanitizeRichContent((string) $this->request->getPost('content')),
            'cover_image'   => $coverImage,
            'intro_image'   => $introImage,
            'gallery_images' => $retainedGallery === [] ? null : json_encode(array_values($retainedGallery), JSON_UNESCAPED_SLASHES),
            'show_services' => $this->checkbox('show_services'),
            'show_staff'    => $this->checkbox('show_staff'),
            'show_prices'   => $this->checkbox('show_prices'),
            'show_contact'  => $this->checkbox('show_contact'),
            'show_map'      => $this->checkbox('show_map'),
        ]);

        return redirect()->to(base_url('dashboard/businesses/' . $business['id'] . '?tab=web-settings'))
            ->with('success', 'Web ayarlari kaydedildi.');
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

    private function isAdmin(): bool
    {
        return (string) session()->get('userRole') === 'admin';
    }

    private function findOwnedBusiness(int $id): array
    {
        $query = (new BusinessModel())->where('id', $id);

        if (! $this->isAdmin()) {
            $query->forOwner($this->userId());
        }

        $business = $query->first();

        if ($business === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $business;
    }

    private function findOwnedService(int $serviceId): array
    {
        $service = (new BusinessServiceModel())->find($serviceId);

        if ($service === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $this->findOwnedBusiness((int) $service['business_id']);

        return $service;
    }

    private function businessServices(int $businessId): array
    {
        return (new BusinessServiceModel())
            ->where('business_id', $businessId)
            ->orderBy('id', 'DESC')
            ->findAll();
    }

    private function webSettings(int $businessId): array
    {
        $model    = new BusinessWebSettingModel();
        $settings = $model->where('business_id', $businessId)->first();

        if ($settings !== null) {
            return $settings;
        }

        $id = $model->insert([
            'business_id'   => $businessId,
            'show_services' => 1,
            'show_staff'    => 1,
            'show_prices'   => 1,
            'show_contact'  => 1,
            'show_map'      => 0,
        ], true);

        return $model->find($id) ?? [];
    }

    private function checkbox(string $field): int
    {
        return $this->request->getPost($field) ? 1 : 0;
    }

    private function storeBusinessAsset(array $business, UploadedFile $file, string $prefix): string
    {
        if (! $this->isAllowedImage($file)) {
            throw PageNotFoundException::forPageNotFound('Gecersiz gorsel dosyasi.');
        }

        $targetDirectory = FCPATH . 'uploads/businesses/' . ($business['slug'] ?? $business['id']);

        if (! is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        $extension = $file->getExtension() ?: $file->guessExtension() ?: 'jpg';
        $fileName  = $prefix . '-' . date('YmdHis') . '-' . bin2hex(random_bytes(4)) . '.' . strtolower($extension);

        $file->move($targetDirectory, $fileName, true);

        return 'uploads/businesses/' . ($business['slug'] ?? $business['id']) . '/' . $fileName;
    }

    private function isAllowedImage(UploadedFile $file): bool
    {
        $extension = strtolower($file->getExtension() ?: $file->guessExtension() ?: '');

        return in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)
            && str_starts_with((string) $file->getMimeType(), 'image/');
    }

    private function sanitizeRichContent(string $content): string
    {
        $content = preg_replace('#<(script|style|iframe|object|embed)\b[^>]*>.*?</\1>#is', '', $content) ?? '';
        $allowed = '<p><br><strong><b><em><i><u><s><h1><h2><h3><h4><h5><h6><ul><ol><li><blockquote><a><img><figure><figcaption><table><thead><tbody><tfoot><tr><th><td><hr><span><div><pre><code>';
        $content = strip_tags($content, $allowed);
        $content = preg_replace('/\s+on[a-z]+\s*=\s*(".*?"|\'.*?\'|[^\s>]+)/i', '', $content) ?? '';
        $content = preg_replace('/(href|src)\s*=\s*([\'"])\s*javascript:.*?\2/i', '$1="#"', $content) ?? '';

        return trim($content);
    }

    private function normalizeGalleryImages($rawValue): array
    {
        if (is_array($rawValue)) {
            return array_values(array_filter(array_map(static fn ($item) => trim((string) $item), $rawValue)));
        }

        $rawValue = trim((string) $rawValue);
        if ($rawValue === '') {
            return [];
        }

        $decoded = json_decode($rawValue, true);
        if (! is_array($decoded)) {
            return [];
        }

        return array_values(array_filter(array_map(static fn ($item) => trim((string) $item), $decoded)));
    }

    private function createUniqueSlug(string $name): string
    {
        $model = new BusinessModel();
        $base  = url_title($name, '-', true);

        if ($base === '') {
            $base = 'business';
        }

        $slug    = $base;
        $counter = 1;

        while ($model->where('slug', $slug)->countAllResults() > 0) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function selectedPackage(): array
    {
        return PackageCatalog::find((string) session()->get('userPackageCode'))
            ?? PackageCatalog::find((string) session()->get(PackageCatalog::SESSION_KEY))
            ?? PackageCatalog::default();
    }

    private function categories(): array
    {
        return [
            'Kuafor',
            'Guzellik Merkezi',
            'Klinik',
            'Dis Klinigi',
            'Psikolog',
            'Spor Salonu',
            'Veteriner',
            'Danismanlik',
            'Oto Servis',
            'Diger',
        ];
    }

    private function businessRules(): array
    {
        return [
            'name'              => 'required|min_length[3]|max_length[160]',
            'category'          => 'required|max_length[120]',
            'custom_category'   => 'permit_empty|max_length[120]',
            'phone'             => 'required|min_length[10]|max_length[25]',
            'email'             => 'required|valid_email|max_length[160]',
            'city'              => 'required|max_length[100]',
            'district'          => 'permit_empty|max_length[100]',
            'short_description' => 'permit_empty|max_length[1000]',
        ];
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

    private function resolveCategory(): string
    {
        $category = trim((string) $this->request->getPost('category'));
        $custom   = trim((string) $this->request->getPost('custom_category'));

        if ($category === 'Diger' && $custom !== '') {
            return $custom;
        }

        return $category;
    }
}
