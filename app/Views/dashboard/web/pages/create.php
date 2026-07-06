<div class="content-body">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                    <div>
                        <h3 class="mb-2">Yeni Sayfa</h3>
                        <p class="text-muted mb-0"><?= esc($business['name'] ?? '-') ?> için yeni bir içerik sayfası oluştur.</p>
                    </div>
                    <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-pages') ?>" class="btn btn-light border">Geri Dön</a>
                </div>

                <?= view('dashboard/web/pages/form', [
                    'business' => $business,
                    'page' => $page ?? [],
                    'pageTypes' => $pageTypes ?? [],
                    'galleryImages' => [],
                    'action' => base_url('dashboard/businesses/' . $business['id'] . '/web-pages/store'),
                    'submitLabel' => 'Sayfayı Kaydet',
                    'isEdit' => false,
                ]) ?>
            </div>
        </div>
    </div>
</div>
