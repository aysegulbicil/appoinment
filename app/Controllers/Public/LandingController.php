<?php

namespace App\Controllers\Public;

use App\Controllers\BaseController;
use App\Libraries\PackageCatalog;
use App\Models\BusinessModel;
use Throwable;

class LandingController extends BaseController
{
    public function index()
    {
        return implode('', [
            view('web/header', ['pageTitle' => 'Randevu — İşletme Yönetimi']),
            view('web/index', [
                'packages' => PackageCatalog::all(),
                'featuredBusinesses' => $this->featuredBusinesses(),
            ]),
            view('web/footer'),
        ]);
    }

    /**
     * @return array<int, array<string, string|null>>
     */
    private function featuredBusinesses(): array
    {
        try {
            $businesses = (new BusinessModel())
                ->select('businesses.name, businesses.slug, businesses.category, businesses.city, businesses.district, businesses.short_description, business_web_settings.cover_image, business_web_settings.intro_image')
                ->join('business_web_settings', 'business_web_settings.business_id = businesses.id', 'left')
                ->where('businesses.is_active', 1)
                ->orderBy('businesses.updated_at', 'DESC')
                ->limit(6)
                ->findAll();
        } catch (Throwable $exception) {
            $businesses = [];
        }

        $businesses = array_filter($businesses, static function (array $business): bool {
            return trim((string) ($business['cover_image'] ?: $business['intro_image'])) !== '';
        });

        return array_values(array_map(static function (array $business): array {
            return [
                'name' => $business['name'] ?? '',
                'slug' => $business['slug'] ?? null,
                'category' => $business['category'] ?? 'Hizmet işletmesi',
                'location' => trim(implode(' / ', array_filter([
                    $business['city'] ?? null,
                    $business['district'] ?? null,
                ]))),
                'description' => trim((string) ($business['short_description'] ?? '')),
                'image' => $business['cover_image'] ?: $business['intro_image'],
            ];
        }, $businesses));
    }
}
