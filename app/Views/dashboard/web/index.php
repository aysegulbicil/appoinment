<?php $businesses = $businesses ?? []; ?>
<div class="content-body">
    <div class="container-fluid">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success solid"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <h3 class="mb-2">Web Ayarları</h3>
                    <p class="text-muted mb-0">Her işletmenin sayfalarını, genel ayarlarını ve SEO alanlarını buradan yönetebilirsin.</p>
                </div>
                <a href="<?= base_url('dashboard/businesses/create') ?>" class="btn btn-primary">Yeni İşletme</a>
            </div>
        </div>

        <div class="row">
            <?php foreach ($businesses as $business): ?>
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                                <div>
                                    <h4 class="mb-1"><?= esc($business['name']) ?></h4>
                                    <p class="text-muted mb-0"><?= esc($business['category'] ?? '-') ?> · <?= esc($business['city'] ?? '-') ?></p>
                                </div>
                                <span class="badge badge-<?= ($business['status'] ?? 'active') === 'active' ? 'success' : 'secondary' ?> light">
                                    <?= ($business['status'] ?? 'active') === 'active' ? 'Aktif' : 'Pasif' ?>
                                </span>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mt-4">
                                <a class="btn btn-outline-primary" href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-pages') ?>">Sayfalar</a>
                                <a class="btn btn-outline-primary" href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-pages/create') ?>">Sayfa Ekle</a>
                                <a class="btn btn-outline-secondary" href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-settings/general') ?>">Genel Ayarlar</a>
                                <a class="btn btn-outline-secondary" href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-settings/menu') ?>">Menü Ayarları</a>
                                <a class="btn btn-outline-secondary" href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-settings/seo') ?>">SEO Ayarları</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
