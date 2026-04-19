<?php

namespace App\Controllers\Public;

use App\Controllers\BaseController;
use App\Models\BusinessModel;
use App\Models\BusinessWebSettingModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class BusinessController extends BaseController
{
    public function index(): string
    {
        $businesses = (new BusinessModel())
            ->select('businesses.*, business_web_settings.page_title, business_web_settings.short_intro, business_web_settings.cover_image, business_web_settings.intro_image')
            ->join('business_web_settings', 'business_web_settings.business_id = businesses.id', 'left')
            ->groupStart()
            ->where('status', 'active')
            ->orWhere('is_active', 1)
            ->groupEnd()
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('web/businesses/index', [
            'pageTitle'  => 'Isletmeler',
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

        $webSettings = (new BusinessWebSettingModel())
            ->where('business_id', $business['id'])
            ->first();

        return view('web/businesses/show', [
            'pageTitle'   => $webSettings['page_title'] ?? $business['name'],
            'business'    => $business,
            'webSettings' => $webSettings ?? [],
            'galleryImages' => $this->decodeGalleryImages($webSettings['gallery_images'] ?? null),
        ]);
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
}
