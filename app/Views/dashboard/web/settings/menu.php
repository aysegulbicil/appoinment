<?php $errors = session('errors') ?? []; ?>
<div class="content-body">
    <div class="container-fluid">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success solid"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h4 class="card-title mb-0">Menü Ayarları</h4>
                <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-pages') ?>" class="btn btn-light border">Sayfalar</a>
            </div>
            <div class="card-body">
                <form action="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-settings/menu') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row">
                        <?php
                        $menuOptions = [
                            'show_services' => 'Hizmetleri Göster',
                            'show_staff'    => 'Çalışanları Göster',
                            'show_prices'   => 'Fiyatları Göster',
                            'show_contact'  => 'İletişim Bilgilerini Göster',
                            'show_map'      => 'Haritayı Göster',
                        ];
                        ?>
                        <?php foreach ($menuOptions as $field => $label): ?>
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="<?= esc($field) ?>" name="<?= esc($field) ?>" value="1" <?= old($field, $settings[$field] ?? 0) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="<?= esc($field) ?>"><?= esc($label) ?></label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="col-12 mt-2">
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
