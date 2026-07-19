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
            view('web/header', ['pageTitle' => 'Akıllı Randevu Yönetim Sistemi']),
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

        if ($businesses === []) {
            return $this->fallbackFeaturedBusinesses();
        }

        return array_map(static function (array $business): array {
            return [
                'name' => $business['name'] ?? '',
                'slug' => $business['slug'] ?? null,
                'category' => $business['category'] ?? 'Hizmet İşletmesi',
                'location' => trim(implode(' / ', array_filter([
                    $business['city'] ?? null,
                    $business['district'] ?? null,
                ]))),
                'description' => $business['short_description'] ?? 'Online randevu altyapısıyla müşterilerine daha hızlı dönüş yapan işletme.',
                'image' => $business['cover_image'] ?: ($business['intro_image'] ?: null),
            ];
        }, $businesses);
    }

    /**
     * @return array<int, array<string, string|null>>
     */
    private function fallbackFeaturedBusinesses(): array
    {
        return [
            [
                'name' => 'Glow Beauty Studio',
                'slug' => null,
                'category' => 'Güzellik Salonu',
                'location' => 'İstanbul / Kadıköy',
                'description' => 'Cilt bakımı, saç ve bakım randevularını tek panelden yöneten örnek işletme.',
                'image' => 'web-assets/images/gallery/features-1.jpg',
            ],
            [
                'name' => 'Dental Care Plus',
                'slug' => null,
                'category' => 'Klinik',
                'location' => 'Ankara / Çankaya',
                'description' => 'Hasta takibi, doktor programı ve uygun saat önerileri için modern randevu akışı.',
                'image' => 'web-assets/images/gallery/features-4.jpg',
            ],
            [
                'name' => 'Fit Motion PT',
                'slug' => null,
                'category' => 'Spor ve Danışmanlık',
                'location' => 'İzmir / Alsancak',
                'description' => 'Kişisel antrenman, seans planlama ve ekip takibi için hızlı rezervasyon deneyimi.',
                'image' => 'web-assets/images/gallery/skill-1.jpg',
            ],
        ];
    }
}
