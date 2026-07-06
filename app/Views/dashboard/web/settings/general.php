<?php $errors = session('errors') ?? []; ?>
<div class="content-body">
    <div class="container-fluid">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success solid"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h4 class="card-title mb-0">Genel Ayarlar</h4>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-pages') ?>" class="btn btn-light border">Sayfalar</a>
                    <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-settings/menu') ?>" class="btn btn-light border">Menü</a>
                    <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-settings/seo') ?>" class="btn btn-light border">SEO</a>
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-settings/general') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="site_title">Site Başlığı</label>
                            <input id="site_title" name="site_title" type="text" class="form-control<?= isset($errors['site_title']) ? ' is-invalid' : '' ?>" value="<?= esc(old('site_title', $settings['site_title'] ?? '')) ?>">
                            <?php if (isset($errors['site_title'])): ?><div class="invalid-feedback"><?= esc($errors['site_title']) ?></div><?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="logo_image_file">Logo</label>
                            <input id="logo_image_file" name="logo_image_file" type="file" accept="image/*" class="form-control<?= isset($errors['logo_image_file']) ? ' is-invalid' : '' ?>">
                            <?php if (isset($errors['logo_image_file'])): ?><div class="invalid-feedback"><?= esc($errors['logo_image_file']) ?></div><?php endif; ?>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="site_description">Site Açıklaması</label>
                            <textarea id="site_description" name="site_description" rows="4" class="form-control<?= isset($errors['site_description']) ? ' is-invalid' : '' ?>"><?= esc(old('site_description', $settings['site_description'] ?? '')) ?></textarea>
                            <?php if (isset($errors['site_description'])): ?><div class="invalid-feedback"><?= esc($errors['site_description']) ?></div><?php endif; ?>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="footer_text">Footer Metni</label>
                            <textarea id="footer_text" name="footer_text" rows="3" class="form-control<?= isset($errors['footer_text']) ? ' is-invalid' : '' ?>"><?= esc(old('footer_text', $settings['footer_text'] ?? '')) ?></textarea>
                            <?php if (isset($errors['footer_text'])): ?><div class="invalid-feedback"><?= esc($errors['footer_text']) ?></div><?php endif; ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="primary_color">Ana Renk</label>
                            <input id="primary_color" name="primary_color" type="text" class="form-control<?= isset($errors['primary_color']) ? ' is-invalid' : '' ?>" value="<?= esc(old('primary_color', $settings['primary_color'] ?? '')) ?>" placeholder="#0d6efd">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="secondary_color">İkincil Renk</label>
                            <input id="secondary_color" name="secondary_color" type="text" class="form-control<?= isset($errors['secondary_color']) ? ' is-invalid' : '' ?>" value="<?= esc(old('secondary_color', $settings['secondary_color'] ?? '')) ?>" placeholder="#6c757d">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </div>
                    </div>
                </form>

                <?php if (! empty($settings['logo_image'])): ?>
                    <div class="mt-4">
                        <label class="form-label d-block">Mevcut Logo</label>
                        <img src="<?= base_url($settings['logo_image']) ?>" alt="Logo" style="max-height: 90px; max-width: 100%;">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
