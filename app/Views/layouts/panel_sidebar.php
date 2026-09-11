<?php
$businessId = (int) ($panelBusiness['id'] ?? 0);
$query = $businessId ? '?business_id=' . $businessId : '';
$webPath = 'dashboard/businesses/' . $businessId;
$section = (string) service('request')->getGet('section');
$webLink = static fn (string $suffix, string $section): string => $businessId ? $webPath . '/' . $suffix : 'dashboard/web?section=' . $section;
$groups = [
    '' => [['Dashboard', 'dashboard', 'home', $panelPath === 'dashboard']],
    'İşletme' => [
        ['İşletmelerim', 'dashboard/businesses', 'building', ($panelPath === 'business' || str_starts_with($panelPath, 'dashboard/businesses')) && ! str_contains($panelPath, '/web-')],
        ['Hizmetler', 'dashboard/services' . $query, 'th-large', in_array($panelPath, ['dashboard/services', 'services'], true)],
        ['Çalışanlar', 'dashboard/employees' . $query, 'users', in_array($panelPath, ['dashboard/employees', 'employees'], true)],
    ],
    'Randevu yönetimi' => [
        ['Randevular', 'dashboard/appointments' . $query, 'calendar', in_array($panelPath, ['dashboard/appointments', 'appointments'], true)],
    ],
    'Web sitesi' => [
        ['Sayfalar', $webLink('web-pages', 'pages'), 'file-lines', str_contains($panelPath, '/web-pages') || ($panelPath === 'dashboard/web' && in_array($section, ['', 'pages'], true))],
        ['Görünüm', $webLink('web-settings/general', 'general'), 'paint-brush', str_ends_with($panelPath, '/web-settings/general') || ($panelPath === 'dashboard/web' && $section === 'general')],
        ['Menü', $webLink('web-settings/menu', 'menu'), 'bars', str_ends_with($panelPath, '/web-settings/menu') || ($panelPath === 'dashboard/web' && $section === 'menu')],
        ['SEO', $webLink('web-settings/seo', 'seo'), 'search', str_ends_with($panelPath, '/web-settings/seo') || ($panelPath === 'dashboard/web' && $section === 'seo')],
    ],
    'Yönetim' => [
        ['Ayarlar', 'dashboard/settings', 'sliders', in_array($panelPath, ['dashboard/settings', 'settings'], true)],
    ],
];
?>
<aside id="panel-sidebar" class="sa-sidebar" aria-label="Ana menü">
    <a class="sa-brand" href="<?= base_url('dashboard/businesses') ?>"><span class="sa-brand-mark"><i class="fa fa-calendar-check" aria-hidden="true"></i></span><span>Smart<span class="sa-brand-sub">Appointment</span></span></a>
    <nav class="sa-navigation">
        <?php foreach ($groups as $label => $items): ?>
            <?php if ($label !== ''): ?><div class="sa-nav-label"><?= esc($label) ?></div><?php endif; ?>
            <?php foreach ($items as [$label, $path, $icon, $active]): ?>
                <a href="<?= esc(base_url($path)) ?>" class="sa-nav-link<?= $active ? ' is-active' : '' ?>"<?= $active ? ' aria-current="page"' : '' ?>><i class="fa fa-<?= esc($icon) ?>" aria-hidden="true"></i><span><?= esc($label) ?></span></a>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </nav>
    <div class="sa-sidebar-footer"><i class="fa fa-circle" aria-hidden="true"></i><span>Smart Appointment</span><a href="<?= base_url('logout') ?>" class="sa-icon-button" title="Çıkış yap" aria-label="Çıkış yap"><i class="fa fa-sign-out" aria-hidden="true"></i></a></div>
</aside>
<button type="button" class="sa-backdrop" aria-label="Menüyü kapat" tabindex="-1" hidden></button>
<main id="panel-content" tabindex="-1">
