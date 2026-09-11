<?php

namespace App\Controllers\Public;

use App\Controllers\BaseController;
use App\Models\AppointmentModel;
use App\Models\BusinessModel;
use App\Models\BusinessServiceModel;
use App\Models\BusinessWebSettingModel;
use App\Models\BusinessWebPageModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Throwable;

class BusinessController extends BaseController
{
    public function index(): string
    {
        try {
            $businesses = (new BusinessModel())
                ->select('businesses.*, business_web_settings.page_title, business_web_settings.short_intro, business_web_settings.cover_image, business_web_settings.intro_image')
                ->join('business_web_settings', 'business_web_settings.business_id = businesses.id', 'left')
                ->groupStart()
                ->where('status', 'active')
                ->orWhere('is_active', 1)
                ->groupEnd()
                ->orderBy('id', 'DESC')
                ->findAll();
        } catch (Throwable $exception) {
            $businesses = [];
        }

        return view('web/businesses/index', [
            'pageTitle'  => 'İşletmeler — Randevu',
            'businesses' => $businesses,
        ]);
    }

    public function show(string $identifier): string
    {
        $businessQuery = (new BusinessModel())
            ->groupStart()
            ->where('status', 'active')
            ->orWhere('is_active', 1)
            ->groupEnd();

        if (ctype_digit($identifier)) {
            $businessQuery->where('id', (int) $identifier);
        } else {
            $businessQuery->where('slug', $identifier);
        }

        $business = $businessQuery->first();

        if ($business === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $pages = $this->visiblePages((int) $business['id']);
        $currentPage = $this->resolveDefaultPage($pages);
        $webSettings = $this->webSettings((int) $business['id']);

        if ($pages === []) {
            $services = (new BusinessServiceModel())
                ->where('business_id', $business['id'])
                ->where('status', 'active')
                ->orderBy('title', 'ASC')
                ->findAll();

            return view('web/businesses/show', [
                'pageTitle'     => $webSettings['page_title'] ?? $business['name'],
                'business'      => $business,
                'webSettings'   => $webSettings ?? [],
                'services'      => $services,
                'galleryImages' => $this->decodeGalleryImages($webSettings['gallery_images'] ?? null),
                'pages'         => [],
                'currentPage'   => null,
            ]);
        }

        return view('web/businesses/show', [
            'pageTitle'   => $this->resolvePageTitle($currentPage, $business, $webSettings),
            'business'    => $business,
            'webSettings' => $webSettings ?? [],
            'pages'       => $pages,
            'currentPage' => $currentPage,
            'pageSeo'     => $this->pageSeo($currentPage, $webSettings),
            'galleryImages' => $this->decodeGalleryImages($currentPage['gallery_images'] ?? null),
            'services'    => $this->businessServices((int) $business['id']),
        ]);
    }

    public function page(string $identifier, string $pageSlug): string
    {
        $businessQuery = (new BusinessModel())
            ->groupStart()
            ->where('status', 'active')
            ->orWhere('is_active', 1)
            ->groupEnd();

        if (ctype_digit($identifier)) {
            $businessQuery->where('id', (int) $identifier);
        } else {
            $businessQuery->where('slug', $identifier);
        }

        $business = $businessQuery->first();

        if ($business === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $pages = $this->visiblePages((int) $business['id']);
        $currentPage = null;
        foreach ($pages as $page) {
            if ((string) ($page['slug'] ?? '') === $pageSlug) {
                $currentPage = $page;
                break;
            }
        }

        if ($currentPage === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $webSettings = $this->webSettings((int) $business['id']);

        return view('web/businesses/show', [
            'pageTitle'   => $this->resolvePageTitle($currentPage, $business, $webSettings),
            'business'    => $business,
            'webSettings' => $webSettings ?? [],
            'pages'       => $pages,
            'currentPage' => $currentPage,
            'pageSeo'     => $this->pageSeo($currentPage, $webSettings),
            'galleryImages' => $this->decodeGalleryImages($currentPage['gallery_images'] ?? null),
            'services'    => $this->businessServices((int) $business['id']),
        ]);
    }

    public function storeAppointment(int $businessId)
    {
        $business = (new BusinessModel())
            ->where('id', $businessId)
            ->groupStart()
            ->where('status', 'active')
            ->orWhere('is_active', 1)
            ->groupEnd()
            ->first();

        if ($business === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'business_service_id' => 'required|integer',
            'customer_name'       => 'required|min_length[3]|max_length[140]',
            'customer_phone'      => 'required|min_length[10]|max_length[25]',
            'customer_email'      => 'required|valid_email|max_length[160]',
            'appointment_date'    => 'required|valid_date[Y-m-d]',
            'appointment_time'    => 'required|regex_match[/^([01][0-9]|2[0-3]):[0-5][0-9]$/]',
            'note'                => 'permit_empty|max_length[1000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('appointment_errors', $this->validator->getErrors());
        }

        $service = (new BusinessServiceModel())
            ->where('id', (int) $this->request->getPost('business_service_id'))
            ->where('business_id', $business['id'])
            ->where('status', 'active')
            ->first();

        if ($service === null) {
            return redirect()->back()->withInput()->with('appointment_errors', [
                'business_service_id' => 'Gecerli bir hizmet secmelisiniz.',
            ]);
        }

        $appointmentCode = $this->createAppointmentCode();

        (new AppointmentModel())->insert([
            'business_id'          => $business['id'],
            'business_service_id'  => $service['id'],
            'user_id'              => session()->get('isLoggedIn') ? (int) session()->get('userId') : null,
            'appointment_code'     => $appointmentCode,
            'customer_name'        => trim((string) $this->request->getPost('customer_name')),
            'customer_phone'       => trim((string) $this->request->getPost('customer_phone')),
            'customer_email'       => trim((string) $this->request->getPost('customer_email')),
            'appointment_date'     => (string) $this->request->getPost('appointment_date'),
            'appointment_time'     => (string) $this->request->getPost('appointment_time') . ':00',
            'note'                 => trim((string) $this->request->getPost('note')),
            'status'               => 'pending',
        ]);

        return redirect()->back()->with('appointment_success', 'Randevu talebiniz alindi. Randevu kodunuz: ' . $appointmentCode);
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

    private function visiblePages(int $businessId): array
    {
        return (new BusinessWebPageModel())
            ->where('business_id', $businessId)
            ->where('is_active', 1)
            ->where('deleted_at', null)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();
    }

    private function resolveDefaultPage(array $pages): ?array
    {
        foreach ($pages as $page) {
            if (($page['page_type'] ?? '') === 'home' || ($page['slug'] ?? '') === 'anasayfa') {
                return $page;
            }
        }

        return $pages[0] ?? null;
    }

    private function resolvePageTitle(?array $page, array $business, array $webSettings): string
    {
        if ($page !== null && trim((string) ($page['seo_title'] ?? '')) !== '') {
            return (string) $page['seo_title'];
        }

        if ($page !== null && trim((string) ($page['title'] ?? '')) !== '') {
            return (string) $page['title'];
        }

        return (string) ($webSettings['page_title'] ?? $business['name']);
    }

    private function pageSeo(?array $page, array $webSettings): array
    {
        if ($page === null) {
            return [];
        }

        return [
            'title'       => $page['seo_title'] ?? $webSettings['default_seo_title'] ?? $page['title'] ?? null,
            'description' => $page['seo_description'] ?? $webSettings['default_seo_description'] ?? $page['short_intro'] ?? null,
            'keywords'    => $page['seo_keywords'] ?? $webSettings['default_seo_keywords'] ?? null,
            'canonical'   => $page['canonical_url'] ?? null,
            'image'       => $page['social_image'] ?? $webSettings['default_social_image'] ?? $page['cover_image'] ?? null,
        ];
    }

    private function webSettings(int $businessId): array
    {
        $settings = (new BusinessWebSettingModel())
            ->where('business_id', $businessId)
            ->first();

        return $settings ?? [];
    }

    private function businessServices(int $businessId): array
    {
        return (new BusinessServiceModel())
            ->where('business_id', $businessId)
            ->where('status', 'active')
            ->orderBy('title', 'ASC')
            ->findAll();
    }

    private function createAppointmentCode(): string
    {
        $model = new AppointmentModel();

        do {
            $code = 'RND-' . strtoupper(bin2hex(random_bytes(3)));
        } while ($model->where('appointment_code', $code)->countAllResults() > 0);

        return $code;
    }
}
