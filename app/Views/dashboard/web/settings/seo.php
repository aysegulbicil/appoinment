<?php $errors = session('errors') ?? []; ?>
<div class="content-body">
    <div class="container-fluid">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success solid"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h4 class="card-title mb-0">SEO Ayarları</h4>
                <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-pages') ?>" class="btn btn-light border">Sayfalar</a>
            </div>
            <div class="card-body">
                <form action="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-settings/seo') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="default_seo_title">Varsayılan SEO Başlığı</label>
                            <input id="default_seo_title" name="default_seo_title" type="text" class="form-control<?= isset($errors['default_seo_title']) ? ' is-invalid' : '' ?>" value="<?= esc(old('default_seo_title', $settings['default_seo_title'] ?? '')) ?>">
                            <?php if (isset($errors['default_seo_title'])): ?><div class="invalid-feedback"><?= esc($errors['default_seo_title']) ?></div><?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="default_social_image_file">Sosyal Paylaşım Görseli</label>
                            <input id="default_social_image_file" name="default_social_image_file" type="file" accept="image/*" class="form-control<?= isset($errors['default_social_image_file']) ? ' is-invalid' : '' ?>">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="default_seo_description">Varsayılan SEO Açıklaması</label>
                            <textarea id="default_seo_description" name="default_seo_description" rows="4" class="form-control<?= isset($errors['default_seo_description']) ? ' is-invalid' : '' ?>"><?= esc(old('default_seo_description', $settings['default_seo_description'] ?? '')) ?></textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="default_seo_keywords">Varsayılan Anahtar Kelimeler</label>
                            <textarea id="default_seo_keywords" name="default_seo_keywords" rows="3" class="form-control<?= isset($errors['default_seo_keywords']) ? ' is-invalid' : '' ?>"><?= esc(old('default_seo_keywords', $settings['default_seo_keywords'] ?? '')) ?></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </div>
                    </div>
                </form>

                <?php if (! empty($settings['default_social_image'])): ?>
                    <div class="mt-4">
                        <label class="form-label d-block">Mevcut Sosyal Görsel</label>
                        <img src="<?= base_url($settings['default_social_image']) ?>" alt="Sosyal Görsel" style="max-height: 140px; max-width: 100%;">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
