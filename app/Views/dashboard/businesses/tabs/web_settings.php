<?php $settings = $webSettings ?? []; ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card border-0 bg-light">
            <div class="card-body d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <h4 class="mb-2">Web Ayarları</h4>
                    <p class="text-muted mb-0">Bu işletme için sayfaları, genel site ayarlarını ve SEO alanlarını yeni modülden yönet.</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-pages') ?>" class="btn btn-primary">Sayfalar</a>
                    <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-pages/create') ?>" class="btn btn-outline-primary">Sayfa Ekle</a>
                    <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-settings/general') ?>" class="btn btn-outline-secondary">Genel</a>
                    <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-settings/menu') ?>" class="btn btn-outline-secondary">Menü</a>
                    <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-settings/seo') ?>" class="btn btn-outline-secondary">SEO</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="mb-3">Varsayılan Durum</h5>
                <ul class="list-unstyled mb-0">
                    <li><strong>Sayfa Başlığı:</strong> <?= esc($settings['page_title'] ?? '-') ?></li>
                    <li><strong>Kısa Tanıtım:</strong> <?= esc($settings['short_intro'] ?? '-') ?></li>
                    <li><strong>Kapak Görseli:</strong> <?= ! empty($settings['cover_image']) ? 'Var' : 'Yok' ?></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="mb-3">Menu / Görünürlük</h5>
                <ul class="list-unstyled mb-0">
                    <li>Hizmetler: <?= ! empty($settings['show_services']) ? 'Açık' : 'Kapalı' ?></li>
                    <li>Çalışanlar: <?= ! empty($settings['show_staff']) ? 'Açık' : 'Kapalı' ?></li>
                    <li>İletişim: <?= ! empty($settings['show_contact']) ? 'Açık' : 'Kapalı' ?></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="mb-3">SEO</h5>
                <ul class="list-unstyled mb-0">
                    <li>Varsayılan başlık: <?= esc($settings['default_seo_title'] ?? '-') ?></li>
                    <li>Sosyal görsel: <?= ! empty($settings['default_social_image']) ? 'Var' : 'Yok' ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
