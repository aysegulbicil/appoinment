<div class="row">
    <div class="col-12">
        <div class="card border-0 bg-light">
            <div class="card-body d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <h4 class="mb-2">Web Sayfaları</h4>
                    <p class="text-muted mb-0">Bu işletmenin çok sayfalı web yapısı artık ayrı bir modülde yönetiliyor.</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-pages') ?>" class="btn btn-primary">Sayfa Listesi</a>
                    <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-pages/create') ?>" class="btn btn-outline-primary">Sayfa Ekle</a>
                    <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-settings') ?>" class="btn btn-outline-secondary">Ayar Merkezi</a>
                </div>
            </div>
        </div>
    </div>
</div>
