<?php $settings = $settings ?? []; ?>
<div class="content-body">
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-body d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <h3 class="mb-2"><?= esc($business['name'] ?? '-') ?> - Web Ayarları</h3>
                    <p class="text-muted mb-0">Genel görünüm, menü davranışı ve SEO alanlarını buradan yönetebilirsin.</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-settings/general') ?>" class="btn btn-primary">Genel</a>
                    <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-settings/menu') ?>" class="btn btn-outline-primary">Menü</a>
                    <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-settings/seo') ?>" class="btn btn-outline-primary">SEO</a>
                    <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-pages') ?>" class="btn btn-light border">Sayfalar</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5>Genel Bilgiler</h5>
                        <p class="text-muted mb-0">Logo, renkler ve footer metni gibi global alanlar.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5>Menü Kontrolü</h5>
                        <p class="text-muted mb-0">Sistem sayfalarının menüde görünürlüğünü buradan yönet.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5>SEO Şablonu</h5>
                        <p class="text-muted mb-0">Varsayılan SEO başlıkları ve sosyal paylaşım görselleri.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
