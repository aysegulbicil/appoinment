<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\BusinessModel;
use App\Models\BusinessWebPageModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\Files\UploadedFile;

class BusinessWebPageController extends BaseController
{
    public function index(int $businessId): string
    {
        $business = $this->findAccessibleBusiness($businessId);

        $pages = (new BusinessWebPageModel())
            ->where('business_id', $business['id'])
            ->where('deleted_at', null)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();

        return $this->render('dashboard/web/pages/index', [
            'pageTitle' => 'Web Sayfaları',
            'business'  => $business,
            'pages'     => $pages,
        ]);
    }

    public function create(int $businessId): string
    {
        $business = $this->findAccessibleBusiness($businessId);

        return $this->render('dashboard/web/pages/create', [
            'pageTitle'  => 'Sayfa Ekle',
            'business'   => $business,
            'pageTypes'  => $this->pageTypes(),
            'page'       => [
                'page_type' => 'custom',
                'sort_order' => 0,
                'is_active' => 1,
                'is_visible_in_menu' => 1,
            ],
        ]);
    }

    public function store(int $businessId)
    {
        $business = $this->findAccessibleBusiness($businessId);

        if (! $this->validate($this->pageRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new BusinessWebPageModel();
        $pageType = $this->validPageType((string) $this->request->getPost('page_type'));
        if ($pageType !== 'custom' && $this->systemPageExists($business['id'], $pageType)) {
            return redirect()->back()->withInput()->with('errors', [
                'page_type' => 'Bu sayfa tipi için işletmede zaten bir sayfa var.',
            ]);
        }
        $slug = $this->resolveSlug($business['id'], $pageType, (string) $this->request->getPost('slug'));
        $galleryImages = $this->existingGalleryImagesFromInput('retained_gallery_images');

        $coverImage = null;
        $introImage = null;
        $socialImage = null;

        if ($uploaded = $this->request->getFile('cover_image_file')) {
            $coverImage = $this->uploadImageIfValid($business, $uploaded, 'cover');
        }

        if ($uploaded = $this->request->getFile('intro_image_file')) {
            $introImage = $this->uploadImageIfValid($business, $uploaded, 'intro');
        }

        if ($uploaded = $this->request->getFile('social_image_file')) {
            $socialImage = $this->uploadImageIfValid($business, $uploaded, 'social');
        }

        $galleryImages = array_merge($galleryImages, $this->appendGalleryUploads($business));

        $model->insert([
            'business_id'        => $business['id'],
            'title'              => trim((string) $this->request->getPost('title')),
            'slug'               => $slug,
            'page_type'          => $pageType,
            'content'            => $this->sanitizeRichContent((string) $this->request->getPost('content')),
            'short_intro'        => trim((string) $this->request->getPost('short_intro')),
            'cover_image'        => $coverImage,
            'intro_image'        => $introImage,
            'gallery_images'     => $galleryImages === [] ? null : json_encode(array_values($galleryImages), JSON_UNESCAPED_SLASHES),
            'seo_title'          => trim((string) $this->request->getPost('seo_title')) ?: null,
            'seo_description'    => trim((string) $this->request->getPost('seo_description')) ?: null,
            'seo_keywords'       => trim((string) $this->request->getPost('seo_keywords')) ?: null,
            'canonical_url'      => trim((string) $this->request->getPost('canonical_url')) ?: null,
            'social_image'       => $socialImage,
            'menu_label'         => trim((string) $this->request->getPost('menu_label')) ?: null,
            'sort_order'         => (int) ($this->request->getPost('sort_order') ?: 0),
            'is_active'          => $this->checkbox('is_active'),
            'is_visible_in_menu' => $this->checkbox('is_visible_in_menu'),
        ]);

        return redirect()->to(base_url('dashboard/businesses/' . $business['id'] . '/web-pages'))
            ->with('success', 'Sayfa eklendi.');
    }

    public function edit(int $businessId, int $pageId): string
    {
        $business = $this->findAccessibleBusiness($businessId);
        $page     = $this->findOwnedPage($business['id'], $pageId);

        return $this->render('dashboard/web/pages/edit', [
            'pageTitle' => 'Sayfa Düzenle',
            'business'  => $business,
            'page'      => $page,
            'pageTypes' => $this->pageTypes(),
            'galleryImages' => $this->decodeGalleryImages($page['gallery_images'] ?? null),
        ]);
    }

    public function update(int $businessId, int $pageId)
    {
        $business = $this->findAccessibleBusiness($businessId);
        $page     = $this->findOwnedPage($business['id'], $pageId);

        if (! $this->validate($this->pageRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new BusinessWebPageModel();
        $pageType = $this->validPageType((string) $this->request->getPost('page_type'));
        if ($pageType !== 'custom' && $this->systemPageExists($business['id'], $pageType, (int) $page['id'])) {
            return redirect()->back()->withInput()->with('errors', [
                'page_type' => 'Bu sayfa tipi için işletmede zaten bir sayfa var.',
            ]);
        }
        $slug = $this->resolveSlug($business['id'], $pageType, (string) $this->request->getPost('slug'), (int) $page['id']);
        $galleryImages = $this->existingGalleryImagesFromInput('retained_gallery_images');

        $existingCover = $page['cover_image'] ?? null;
        $existingIntro = $page['intro_image'] ?? null;
        $existingSocial = $page['social_image'] ?? null;

        if ($uploaded = $this->request->getFile('cover_image_file')) {
            $uploadedPath = $this->uploadImageIfValid($business, $uploaded, 'cover');
            if ($uploadedPath !== null) {
                $existingCover = $uploadedPath;
            }
        }

        if ($uploaded = $this->request->getFile('intro_image_file')) {
            $uploadedPath = $this->uploadImageIfValid($business, $uploaded, 'intro');
            if ($uploadedPath !== null) {
                $existingIntro = $uploadedPath;
            }
        }

        if ($uploaded = $this->request->getFile('social_image_file')) {
            $uploadedPath = $this->uploadImageIfValid($business, $uploaded, 'social');
            if ($uploadedPath !== null) {
                $existingSocial = $uploadedPath;
            }
        }

        $galleryImages = array_merge($galleryImages, $this->appendGalleryUploads($business));

        $model->update($page['id'], [
            'title'              => trim((string) $this->request->getPost('title')),
            'slug'               => $slug,
            'page_type'          => $pageType,
            'content'            => $this->sanitizeRichContent((string) $this->request->getPost('content')),
            'short_intro'        => trim((string) $this->request->getPost('short_intro')),
            'cover_image'        => $existingCover,
            'intro_image'        => $existingIntro,
            'gallery_images'     => $galleryImages === [] ? null : json_encode(array_values($galleryImages), JSON_UNESCAPED_SLASHES),
            'seo_title'          => trim((string) $this->request->getPost('seo_title')) ?: null,
            'seo_description'    => trim((string) $this->request->getPost('seo_description')) ?: null,
            'seo_keywords'       => trim((string) $this->request->getPost('seo_keywords')) ?: null,
            'canonical_url'      => trim((string) $this->request->getPost('canonical_url')) ?: null,
            'social_image'       => $existingSocial,
            'menu_label'         => trim((string) $this->request->getPost('menu_label')) ?: null,
            'sort_order'         => (int) ($this->request->getPost('sort_order') ?: 0),
            'is_active'          => $this->checkbox('is_active'),
            'is_visible_in_menu' => $this->checkbox('is_visible_in_menu'),
        ]);

        return redirect()->to(base_url('dashboard/businesses/' . $business['id'] . '/web-pages/' . $page['id'] . '/edit'))
            ->with('success', 'Sayfa güncellendi.');
    }

    public function delete(int $businessId, int $pageId)
    {
        $business = $this->findAccessibleBusiness($businessId);
        $page     = $this->findOwnedPage($business['id'], $pageId);

        (new BusinessWebPageModel())->delete($page['id']);

        return redirect()->to(base_url('dashboard/businesses/' . $business['id'] . '/web-pages'))
            ->with('success', 'Sayfa silindi.');
    }

    public function toggleStatus(int $businessId, int $pageId)
    {
        $business = $this->findAccessibleBusiness($businessId);
        $page     = $this->findOwnedPage($business['id'], $pageId);

        (new BusinessWebPageModel())->update($page['id'], [
            'is_active' => ! ((bool) ($page['is_active'] ?? true)),
        ]);

        return redirect()->back()->with('success', 'Sayfa durumu güncellendi.');
    }

    public function toggleMenu(int $businessId, int $pageId)
    {
        $business = $this->findAccessibleBusiness($businessId);
        $page     = $this->findOwnedPage($business['id'], $pageId);

        (new BusinessWebPageModel())->update($page['id'], [
            'is_visible_in_menu' => ! ((bool) ($page['is_visible_in_menu'] ?? true)),
        ]);

        return redirect()->back()->with('success', 'Menü görünürlüğü güncellendi.');
    }

    public function reorder(int $businessId)
    {
        $business = $this->findAccessibleBusiness($businessId);
        $pageIds  = $this->request->getPost('page_ids');
        $orders   = $this->request->getPost('sort_orders');

        if (! is_array($pageIds) || ! is_array($orders)) {
            return redirect()->back()->with('errors', ['sort_order' => 'Sıralama verisi okunamadı.']);
        }

        $model = new BusinessWebPageModel();
        foreach ($pageIds as $index => $pageId) {
            $pageId = (int) $pageId;
            $page   = $this->findOwnedPage($business['id'], $pageId);

            $model->update($page['id'], [
                'sort_order' => (int) ($orders[$index] ?? $index + 1),
            ]);
        }

        return redirect()->back()->with('success', 'Sayfa sırası güncellendi.');
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

    private function findOwnedPage(int $businessId, int $pageId): array
    {
        $page = (new BusinessWebPageModel())
            ->where('business_id', $businessId)
            ->where('id', $pageId)
            ->where('deleted_at', null)
            ->first();

        if ($page === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $page;
    }

    private function uploadImageIfValid(array $business, ?UploadedFile $file, string $prefix): ?string
    {
        if (! $file || ! $file->isValid() || $file->hasMoved()) {
            return null;
        }

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

    private function appendGalleryUploads(array $business): array
    {
        $images = [];
        $uploads = $this->request->getFiles()['gallery_images_files'] ?? [];

        foreach ($uploads as $index => $file) {
            if (! $file || ! $file->isValid() || $file->hasMoved()) {
                continue;
            }

            if (! $this->isAllowedImage($file)) {
                throw PageNotFoundException::forPageNotFound('Gecersiz galeri gorseli.');
            }

            $images[] = $this->uploadImageIfValid($business, $file, 'gallery-' . $index);
        }

        return array_values(array_filter($images));
    }

    private function pageRules(): array
    {
        return [
            'title'              => 'required|min_length[2]|max_length[180]',
            'page_type'          => 'required|in_list[home,about,services,gallery,contact,faq,custom]',
            'slug'               => 'permit_empty|max_length[180]',
            'short_intro'        => 'permit_empty|max_length[1000]',
            'content'            => 'permit_empty',
            'seo_title'          => 'permit_empty|max_length[180]',
            'seo_description'    => 'permit_empty|max_length[1000]',
            'seo_keywords'       => 'permit_empty|max_length[1000]',
            'canonical_url'      => 'permit_empty|valid_url_strict|max_length[255]',
            'menu_label'         => 'permit_empty|max_length[120]',
            'sort_order'         => 'permit_empty|integer',
        ];
    }

    private function validPageType(string $pageType): string
    {
        return array_key_exists($pageType, $this->pageTypes()) ? $pageType : 'custom';
    }

    private function systemPageExists(int $businessId, string $pageType, ?int $ignoreId = null): bool
    {
        $query = (new BusinessWebPageModel())
            ->where('business_id', $businessId)
            ->where('page_type', $pageType)
            ->where('deleted_at', null);

        if ($ignoreId !== null) {
            $query->where('id !=', $ignoreId);
        }

        return $query->countAllResults() > 0;
    }

    private function pageTypes(): array
    {
        return [
            'home'     => 'Ana Sayfa',
            'about'    => 'Hakkımızda',
            'services' => 'Hizmetler',
            'gallery'  => 'Galeri',
            'contact'  => 'İletişim',
            'faq'      => 'SSS',
            'custom'   => 'Özel Sayfa',
        ];
    }

    private function resolveSlug(int $businessId, string $pageType, string $rawSlug, ?int $ignoreId = null): string
    {
        $systemSlugs = [
            'home'     => 'anasayfa',
            'about'    => 'hakkimizda',
            'services' => 'hizmetler',
            'gallery'  => 'galeri',
            'contact'  => 'iletisim',
            'faq'      => 'sss',
        ];

        $baseSlug = $systemSlugs[$pageType] ?? '';
        if ($baseSlug === '') {
            $baseSlug = url_title($rawSlug !== '' ? $rawSlug : (string) $this->request->getPost('title'), '-', true);
        }

        if ($baseSlug === '') {
            $baseSlug = 'sayfa';
        }

        if ($pageType !== 'custom' && isset($systemSlugs[$pageType])) {
            return $this->uniqueSlug($businessId, $baseSlug, $ignoreId);
        }

        return $this->uniqueSlug($businessId, $baseSlug, $ignoreId);
    }

    private function uniqueSlug(int $businessId, string $baseSlug, ?int $ignoreId = null): string
    {
        $model = new BusinessWebPageModel();
        $slug = $baseSlug;
        $counter = 1;

        while (true) {
            $query = $model->where('business_id', $businessId)->where('slug', $slug)->where('deleted_at', null);
            if ($ignoreId !== null) {
                $query->where('id !=', $ignoreId);
            }

            if ($query->countAllResults() === 0) {
                return $slug;
            }

            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
    }

    private function existingGalleryImagesFromInput(string $field): array
    {
        $rawValue = $this->request->getPost($field);
        if (is_array($rawValue)) {
            return array_values(array_filter(array_map(static fn ($item) => trim((string) $item), $rawValue)));
        }

        $decoded = json_decode((string) $rawValue, true);
        if (! is_array($decoded)) {
            return [];
        }

        return array_values(array_filter(array_map(static fn ($item) => trim((string) $item), $decoded)));
    }

    private function decodeGalleryImages(?string $rawValue): array
    {
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

    private function sanitizeRichContent(string $content): string
    {
        $content = preg_replace('#<(script|style|iframe|object|embed)\b[^>]*>.*?</\1>#is', '', $content) ?? '';
        $allowed = '<p><br><strong><b><em><i><u><s><h1><h2><h3><h4><h5><h6><ul><ol><li><blockquote><a><img><figure><figcaption><table><thead><tbody><tfoot><tr><th><td><hr><span><div><pre><code>';
        $content = strip_tags($content, $allowed);
        $content = preg_replace('/\s+on[a-z]+\s*=\s*(".*?"|\'.*?\'|[^\s>]+)/i', '', $content) ?? '';
        $content = preg_replace('/(href|src)\s*=\s*([\'"])\s*javascript:.*?\2/i', '$1="#"', $content) ?? '';

        return trim($content);
    }

    private function isAllowedImage(UploadedFile $file): bool
    {
        $extension = strtolower($file->getExtension() ?: $file->guessExtension() ?: '');

        return in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)
            && str_starts_with((string) $file->getMimeType(), 'image/');
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
