<?php
$errors = session('errors') ?? [];
$businesses = $businesses ?? [];
$selectedBusiness = $selectedBusiness ?? null;
$staff = $staff ?? [];
$roleLabels = $roleLabels ?? [];
$statusLabels = $statusLabels ?? [];
$canManageStaff = (bool) ($canManageStaff ?? false);
$showCreateModal = $canManageStaff && $errors !== [];
?>
<div class="content-body">
    <div class="container-fluid">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success solid"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger solid"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-xl-4 d-none">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">İşletme</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($businesses === []): ?>
                            <p class="text-muted mb-0">Çalışan eklemek için önce bir işletme oluşturmalısınız.</p>
                        <?php else: ?>
                            <form action="<?= base_url('dashboard/employees') ?>" method="get">
                                <label class="form-label" for="business_id">İşletme seçin</label>
                                <select id="business_id" name="business_id" class="form-control" onchange="this.form.submit()">
                                    <?php foreach ($businesses as $business): ?>
                                        <option value="<?= esc($business['id']) ?>" <?= (int) ($selectedBusiness['id'] ?? 0) === (int) $business['id'] ? 'selected' : '' ?>>
                                            <?= esc($business['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($selectedBusiness !== null && $canManageStaff): ?>
                    <div class="card d-none">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Çalışan Ekle</h4>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('dashboard/employees/store') ?>" method="post">
                                <?= csrf_field() ?>
                                <input type="hidden" name="business_id" value="<?= esc($selectedBusiness['id']) ?>">

                                <div class="mb-3">
                                    <label class="form-label" for="name">Ad Soyad</label>
                                    <input id="name" name="name" type="text" class="form-control<?= isset($errors['name']) ? ' is-invalid' : '' ?>" value="<?= esc(old('name')) ?>">
                                    <?php if (isset($errors['name'])): ?><div class="invalid-feedback"><?= esc($errors['name']) ?></div><?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="email">E-posta</label>
                                    <input id="email" name="email" type="email" class="form-control<?= isset($errors['email']) ? ' is-invalid' : '' ?>" value="<?= esc(old('email')) ?>">
                                    <?php if (isset($errors['email'])): ?><div class="invalid-feedback"><?= esc($errors['email']) ?></div><?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="phone">Telefon</label>
                                    <input id="phone" name="phone" type="text" class="form-control<?= isset($errors['phone']) ? ' is-invalid' : '' ?>" value="<?= esc(old('phone')) ?>">
                                    <?php if (isset($errors['phone'])): ?><div class="invalid-feedback"><?= esc($errors['phone']) ?></div><?php endif; ?>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" for="role">Rol</label>
                                    <select id="role" name="role" class="form-control<?= isset($errors['role']) ? ' is-invalid' : '' ?>">
                                        <?php foreach ($roleLabels as $value => $label): ?>
                                            <option value="<?= esc($value) ?>" <?= old('role', 'staff') === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (isset($errors['role'])): ?><div class="invalid-feedback"><?= esc($errors['role']) ?></div><?php endif; ?>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">Çalışan Ekle</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <?php if ($selectedBusiness !== null && $canManageStaff): ?>
                            <button type="button" class="btn btn-primary order-2" data-bs-toggle="modal" data-bs-target="#employee-create-modal">
                                Çalışan Ekle
                            </button>
                        <?php endif; ?>
                        <h4 class="card-title mb-0">Çalışanlar</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($businesses !== []): ?>
                            <form action="<?= base_url('dashboard/employees') ?>" method="get" class="row g-3 align-items-end mb-4">
                                <div class="col-md-5 col-lg-12">
                                    <label class="form-label" for="employee-business-filter">İşletme Filtresi</label>
                                    <select id="employee-business-filter" name="business_id" class="form-control" onchange="this.form.submit()">
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
                            <p class="text-muted mb-0">Henüz erişebileceğiniz bir işletme bulunmuyor.</p>
                        <?php elseif ($staff === []): ?>
                            <p class="text-muted mb-0">Bu işletme için henüz çalışan eklenmemiş.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-responsive-md">
                                    <thead>
                                        <tr>
                                            <th>Ad Soyad</th>
                                            <th>E-posta</th>
                                            <th>Telefon</th>
                                            <th>Rol</th>
                                            <th>Durum</th>
                                            <th>Hesap</th>
                                            <?php if ($canManageStaff): ?><th>İşlem</th><?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($staff as $employee): ?>
                                            <?php $updateFormId = 'employee-update-' . $employee['id']; ?>
                                            <tr>
                                                <td style="min-width: 180px;">
                                                    <?php if ($canManageStaff): ?>
                                                        <form id="<?= esc($updateFormId) ?>" action="<?= base_url('dashboard/employees/' . $employee['id'] . '/update') ?>" method="post">
                                                            <?= csrf_field() ?>
                                                        </form>
                                                        <input form="<?= esc($updateFormId) ?>" name="name" type="text" class="form-control form-control-sm" value="<?= esc($employee['name']) ?>">
                                                    <?php else: ?>
                                                        <strong><?= esc($employee['name']) ?></strong>
                                                    <?php endif; ?>
                                                </td>
                                                <td style="min-width: 220px;">
                                                    <span class="text-muted"><?= esc($employee['email']) ?></span>
                                                </td>
                                                <td style="min-width: 150px;">
                                                    <?php if ($canManageStaff): ?>
                                                        <input form="<?= esc($updateFormId) ?>" name="phone" type="text" class="form-control form-control-sm" value="<?= esc($employee['phone'] ?? '') ?>">
                                                    <?php else: ?>
                                                        <?= esc($employee['phone'] ?: '-') ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td style="min-width: 140px;">
                                                    <?php if ($canManageStaff): ?>
                                                        <select form="<?= esc($updateFormId) ?>" name="role" class="form-control form-control-sm">
                                                            <?php foreach ($roleLabels as $value => $label): ?>
                                                                <option value="<?= esc($value) ?>" <?= $employee['role'] === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    <?php else: ?>
                                                        <?= esc($roleLabels[$employee['role']] ?? $employee['role']) ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td style="min-width: 130px;">
                                                    <?php if ($canManageStaff): ?>
                                                        <select form="<?= esc($updateFormId) ?>" name="status" class="form-control form-control-sm">
                                                            <?php foreach ($statusLabels as $value => $label): ?>
                                                                <option value="<?= esc($value) ?>" <?= $employee['status'] === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    <?php else: ?>
                                                        <span class="badge <?= ($employee['status'] ?? 'active') === 'active' ? 'badge-success' : 'badge-secondary' ?> light">
                                                            <?= esc($statusLabels[$employee['status']] ?? $employee['status']) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (! empty($employee['user_id'])): ?>
                                                        <span class="badge badge-info light">Bağlandı</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-warning light">Davetli</span>
                                                    <?php endif; ?>
                                                </td>
                                                <?php if ($canManageStaff): ?>
                                                    <td style="min-width: 100px;">
                                                        <button form="<?= esc($updateFormId) ?>" type="submit" class="btn btn-primary btn-sm">Kaydet</button>
                                                    </td>
                                                <?php endif; ?>
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
    </div>
</div>

<?php if ($selectedBusiness !== null && $canManageStaff): ?>
    <div class="modal fade<?= $showCreateModal ? ' show' : '' ?>" id="employee-create-modal" tabindex="-1" aria-labelledby="employee-create-modal-label" aria-hidden="<?= $showCreateModal ? 'false' : 'true' ?>"<?= $showCreateModal ? ' style="display:block;"' : '' ?>>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="<?= base_url('dashboard/employees/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="business_id" value="<?= esc($selectedBusiness['id']) ?>">

                    <div class="modal-header">
                        <h5 class="modal-title" id="employee-create-modal-label">Çalışan Ekle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="employee-name">Ad Soyad</label>
                            <input id="employee-name" name="name" type="text" class="form-control<?= isset($errors['name']) ? ' is-invalid' : '' ?>" value="<?= esc(old('name')) ?>">
                            <?php if (isset($errors['name'])): ?><div class="invalid-feedback"><?= esc($errors['name']) ?></div><?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="employee-email">E-posta</label>
                            <input id="employee-email" name="email" type="email" class="form-control<?= isset($errors['email']) ? ' is-invalid' : '' ?>" value="<?= esc(old('email')) ?>">
                            <?php if (isset($errors['email'])): ?><div class="invalid-feedback"><?= esc($errors['email']) ?></div><?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="employee-phone">Telefon</label>
                            <input id="employee-phone" name="phone" type="text" class="form-control<?= isset($errors['phone']) ? ' is-invalid' : '' ?>" value="<?= esc(old('phone')) ?>">
                            <?php if (isset($errors['phone'])): ?><div class="invalid-feedback"><?= esc($errors['phone']) ?></div><?php endif; ?>
                        </div>

                        <div class="mb-0">
                            <label class="form-label" for="employee-role">Rol</label>
                            <select id="employee-role" name="role" class="form-control<?= isset($errors['role']) ? ' is-invalid' : '' ?>">
                                <?php foreach ($roleLabels as $value => $label): ?>
                                    <option value="<?= esc($value) ?>" <?= old('role', 'staff') === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['role'])): ?><div class="invalid-feedback"><?= esc($errors['role']) ?></div><?php endif; ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Vazgeç</button>
                        <button type="submit" class="btn btn-primary">Çalışan Ekle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php if ($showCreateModal): ?>
        <div class="modal-backdrop fade show"></div>
    <?php endif; ?>
<?php endif; ?>
