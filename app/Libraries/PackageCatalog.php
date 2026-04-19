<?php

namespace App\Libraries;

class PackageCatalog
{
    public const SESSION_KEY = 'selectedPackageCode';

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function all(): array
    {
        return [
            [
                'code'        => 'free',
                'name'        => 'Ücretsiz Paket',
                'priceLabel'  => 'Ücretsiz',
                'description' => 'Yeni başlayan işletmeler için hızlı kurulum paketi.',
                'ctaLabel'    => 'Ücretsiz Başla',
                'badge'       => 'Başlangıç',
                'features'    => [
                    'İlk işletme profilinizi oluşturun',
                    'Personel ve hizmet yapısını hazırlayın',
                    'Randevu altyapınızı yönetim panelinden kurun',
                ],
                'limits'      => [
                    'businesses' => null,
                    'employees'  => null,
                ],
            ],
            [
                'code'        => 'standard',
                'name'        => 'Standart Paket',
                'priceLabel'  => 'Yakında',
                'description' => 'Büyüyen ekipler için genişletilebilir operasyon paketi.',
                'ctaLabel'    => 'Standart Paketi Seç',
                'badge'       => 'Popüler',
                'features'    => [
                    'Birden fazla operasyon ihtiyacına uygun altyapı',
                    'Ek modül ve yetki kuralları için hazır yapı',
                    'Paket bazlı gelişimlere açık esnek kurgu',
                ],
                'limits'      => [
                    'businesses' => null,
                    'employees'  => null,
                ],
            ],
            [
                'code'        => 'premium',
                'name'        => 'Premium Paket',
                'priceLabel'  => 'Yakında',
                'description' => 'Gelişmiş otomasyon ve ileri seviye modüller için premium temel.',
                'ctaLabel'    => 'Premium Paketi Seç',
                'badge'       => 'Gelişmiş',
                'features'    => [
                    'Gelişmiş özellikler için hazır entegrasyon zemini',
                    'Paket bazlı yetki ve limit kurallarına uygun mimari',
                    'Büyük ekipler ve çoklu işletme senaryoları için esnek temel',
                ],
                'limits'      => [
                    'businesses' => null,
                    'employees'  => null,
                ],
            ],
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function find(?string $code): ?array
    {
        if ($code === null || $code === '') {
            return null;
        }

        foreach (self::all() as $package) {
            if ($package['code'] === $code) {
                return $package;
            }
        }

        return null;
    }

    /**
     * @return array<string, mixed>
     */
    public static function default(): array
    {
        return self::all()[0];
    }
}
