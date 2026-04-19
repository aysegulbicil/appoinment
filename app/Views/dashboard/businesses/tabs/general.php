<?php $errors = session('errors') ?? []; ?>
<form action="<?= base_url('dashboard/businesses/' . $business['id'] . '/update') ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="section" value="general">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label" for="general-name">Isletme Adi</label>
            <input id="general-name" name="name" type="text" class="form-control<?= isset($errors['name']) ? ' is-invalid' : '' ?>" value="<?= esc(old('name', $business['name'] ?? '')) ?>">
            <?php if (isset($errors['name'])): ?><div class="invalid-feedback"><?= esc($errors['name']) ?></div><?php endif; ?>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label" for="general-category">Kategori</label>
            <select id="general-category" name="category" class="form-control<?= isset($errors['category']) ? ' is-invalid' : '' ?>">
                <option value="">Kategori secin</option>
                <?php foreach (($categories ?? []) as $category): ?>
                    <option value="<?= esc($category) ?>" <?= old('category', $business['category'] ?? '') === $category ? 'selected' : '' ?>><?= esc($category) ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['category'])): ?><div class="invalid-feedback"><?= esc($errors['category']) ?></div><?php endif; ?>
        </div>
        <?php
        $isCustomCategory = ! in_array((string) old('category', $business['category'] ?? ''), $categories ?? [], true)
            || old('category') === 'Diger';
        $customCategoryValue = old('custom_category', $isCustomCategory ? ($business['category'] ?? '') : '');
        ?>
        <div class="col-md-6 mb-3" id="general-custom-category-wrapper" style="display: <?= $isCustomCategory ? 'block' : 'none' ?>;">
            <label class="form-label" for="general-custom-category">Diger Kategori</label>
            <input id="general-custom-category" name="custom_category" type="text" class="form-control<?= isset($errors['custom_category']) ? ' is-invalid' : '' ?>" value="<?= esc($customCategoryValue) ?>" placeholder="Kategori girin">
            <?php if (isset($errors['custom_category'])): ?><div class="invalid-feedback"><?= esc($errors['custom_category']) ?></div><?php endif; ?>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label" for="general-phone">Telefon</label>
            <input id="general-phone" name="phone" type="text" class="form-control<?= isset($errors['phone']) ? ' is-invalid' : '' ?>" value="<?= esc(old('phone', $business['phone'] ?? '')) ?>">
            <?php if (isset($errors['phone'])): ?><div class="invalid-feedback"><?= esc($errors['phone']) ?></div><?php endif; ?>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label" for="general-email">E-posta</label>
            <input id="general-email" name="email" type="email" class="form-control<?= isset($errors['email']) ? ' is-invalid' : '' ?>" value="<?= esc(old('email', $business['email'] ?? '')) ?>">
            <?php if (isset($errors['email'])): ?><div class="invalid-feedback"><?= esc($errors['email']) ?></div><?php endif; ?>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label" for="general-city">Sehir</label>
            <input id="general-city" name="city" type="text" class="form-control<?= isset($errors['city']) ? ' is-invalid' : '' ?>" value="<?= esc(old('city', $business['city'] ?? '')) ?>">
            <?php if (isset($errors['city'])): ?><div class="invalid-feedback"><?= esc($errors['city']) ?></div><?php endif; ?>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label" for="general-district">Ilce</label>
            <input id="general-district" name="district" type="text" class="form-control<?= isset($errors['district']) ? ' is-invalid' : '' ?>" value="<?= esc(old('district', $business['district'] ?? '')) ?>">
            <?php if (isset($errors['district'])): ?><div class="invalid-feedback"><?= esc($errors['district']) ?></div><?php endif; ?>
        </div>
        <div class="col-md-8 mb-3">
            <label class="form-label" for="general-short-description">Kisa Aciklama</label>
            <textarea id="general-short-description" name="short_description" rows="5" class="form-control<?= isset($errors['short_description']) ? ' is-invalid' : '' ?>"><?= esc(old('short_description', $business['short_description'] ?? '')) ?></textarea>
            <?php if (isset($errors['short_description'])): ?><div class="invalid-feedback"><?= esc($errors['short_description']) ?></div><?php endif; ?>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label" for="general-status">Durum</label>
            <select id="general-status" name="status" class="form-control">
                <option value="active" <?= old('status', $business['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Aktif</option>
                <option value="passive" <?= old('status', $business['status'] ?? 'active') === 'passive' ? 'selected' : '' ?>>Pasif</option>
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Guncelle</button>
</form>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const category = document.getElementById('general-category');
    const wrapper = document.getElementById('general-custom-category-wrapper');
    const input = document.getElementById('general-custom-category');

    if (!category || !wrapper || !input) {
        return;
    }

    const predefined = <?= json_encode(array_values($categories ?? [])) ?>;

    const toggleCustomCategory = () => {
        const isOther = category.value === 'Diger' || (category.value !== '' && !predefined.includes(category.value));
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
