<?php
$appointments = $appointments ?? [];
$statusLabels = $statusLabels ?? [];
$statusBadges = [
    'pending'   => 'warning',
    'approved'  => 'success',
    'rejected'  => 'danger',
    'cancelled' => 'secondary',
];
$errors = session()->getFlashdata('errors') ?? [];
?>

<div class="content-body">
    <div class="container-fluid">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success solid"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <?php if ($errors !== []): ?>
            <div class="alert alert-danger solid">Formda eksik veya hatali alanlar var.</div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <div>
                    <h4 class="card-title mb-1">Randevular</h4>
                    <p class="mb-0 text-muted">Bekleyen randevulari onaylayabilir, reddedebilir veya iptal edebilirsiniz.</p>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive-md">
                        <thead>
                            <tr>
                                <th>Kod</th>
                                <th>Isletme</th>
                                <th>Hizmet</th>
                                <th>Musteri</th>
                                <th>Tarih/Saat</th>
                                <th>Durum</th>
                                <th class="text-end">Islem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($appointments === []): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Henuz randevu talebi bulunmuyor.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($appointments as $appointment): ?>
                                    <?php
                                    $status = $appointment['status'] ?? 'pending';
                                    $time = ! empty($appointment['appointment_time']) ? substr((string) $appointment['appointment_time'], 0, 5) : '-';
                                    $suggestedTime = ! empty($appointment['suggested_time']) ? substr((string) $appointment['suggested_time'], 0, 5) : '';
                                    ?>
                                    <tr>
                                        <td><strong><?= esc($appointment['appointment_code']) ?></strong></td>
                                        <td><?= esc($appointment['business_name'] ?? '-') ?></td>
                                        <td><?= esc($appointment['service_title'] ?? '-') ?></td>
                                        <td>
                                            <strong><?= esc($appointment['customer_name']) ?></strong><br>
                                            <small class="text-muted"><?= esc($appointment['customer_phone']) ?></small><br>
                                            <small class="text-muted"><?= esc($appointment['customer_email']) ?></small>
                                        </td>
                                        <td>
                                            <?= esc(date('d.m.Y', strtotime((string) $appointment['appointment_date']))) ?><br>
                                            <small class="text-muted"><?= esc($time) ?></small>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?= esc($statusBadges[$status] ?? 'secondary') ?> light">
                                                <?= esc($statusLabels[$status] ?? $status) ?>
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-primary shadow btn-xs sharp" data-bs-toggle="modal" data-bs-target="#appointment-edit-<?= esc($appointment['id']) ?>" title="Guncelle">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade appointment-action-modal" id="appointment-edit-<?= esc($appointment['id']) ?>" tabindex="-1" aria-labelledby="appointment-edit-label-<?= esc($appointment['id']) ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div>
                                                        <h5 class="modal-title" id="appointment-edit-label-<?= esc($appointment['id']) ?>">Randevu Sonucu</h5>
                                                        <small class="text-muted"><?= esc($appointment['appointment_code']) ?> - <?= esc($appointment['customer_name']) ?></small>
                                                    </div>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                                                </div>
                                                <form action="<?= base_url('dashboard/appointments/' . $appointment['id'] . '/update') ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <div class="modal-body">
                                                        <div class="appointment-summary mb-4">
                                                            <div>
                                                                <span>Isletme</span>
                                                                <strong><?= esc($appointment['business_name'] ?? '-') ?></strong>
                                                            </div>
                                                            <div>
                                                                <span>Hizmet</span>
                                                                <strong><?= esc($appointment['service_title'] ?? '-') ?></strong>
                                                            </div>
                                                            <div>
                                                                <span>Tarih/Saat</span>
                                                                <strong><?= esc(date('d.m.Y', strtotime((string) $appointment['appointment_date']))) ?> <?= esc($time) ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label">Durum</label>
                                                                <select name="status" class="form-control appointment-status-select">
                                                                    <?php foreach ($statusLabels as $value => $label): ?>
                                                                        <option value="<?= esc($value) ?>" <?= $status === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Ic Not</label>
                                                                <input name="admin_note" type="text" class="form-control" value="<?= esc($appointment['admin_note'] ?? '') ?>">
                                                            </div>
                                                            <div class="col-md-12 appointment-conditional-fields">
                                                                <div class="row g-3">
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Alternatif Tarih</label>
                                                                        <input name="suggested_date" type="date" class="form-control" value="<?= esc($appointment['suggested_date'] ?? '') ?>">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Alternatif Saat</label>
                                                                        <input name="suggested_time" type="time" class="form-control" value="<?= esc($suggestedTime) ?>">
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label class="form-label">Red/Iptal Sebebi</label>
                                                                        <textarea name="rejection_reason" rows="3" class="form-control"><?= esc($appointment['rejection_reason'] ?? '') ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php if (! empty($appointment['note'])): ?>
                                                                <div class="col-md-12">
                                                                    <div class="customer-note">
                                                                        <span>Musteri Notu</span>
                                                                        <p><?= esc($appointment['note']) ?></p>
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Vazgec</button>
                                                        <button type="submit" class="btn btn-primary">Kaydet</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.appointment-action-modal .modal-content {
    border: 0;
    border-radius: 8px;
}

.appointment-summary {
    background: #f5f7fb;
    border: 1px solid #e6ebf2;
    border-radius: 8px;
    display: grid;
    gap: 12px;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    padding: 16px;
}

.appointment-summary span,
.customer-note span {
    color: #7e8299;
    display: block;
    font-size: 12px;
    margin-bottom: 4px;
}

.appointment-summary strong {
    color: #111827;
    display: block;
    overflow-wrap: anywhere;
}

.appointment-conditional-fields {
    display: none;
}

.appointment-conditional-fields.is-visible {
    display: block;
}

.customer-note {
    background: #fff;
    border: 1px solid #e6ebf2;
    border-radius: 8px;
    padding: 14px 16px;
}

.customer-note p {
    margin-bottom: 0;
}

@media (max-width: 767.98px) {
    .appointment-summary {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var toggleConditionalFields = function (select) {
        var modal = select.closest('.appointment-action-modal');
        var fields = modal ? modal.querySelector('.appointment-conditional-fields') : null;
        var shouldShow = select.value === 'rejected' || select.value === 'cancelled';

        if (fields) {
            fields.classList.toggle('is-visible', shouldShow);
        }
    };

    document.querySelectorAll('.appointment-status-select').forEach(function (select) {
        toggleConditionalFields(select);
        select.addEventListener('change', function () {
            toggleConditionalFields(select);
        });
    });
});
</script>
