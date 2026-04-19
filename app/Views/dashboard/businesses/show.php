<?php
$tabs = [
    'general' => 'Genel Bilgiler',
    'web-settings' => 'Web Ayarlari',
];
?>
<div class="content-body">
    <div class="container-fluid">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success solid"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div>
                        <h3 class="mb-2"><?= esc($business['name'] ?? '-') ?></h3>
                        <div class="d-flex flex-wrap gap-3 text-muted">
                            <span><?= esc($business['category'] ?? '-') ?></span>
                            <span><?= esc($business['phone'] ?? '-') ?></span>
                            <span><?= esc($business['email'] ?? '-') ?></span>
                            <span><?= esc(trim(($business['city'] ?? '') . ' / ' . ($business['district'] ?? ''), ' /') ?: '-') ?></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="badge badge-<?= ($business['status'] ?? 'active') === 'active' ? 'success' : 'secondary' ?> light">
                            <?= ($business['status'] ?? 'active') === 'active' ? 'Aktif' : 'Pasif' ?>
                        </span>
                        <a href="<?= base_url('dashboard/businesses') ?>" class="btn btn-light border">Geri Don</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header border-0 pb-0">
                <ul class="nav nav-tabs card-header-tabs">
                    <?php foreach ($tabs as $tabKey => $tabLabel): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($currentTab ?? 'general') === $tabKey ? 'active' : '' ?>" href="<?= base_url('dashboard/businesses/' . $business['id'] . '?tab=' . $tabKey) ?>">
                                <?= esc($tabLabel) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="card-body pt-4">
                <?php
                if (($currentTab ?? 'general') === 'web-settings') {
                    echo view('dashboard/businesses/tabs/web_settings', ['business' => $business, 'webSettings' => $webSettings ?? []]);
                } elseif (($currentTab ?? 'general') === 'staff') {
                    echo view('dashboard/businesses/tabs/staff', ['business' => $business]);
                } else {
                    echo view('dashboard/businesses/tabs/general', ['business' => $business, 'categories' => $categories ?? []]);
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/vendor/tinymce/tinymce.min.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var editor = document.getElementById('web-content-editor');
    var form = document.getElementById('business-web-settings-form');

    if (editor && window.tinymce) {
        tinymce.init({
            selector: '#web-content-editor',
            license_key: 'gpl',
            height: 430,
            menubar: true,
            branding: false,
            promotion: false,
            plugins: 'accordion advlist anchor autolink autoresize charmap code codesample directionality emoticons fullscreen help image importcss insertdatetime link lists media nonbreaking pagebreak preview quickbars save searchreplace table visualblocks visualchars wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table blockquote | removeformat code fullscreen preview',
            automatic_uploads: true,
            images_upload_handler: function (blobInfo, progress) {
                return new Promise(function (resolve, reject) {
                    var xhr = new XMLHttpRequest();
                    var data = new FormData();

                    xhr.open('POST', '<?= base_url('dashboard/businesses/' . $business['id'] . '/editor-image') ?>');
                    xhr.upload.onprogress = function (event) {
                        if (event.lengthComputable) {
                            progress(event.loaded / event.total * 100);
                        }
                    };
                    xhr.onload = function () {
                        var response;

                        if (xhr.status < 200 || xhr.status >= 300) {
                            reject('Gorsel yuklenemedi.');
                            return;
                        }

                        try {
                            response = JSON.parse(xhr.responseText);
                        } catch (error) {
                            reject('Gorsel yukleme yaniti okunamadi.');
                            return;
                        }

                        if (!response || !response.location) {
                            reject('Gorsel adresi olusturulamadi.');
                            return;
                        }

                        resolve(response.location);
                    };
                    xhr.onerror = function () {
                        reject('Gorsel yukleme istegi basarisiz oldu.');
                    };
                    data.append('file', blobInfo.blob(), blobInfo.filename());
                    xhr.send(data);
                });
            }
        });
    }

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
                + '<button type="button" class="btn btn-sm btn-outline-danger w-100 remove-new-gallery-image">Listeden Cikar</button>'
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
