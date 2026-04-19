<?php $errors = session('errors') ?? []; ?>
<?php
$galleryImages = [];
$galleryRaw    = old('retained_gallery_images', $webSettings['gallery_images'] ?? '[]');

if (is_array($galleryRaw)) {
    $galleryImages = array_values(array_filter(array_map(static fn ($item) => trim((string) $item), $galleryRaw)));
} else {
    $decoded = json_decode((string) $galleryRaw, true);
    if (is_array($decoded)) {
        $galleryImages = array_values(array_filter(array_map(static fn ($item) => trim((string) $item), $decoded)));
    }
}
?>
<form action="<?= base_url('dashboard/businesses/' . $business['id'] . '/update') ?>" method="post" enctype="multipart/form-data" id="business-web-settings-form">
    <?= csrf_field() ?>
    <input type="hidden" name="section" value="web_settings">
    <input type="hidden" name="retained_gallery_images" id="retained-gallery-images" value='<?= esc(json_encode($galleryImages, JSON_UNESCAPED_SLASHES), 'attr') ?>'>
    <div class="web-settings-builder">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label" for="page_title">Sayfa Başlığı</label>
            <input id="page_title" name="page_title" type="text" class="form-control<?= isset($errors['page_title']) ? ' is-invalid' : '' ?>" value="<?= esc(old('page_title', $webSettings['page_title'] ?? '')) ?>">
            <?php if (isset($errors['page_title'])): ?><div class="invalid-feedback"><?= esc($errors['page_title']) ?></div><?php endif; ?>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label" for="short_intro">Kısa Tanıtım Metni</label>
            <input id="short_intro" name="short_intro" type="text" class="form-control<?= isset($errors['short_intro']) ? ' is-invalid' : '' ?>" value="<?= esc(old('short_intro', $webSettings['short_intro'] ?? '')) ?>">
            <?php if (isset($errors['short_intro'])): ?><div class="invalid-feedback"><?= esc($errors['short_intro']) ?></div><?php endif; ?>
        </div>
        <div class="col-12 mb-3">
            <label class="form-label" for="web-content-editor">Detaylı Tanıtım İçeriği</label>
            <textarea id="web-content-editor" name="content" class="form-control<?= isset($errors['content']) ? ' is-invalid' : '' ?>"><?= esc(old('content', $webSettings['content'] ?? '')) ?></textarea>
            <small class="text-muted d-block mt-2">İşletmenizin detaylı tanıtımını bu editörle hazırlayın. Metin içine görsel ekleyebilir, başlık, liste, tablo ve bağlantı kullanabilirsiniz.</small>
            <?php if (isset($errors['content'])): ?><div class="invalid-feedback"><?= esc($errors['content']) ?></div><?php endif; ?>
        </div>
        <div class="col-md-12 mb-3">
            <label class="form-label" for="cover_image_file">Banner / Kapak Görseli</label>
            <input id="cover_image_file" name="cover_image_file" type="file" accept="image/*" class="form-control<?= isset($errors['cover_image_file']) ? ' is-invalid' : '' ?>">
            <?php if (isset($errors['cover_image_file'])): ?><div class="invalid-feedback"><?= esc($errors['cover_image_file']) ?></div><?php endif; ?>
            <small class="text-muted d-block mt-2">Detay sayfasının üst banner alanında kullanılır.</small>
            <?php if (! empty($webSettings['cover_image'])): ?>
                <div class="border rounded p-2 mt-3">
                    <img src="<?= base_url($webSettings['cover_image']) ?>" alt="Kapak Görseli" style="max-width: 100%; max-height: 180px; object-fit: cover;">
                </div>
            <?php endif; ?>
        </div>
        <div class="col-12 mb-4">
            <div class="gallery-manager border rounded p-3">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                    <div>
                        <label class="form-label mb-1" for="gallery_images_files">Galeri Görselleri</label>
                        <small class="text-muted d-block">Galeri işletme detay sayfasının en altında görünür. Görselleri sürükleyerek sıralayabilirsiniz.</small>
                    </div>
                    <span class="badge badge-primary light">Paket limitleri sonra uygulanacak</span>
                </div>
                <input id="gallery_images_files" name="gallery_images_files[]" type="file" accept="image/*" multiple class="form-control<?= isset($errors['gallery_images_files']) ? ' is-invalid' : '' ?>">
                <?php if (isset($errors['gallery_images_files'])): ?><div class="invalid-feedback"><?= esc($errors['gallery_images_files']) ?></div><?php endif; ?>
                <small class="text-muted d-block mt-2">Birden fazla görsel seçebilir, kaydetmeden önce yeni görsellerin sırasını da değiştirebilirsiniz.</small>

                <div class="row g-3 mt-1" id="existing-gallery-grid">
                    <?php foreach ($galleryImages as $image): ?>
                        <div class="col-md-3 col-sm-6 gallery-item" data-image="<?= esc($image, 'attr') ?>" draggable="true">
                            <div class="gallery-preview-card h-100">
                                <span class="gallery-drag-handle"><i class="fa fa-arrows-alt"></i></span>
                                <img src="<?= base_url($image) ?>" alt="Galeri Görseli">
                                <button type="button" class="btn btn-sm btn-outline-danger w-100 remove-gallery-image">Listeden Çıkar</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="row g-3 mt-1" id="new-gallery-grid"></div>
            </div>
        </div>
    </div>
    </div>
    <button type="submit" class="btn btn-primary">Kaydet</button>
</form>

<style>
.gallery-preview-card {
    border: 1px solid #e6e8ef;
    border-radius: 8px;
    padding: 8px;
    position: relative;
    background: #fff;
}

.gallery-preview-card img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    border-radius: 6px;
    margin-bottom: 8px;
}

.gallery-drag-handle {
    align-items: center;
    background: rgba(0, 0, 0, .68);
    border-radius: 6px;
    color: #fff;
    cursor: move;
    display: inline-flex;
    height: 30px;
    justify-content: center;
    left: 14px;
    position: absolute;
    top: 14px;
    width: 30px;
    z-index: 2;
}

.gallery-item.is-dragging,
.new-gallery-item.is-dragging {
    opacity: .55;
}
</style>
