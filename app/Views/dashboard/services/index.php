<?php
$errors = session('errors') ?? [];
$businesses = $businesses ?? [];
$selectedBusiness = $selectedBusiness ?? null;
$services = $services ?? [];
$statusLabels = $statusLabels ?? [];
$showCreateModal = $errors !== [];
?>
<div class="content-body">
    <div class="container-fluid">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success solid"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger solid"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h4 class="card-title mb-0">Hizmetler</h4>
                <?php if ($selectedBusiness !== null): ?>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#service-create-modal">
                        Hizmet Ekle
                    </button>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <?php if ($businesses !== []): ?>
                    <form action="<?= base_url('dashboard/services') ?>" method="get" class="row g-3 align-items-end mb-4">
                        <div class="col-md-5 col-lg-4">
                            <label class="form-label" for="service-business-filter">İşletme Filtresi</label>
                            <select id="service-business-filter" name="business_id" class="form-control" onchange="this.form.submit()">
                                <?php foreach ($businesses as $business): ?>
                                    <option value="<?= esc($business['id']) ?>" <?= (int) ($selectedBusiness['id'] ?? 0) === (int) $business['id'] ? 'selected' : '' ?>>
                                        <?= esc($business['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                <?php endif; ?>

                <?php if ($selectedBusiness === null): ?>
                    <p class="text-muted mb-0">Hizmet eklemek için önce bir işletme oluşturmalısınız.</p>
                <?php elseif ($services === []): ?>
                    <p class="text-muted mb-0">Bu işletme için henüz hizmet eklenmemiş.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-responsive-md">
                            <thead>
                                <tr>
                                    <th>Hizmet Adı</th>
                                    <th>Süre</th>
                                    <th>Fiyat</th>
                                    <th>Durum</th>
                                    <th>Açıklama</th>
                                    <th>İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($services as $service): ?>
                                    <?php $updateFormId = 'service-update-' . $service['id']; ?>
                                    <tr>
                                        <td style="min-width: 190px;">
                                            <form id="<?= esc($updateFormId) ?>" action="<?= base_url('dashboard/services/' . $service['id'] . '/update') ?>" method="post">
                                                <?= csrf_field() ?>
                                            </form>
                                            <input form="<?= esc($updateFormId) ?>" name="title" type="text" class="form-control form-control-sm" value="<?= esc($service['title']) ?>" required>
                                        </td>
                                        <td style="min-width: 120px;">
                                            <input form="<?= esc($updateFormId) ?>" name="duration_minutes" type="number" min="1" class="form-control form-control-sm" value="<?= esc($service['duration_minutes'] ?? '') ?>">
                                        </td>
                                        <td style="min-width: 130px;">
                                            <input form="<?= esc($updateFormId) ?>" name="price" type="text" class="form-control form-control-sm" value="<?= esc($service['price'] ?? '') ?>">
                                        </td>
                                        <td style="min-width: 130px;">
                                            <select form="<?= esc($updateFormId) ?>" name="status" class="form-control form-control-sm">
                                                <?php foreach ($statusLabels as $value => $label): ?>
                                                    <option value="<?= esc($value) ?>" <?= ($service['status'] ?? 'active') === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td style="min-width: 260px;">
                                            <textarea form="<?= esc($updateFormId) ?>" name="description" rows="1" class="form-control form-control-sm"><?= esc($service['description'] ?? '') ?></textarea>
                                        </td>
                                        <td style="min-width: 150px;">
                                            <div class="d-flex gap-2">
                                                <button form="<?= esc($updateFormId) ?>" type="submit" class="btn btn-primary btn-sm">Kaydet</button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if ($selectedBusiness !== null): ?>
    <div class="modal fade<?= $showCreateModal ? ' show' : '' ?>" id="service-create-modal" tabindex="-1" aria-labelledby="service-create-modal-label" aria-hidden="<?= $showCreateModal ? 'false' : 'true' ?>"<?= $showCreateModal ? ' style="display:block;"' : '' ?>>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="<?= base_url('dashboard/services/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="business_id" value="<?= esc($selectedBusiness['id']) ?>">

                    <div class="modal-header">
                        <h5 class="modal-title" id="service-create-modal-label">Hizmet Ekle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="service-title">Hizmet Adı</label>
                            <input id="service-title" name="title" type="text" class="form-control<?= isset($errors['title']) ? ' is-invalid' : '' ?>" value="<?= esc(old('title')) ?>" required>
                            <?php if (isset($errors['title'])): ?><div class="invalid-feedback"><?= esc($errors['title']) ?></div><?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="service-duration">Süre (dakika)</label>
                                <input id="service-duration" name="duration_minutes" type="number" min="1" class="form-control<?= isset($errors['duration_minutes']) ? ' is-invalid' : '' ?>" value="<?= esc(old('duration_minutes')) ?>">
                                <?php if (isset($errors['duration_minutes'])): ?><div class="invalid-feedback"><?= esc($errors['duration_minutes']) ?></div><?php endif; ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="service-price">Fiyat</label>
                                <input id="service-price" name="price" type="text" class="form-control<?= isset($errors['price']) ? ' is-invalid' : '' ?>" value="<?= esc(old('price')) ?>" placeholder="750.00">
                                <?php if (isset($errors['price'])): ?><div class="invalid-feedback"><?= esc($errors['price']) ?></div><?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="service-status">Durum</label>
                            <select id="service-status" name="status" class="form-control">
                                <?php foreach ($statusLabels as $value => $label): ?>
                                    <option value="<?= esc($value) ?>" <?= old('status', 'active') === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-0">
                            <label class="form-label" for="service-description">Açıklama</label>
                            <textarea id="service-description" name="description" rows="4" class="form-control<?= isset($errors['description']) ? ' is-invalid' : '' ?>"><?= esc(old('description')) ?></textarea>
                            <?php if (isset($errors['description'])): ?><div class="invalid-feedback"><?= esc($errors['description']) ?></div><?php endif; ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Vazgeç</button>
                        <button type="submit" class="btn btn-primary">Hizmeti Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php if ($showCreateModal): ?>
        <div class="modal-backdrop fade show"></div>
    <?php endif; ?>
<?php endif; ?>
