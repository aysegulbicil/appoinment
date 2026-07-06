<?php
$errors = session('errors') ?? [];
$page = $page ?? [];
$galleryImages = $galleryImages ?? [];
$pageTypes = $pageTypes ?? [];
$action = $action ?? '#';
$submitLabel = $submitLabel ?? 'Kaydet';
$isEdit = (bool) ($isEdit ?? false);
?>

<form action="<?= esc($action, 'attr') ?>" method="post" enctype="multipart/form-data" id="business-web-page-form">
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label" for="title">Sayfa Başlığı</label>
            <input id="title" name="title" type="text" class="form-control<?= isset($errors['title']) ? ' is-invalid' : '' ?>" value="<?= esc(old('title', $page['title'] ?? '')) ?>">
            <?php if (isset($errors['title'])): ?><div class="invalid-feedback"><?= esc($errors['title']) ?></div><?php endif; ?>
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label" for="page_type">Sayfa Tipi</label>
            <select id="page_type" name="page_type" class="form-control<?= isset($errors['page_type']) ? ' is-invalid' : '' ?>">
                <?php foreach ($pageTypes as $type => $label): ?>
                    <option value="<?= esc($type) ?>" <?= old('page_type', $page['page_type'] ?? 'custom') === $type ? 'selected' : '' ?>><?= esc($label) ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['page_type'])): ?><div class="invalid-feedback"><?= esc($errors['page_type']) ?></div><?php endif; ?>
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label" for="sort_order">Sıra</label>
            <input id="sort_order" name="sort_order" type="number" min="0" class="form-control<?= isset($errors['sort_order']) ? ' is-invalid' : '' ?>" value="<?= esc(old('sort_order', $page['sort_order'] ?? 0)) ?>">
            <?php if (isset($errors['sort_order'])): ?><div class="invalid-feedback"><?= esc($errors['sort_order']) ?></div><?php endif; ?>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label" for="slug">Slug</label>
            <input id="slug" name="slug" type="text" class="form-control<?= isset($errors['slug']) ? ' is-invalid' : '' ?>" value="<?= esc(old('slug', $page['slug'] ?? '')) ?>">
            <small class="text-muted d-block mt-1">Sistem sayfalarında slug otomatik sabitlenir.</small>
            <?php if (isset($errors['slug'])): ?><div class="invalid-feedback"><?= esc($errors['slug']) ?></div><?php endif; ?>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label" for="menu_label">Menü Etiketi</label>
            <input id="menu_label" name="menu_label" type="text" class="form-control<?= isset($errors['menu_label']) ? ' is-invalid' : '' ?>" value="<?= esc(old('menu_label', $page['menu_label'] ?? '')) ?>">
            <?php if (isset($errors['menu_label'])): ?><div class="invalid-feedback"><?= esc($errors['menu_label']) ?></div><?php endif; ?>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label" for="short_intro">Kısa Giriş</label>
            <input id="short_intro" name="short_intro" type="text" class="form-control<?= isset($errors['short_intro']) ? ' is-invalid' : '' ?>" value="<?= esc(old('short_intro', $page['short_intro'] ?? '')) ?>">
            <?php if (isset($errors['short_intro'])): ?><div class="invalid-feedback"><?= esc($errors['short_intro']) ?></div><?php endif; ?>
        </div>
        <div class="col-12 mb-3">
            <label class="form-label" for="content-editor">İçerik</label>
            <textarea id="content-editor" name="content" class="form-control<?= isset($errors['content']) ? ' is-invalid' : '' ?>" rows="10"><?= esc(old('content', $page['content'] ?? '')) ?></textarea>
            <?php if (isset($errors['content'])): ?><div class="invalid-feedback"><?= esc($errors['content']) ?></div><?php endif; ?>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label" for="cover_image_file">Kapak Görseli</label>
            <input id="cover_image_file" name="cover_image_file" type="file" accept="image/*" class="form-control<?= isset($errors['cover_image_file']) ? ' is-invalid' : '' ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label" for="intro_image_file">Intro Görseli</label>
            <input id="intro_image_file" name="intro_image_file" type="file" accept="image/*" class="form-control<?= isset($errors['intro_image_file']) ? ' is-invalid' : '' ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label" for="social_image_file">Sosyal Görsel</label>
            <input id="social_image_file" name="social_image_file" type="file" accept="image/*" class="form-control<?= isset($errors['social_image_file']) ? ' is-invalid' : '' ?>">
        </div>
        <div class="col-12 mb-4">
            <div class="border rounded p-3">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                    <div>
                        <label class="form-label mb-1" for="gallery_images_files">Galeri Görselleri</label>
                        <small class="text-muted d-block">Görselleri sürükleyerek sıralayabilir, kaldırabilir ve yeni görseller ekleyebilirsin.</small>
                    </div>
                </div>
                <input id="gallery_images_files" name="gallery_images_files[]" type="file" accept="image/*" multiple class="form-control<?= isset($errors['gallery_images_files']) ? ' is-invalid' : '' ?>">
                <input type="hidden" name="retained_gallery_images" id="retained-gallery-images" value='<?= esc(json_encode($galleryImages, JSON_UNESCAPED_SLASHES), 'attr') ?>'>
                <div class="row g-3 mt-2" id="existing-gallery-grid">
                    <?php foreach ($galleryImages as $image): ?>
                        <div class="col-md-3 col-sm-6 gallery-item" data-image="<?= esc($image, 'attr') ?>" draggable="true">
                            <div class="gallery-preview-card h-100">
                                <span class="gallery-drag-handle"><i class="fa fa-arrows-alt"></i></span>
                                <img src="<?= base_url($image) ?>" alt="Galeri görseli">
                                <button type="button" class="btn btn-sm btn-outline-danger w-100 remove-gallery-image">Listeden Çıkar</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="row g-3 mt-1" id="new-gallery-grid"></div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label" for="seo_title">SEO Başlığı</label>
            <input id="seo_title" name="seo_title" type="text" class="form-control<?= isset($errors['seo_title']) ? ' is-invalid' : '' ?>" value="<?= esc(old('seo_title', $page['seo_title'] ?? '')) ?>">
            <?php if (isset($errors['seo_title'])): ?><div class="invalid-feedback"><?= esc($errors['seo_title']) ?></div><?php endif; ?>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label" for="canonical_url">Canonical URL</label>
            <input id="canonical_url" name="canonical_url" type="url" class="form-control<?= isset($errors['canonical_url']) ? ' is-invalid' : '' ?>" value="<?= esc(old('canonical_url', $page['canonical_url'] ?? '')) ?>">
            <?php if (isset($errors['canonical_url'])): ?><div class="invalid-feedback"><?= esc($errors['canonical_url']) ?></div><?php endif; ?>
        </div>
        <div class="col-12 mb-3">
            <label class="form-label" for="seo_description">SEO Açıklaması</label>
            <textarea id="seo_description" name="seo_description" rows="3" class="form-control<?= isset($errors['seo_description']) ? ' is-invalid' : '' ?>"><?= esc(old('seo_description', $page['seo_description'] ?? '')) ?></textarea>
            <?php if (isset($errors['seo_description'])): ?><div class="invalid-feedback"><?= esc($errors['seo_description']) ?></div><?php endif; ?>
        </div>
        <div class="col-12 mb-3">
            <label class="form-label" for="seo_keywords">SEO Anahtar Kelimeleri</label>
            <textarea id="seo_keywords" name="seo_keywords" rows="2" class="form-control<?= isset($errors['seo_keywords']) ? ' is-invalid' : '' ?>"><?= esc(old('seo_keywords', $page['seo_keywords'] ?? '')) ?></textarea>
            <?php if (isset($errors['seo_keywords'])): ?><div class="invalid-feedback"><?= esc($errors['seo_keywords']) ?></div><?php endif; ?>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-check form-switch mt-4">
                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" <?= old('is_active', $page['is_active'] ?? 1) ? 'checked' : '' ?>>
                <label class="form-check-label" for="is_active">Aktif</label>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-check form-switch mt-4">
                <input class="form-check-input" type="checkbox" role="switch" id="is_visible_in_menu" name="is_visible_in_menu" value="1" <?= old('is_visible_in_menu', $page['is_visible_in_menu'] ?? 1) ? 'checked' : '' ?>>
                <label class="form-check-label" for="is_visible_in_menu">Menüde göster</label>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <button type="submit" class="btn btn-primary"><?= esc($submitLabel) ?></button>
        <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-pages') ?>" class="btn btn-light border">Geri Dön</a>
    </div>
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

<script src="<?= base_url('assets/vendor/tinymce/tinymce.min.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.tinymce) {
        tinymce.init({
            selector: '#content-editor',
            license_key: 'gpl',
            height: 420,
            menubar: true,
            branding: false,
            promotion: false,
            plugins: 'accordion advlist anchor autolink autoresize charmap code codesample directionality emoticons fullscreen help image importcss insertdatetime link lists media nonbreaking pagebreak preview quickbars save searchreplace table visualblocks visualchars wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table blockquote | removeformat code fullscreen preview',
            automatic_uploads: true
        });
    }

    var pageType = document.getElementById('page_type');
    var slug = document.getElementById('slug');
    var title = document.getElementById('title');
    var systemSlugs = {
        home: 'anasayfa',
        about: 'hakkimizda',
        services: 'hizmetler',
        gallery: 'galeri',
        contact: 'iletisim',
        faq: 'sss'
    };

    var syncSlug = function () {
        if (!pageType || !slug) {
            return;
        }

        var selected = pageType.value;
        if (selected !== 'custom' && systemSlugs[selected]) {
            slug.value = systemSlugs[selected];
            slug.readOnly = true;
        } else {
            slug.readOnly = false;
            if (!slug.value && title) {
                slug.value = title.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
            }
        }
    };

    if (pageType) {
        pageType.addEventListener('change', syncSlug);
    }
    if (title) {
        title.addEventListener('input', function () {
            if (pageType && pageType.value === 'custom' && slug && !slug.value) {
                slug.value = title.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
            }
        });
    }
    syncSlug();

    var retainedGalleryInput = document.getElementById('retained-gallery-images');
    var existingGalleryGrid = document.getElementById('existing-gallery-grid');
    var galleryFileInput = document.getElementById('gallery_images_files');
    var newGalleryGrid = document.getElementById('new-gallery-grid');
    if (!retainedGalleryInput) {
        return;
    }

    var draggedItem = null;

    var syncGalleryState = function () {
        var items = Array.prototype.slice.call(document.querySelectorAll('#existing-gallery-grid .gallery-item'));
        var paths = items.map(function (item) {
            return item.getAttribute('data-image');
        }).filter(Boolean);

        retainedGalleryInput.value = JSON.stringify(paths);
    };

    var makeSortable = function (container, afterDrop) {
        if (!container) {
            return;
        }

        container.addEventListener('dragstart', function (event) {
            draggedItem = event.target.closest('[draggable="true"]');
            if (draggedItem) {
                event.dataTransfer.effectAllowed = 'move';
                draggedItem.classList.add('is-dragging');
            }
        });

        container.addEventListener('dragend', function () {
            if (draggedItem) {
                draggedItem.classList.remove('is-dragging');
            }
            draggedItem = null;
            afterDrop();
        });

        container.addEventListener('dragover', function (event) {
            var target = event.target.closest('[draggable="true"]');
            if (!draggedItem || !target || target === draggedItem || target.parentNode !== container) {
                return;
            }

            event.preventDefault();
            var targetRect = target.getBoundingClientRect();
            var insertAfter = event.clientY > targetRect.top + targetRect.height / 2;
            container.insertBefore(draggedItem, insertAfter ? target.nextSibling : target);
        });
    };

    var syncNewFiles = function () {
        if (!galleryFileInput || !newGalleryGrid || typeof DataTransfer === 'undefined') {
            return;
        }

        var dataTransfer = new DataTransfer();
        Array.prototype.slice.call(newGalleryGrid.querySelectorAll('.new-gallery-item')).forEach(function (item) {
            var index = Number(item.getAttribute('data-file-index'));
            if (galleryFileInput._selectedFiles && galleryFileInput._selectedFiles[index]) {
                dataTransfer.items.add(galleryFileInput._selectedFiles[index]);
            }
        });

        galleryFileInput.files = dataTransfer.files;
        galleryFileInput._selectedFiles = Array.prototype.slice.call(galleryFileInput.files);
        Array.prototype.slice.call(newGalleryGrid.querySelectorAll('.new-gallery-item')).forEach(function (item, index) {
            item.setAttribute('data-file-index', index);
        });
    };

    var renderNewGalleryPreview = function () {
        if (!galleryFileInput || !newGalleryGrid) {
            return;
        }

        galleryFileInput._selectedFiles = Array.prototype.slice.call(galleryFileInput.files);
        newGalleryGrid.innerHTML = '';

        galleryFileInput._selectedFiles.forEach(function (file, index) {
            var item = document.createElement('div');
            var imageUrl = URL.createObjectURL(file);

            item.className = 'col-md-3 col-sm-6 new-gallery-item';
            item.setAttribute('data-file-index', index);
            item.setAttribute('draggable', 'true');
            item.innerHTML = '<div class="gallery-preview-card h-100">'
                + '<span class="gallery-drag-handle"><i class="fa fa-arrows-alt"></i></span>'
                + '<img src="' + imageUrl + '" alt="">'
                + '<button type="button" class="btn btn-sm btn-outline-danger w-100 remove-new-gallery-image">Listeden Çıkar</button>'
                + '</div>';
            newGalleryGrid.appendChild(item);
        });
    };

    document.querySelectorAll('.remove-gallery-image').forEach(function (button) {
        button.addEventListener('click', function () {
            var item = button.closest('.gallery-item');
            if (item) {
                item.remove();
                syncGalleryState();
            }
        });
    });

    if (galleryFileInput) {
        galleryFileInput.addEventListener('change', renderNewGalleryPreview);
    }

    if (newGalleryGrid) {
        newGalleryGrid.addEventListener('click', function (event) {
            var button = event.target.closest('.remove-new-gallery-image');
            var item = button ? button.closest('.new-gallery-item') : null;

            if (item) {
                item.remove();
                syncNewFiles();
            }
        });
    }

    var form = document.getElementById('business-web-page-form');
    if (form) {
        form.addEventListener('submit', function () {
            if (window.tinymce) {
                tinymce.triggerSave();
            }
            syncGalleryState();
            syncNewFiles();
        });
    }

    makeSortable(existingGalleryGrid, syncGalleryState);
    makeSortable(newGalleryGrid, syncNewFiles);
    syncGalleryState();
});
</script>
