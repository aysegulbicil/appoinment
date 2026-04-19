<?php $errors = session('errors') ?? []; ?>
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-10 col-lg-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div>
                            <h4 class="card-title mb-1">Yeni Isletme Ekle</h4>
                            <p class="mb-0 text-muted">Temel bilgileri doldurun, kaydettikten sonra detay ekranindan yonetmeye devam edin.</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('dashboard/businesses/store') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="name">Isletme Adi</label>
                                    <input id="name" name="name" type="text" class="form-control<?= isset($errors['name']) ? ' is-invalid' : '' ?>" value="<?= esc(old('name')) ?>">
                                    <?php if (isset($errors['name'])): ?><div class="invalid-feedback"><?= esc($errors['name']) ?></div><?php endif; ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="category">Kategori / Sektor</label>
                                    <select id="category" name="category" class="form-control<?= isset($errors['category']) ? ' is-invalid' : '' ?>">
                                        <option value="">Kategori secin</option>
                                        <?php foreach (($categories ?? []) as $category): ?>
                                            <option value="<?= esc($category) ?>" <?= old('category') === $category ? 'selected' : '' ?>><?= esc($category) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (isset($errors['category'])): ?><div class="invalid-feedback"><?= esc($errors['category']) ?></div><?php endif; ?>
                                </div>
                                <div class="col-md-6 mb-3" id="custom-category-wrapper" style="display: <?= old('category') === 'Diger' ? 'block' : 'none' ?>;">
                                    <label class="form-label" for="custom_category">Diger Kategori</label>
                                    <input id="custom_category" name="custom_category" type="text" class="form-control<?= isset($errors['custom_category']) ? ' is-invalid' : '' ?>" value="<?= esc(old('custom_category')) ?>" placeholder="Kategori girin">
                                    <?php if (isset($errors['custom_category'])): ?><div class="invalid-feedback"><?= esc($errors['custom_category']) ?></div><?php endif; ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="phone">Telefon</label>
                                    <input id="phone" name="phone" type="text" class="form-control<?= isset($errors['phone']) ? ' is-invalid' : '' ?>" value="<?= esc(old('phone')) ?>">
                                    <?php if (isset($errors['phone'])): ?><div class="invalid-feedback"><?= esc($errors['phone']) ?></div><?php endif; ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="email">E-posta</label>
                                    <input id="email" name="email" type="email" class="form-control<?= isset($errors['email']) ? ' is-invalid' : '' ?>" value="<?= esc(old('email')) ?>">
                                    <?php if (isset($errors['email'])): ?><div class="invalid-feedback"><?= esc($errors['email']) ?></div><?php endif; ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="city">Sehir</label>
                                    <input id="city" name="city" type="text" class="form-control<?= isset($errors['city']) ? ' is-invalid' : '' ?>" value="<?= esc(old('city')) ?>">
                                    <?php if (isset($errors['city'])): ?><div class="invalid-feedback"><?= esc($errors['city']) ?></div><?php endif; ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="district">Ilce</label>
                                    <input id="district" name="district" type="text" class="form-control<?= isset($errors['district']) ? ' is-invalid' : '' ?>" value="<?= esc(old('district')) ?>">
                                    <?php if (isset($errors['district'])): ?><div class="invalid-feedback"><?= esc($errors['district']) ?></div><?php endif; ?>
                                </div>
                                <div class="col-12 mb-4">
                                    <label class="form-label" for="short_description">Kisa Aciklama</label>
                                    <textarea id="short_description" name="short_description" rows="4" class="form-control<?= isset($errors['short_description']) ? ' is-invalid' : '' ?>"><?= esc(old('short_description')) ?></textarea>
                                    <?php if (isset($errors['short_description'])): ?><div class="invalid-feedback"><?= esc($errors['short_description']) ?></div><?php endif; ?>
                                </div>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="submit" class="btn btn-primary">Kaydet ve Devam Et</button>
                                <a href="<?= base_url('dashboard/businesses') ?>" class="btn btn-light border">Vazgec</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const category = document.getElementById('category');
    const wrapper = document.getElementById('custom-category-wrapper');
    const input = document.getElementById('custom_category');

    if (!category || !wrapper || !input) {
        return;
    }

    const toggleCustomCategory = () => {
        const isOther = category.value === 'Diger';
        wrapper.style.display = isOther ? 'block' : 'none';
        input.disabled = !isOther;
        if (!isOther) {
            input.value = '';
        }
    };

    toggleCustomCategory();
    category.addEventListener('change', toggleCustomCategory);
});
</script>
