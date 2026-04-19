<?php
$services = $services ?? [];
$errors = session()->getFlashdata('errors') ?? [];
?>

<div class="row">
    <div class="col-xl-4">
        <div class="card border">
            <div class="card-header">
                <h5 class="mb-0">Hizmet Ekle</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('dashboard/businesses/' . $business['id'] . '/services/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label" for="service-title">Hizmet Adi</label>
                        <input id="service-title" name="title" type="text" class="form-control<?= isset($errors['title']) ? ' is-invalid' : '' ?>" value="<?= esc(old('title')) ?>" required>
                        <?php if (isset($errors['title'])): ?><div class="invalid-feedback"><?= esc($errors['title']) ?></div><?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="service-duration">Sure (dakika)</label>
                        <input id="service-duration" name="duration_minutes" type="number" min="1" class="form-control<?= isset($errors['duration_minutes']) ? ' is-invalid' : '' ?>" value="<?= esc(old('duration_minutes')) ?>">
                        <?php if (isset($errors['duration_minutes'])): ?><div class="invalid-feedback"><?= esc($errors['duration_minutes']) ?></div><?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="service-price">Fiyat</label>
                        <input id="service-price" name="price" type="text" class="form-control<?= isset($errors['price']) ? ' is-invalid' : '' ?>" value="<?= esc(old('price')) ?>" placeholder="750.00">
                        <?php if (isset($errors['price'])): ?><div class="invalid-feedback"><?= esc($errors['price']) ?></div><?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="service-status">Durum</label>
                        <select id="service-status" name="status" class="form-control">
                            <option value="active" <?= old('status', 'active') === 'active' ? 'selected' : '' ?>>Aktif</option>
                            <option value="passive" <?= old('status') === 'passive' ? 'selected' : '' ?>>Pasif</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="service-description">Aciklama</label>
                        <textarea id="service-description" name="description" rows="4" class="form-control<?= isset($errors['description']) ? ' is-invalid' : '' ?>"><?= esc(old('description')) ?></textarea>
                        <?php if (isset($errors['description'])): ?><div class="invalid-feedback"><?= esc($errors['description']) ?></div><?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Hizmeti Kaydet</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h5 class="mb-1">Hizmetler</h5>
                <p class="mb-0 text-muted">Randevu modalinda sadece aktif hizmetler listelenir.</p>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-responsive-md">
                <thead>
                    <tr>
                        <th>Hizmet Adi</th>
                        <th>Sure</th>
                        <th>Fiyat</th>
                        <th>Durum</th>
                        <th class="text-end">Islem</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($services === []): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Bu isletme icin henuz hizmet kaydi bulunmuyor.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($services as $service): ?>
                            <tr>
                                <td>
                                    <strong><?= esc($service['title']) ?></strong>
                                    <?php if (! empty($service['description'])): ?>
                                        <br><small class="text-muted"><?= esc($service['description']) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td><?= ! empty($service['duration_minutes']) ? esc($service['duration_minutes']) . ' dk' : '-' ?></td>
                                <td><?= $service['price'] !== null && $service['price'] !== '' ? esc(number_format((float) $service['price'], 2, ',', '.')) . ' TL' : '-' ?></td>
                                <td>
                                    <span class="badge badge-<?= ($service['status'] ?? 'active') === 'active' ? 'success' : 'secondary' ?> light">
                                        <?= ($service['status'] ?? 'active') === 'active' ? 'Aktif' : 'Pasif' ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-primary shadow btn-xs sharp" data-bs-toggle="collapse" data-bs-target="#service-edit-<?= esc($service['id']) ?>" title="Duzenle">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <form action="<?= base_url('dashboard/services/' . $service['id'] . '/toggle-status') ?>" method="post">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-warning shadow btn-xs sharp" title="Durum Degistir">
                                                <i class="fa fa-power-off"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <tr class="collapse" id="service-edit-<?= esc($service['id']) ?>">
                                <td colspan="5">
                                    <form action="<?= base_url('dashboard/services/' . $service['id'] . '/update') ?>" method="post" class="row g-3 align-items-end bg-light p-3 rounded">
                                        <?= csrf_field() ?>
                                        <div class="col-md-3">
                                            <label class="form-label">Hizmet Adi</label>
                                            <input name="title" type="text" class="form-control" value="<?= esc($service['title']) ?>" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Sure</label>
                                            <input name="duration_minutes" type="number" min="1" class="form-control" value="<?= esc($service['duration_minutes'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Fiyat</label>
                                            <input name="price" type="text" class="form-control" value="<?= esc($service['price'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Durum</label>
                                            <select name="status" class="form-control">
                                                <option value="active" <?= ($service['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Aktif</option>
                                                <option value="passive" <?= ($service['status'] ?? 'active') === 'passive' ? 'selected' : '' ?>>Pasif</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Aciklama</label>
                                            <textarea name="description" rows="2" class="form-control"><?= esc($service['description'] ?? '') ?></textarea>
                                        </div>
                                        <div class="col-md-12 text-end">
                                            <button type="submit" class="btn btn-primary">Guncelle</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
