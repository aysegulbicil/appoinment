<?php
use App\Models\BusinessWorkingHourModel;

$errors   = session('errors') ?? [];
$schedule = $workingHours ?? BusinessWorkingHourModel::defaultSchedule();

$displayTime = static function (?string $time): string {
    return $time === null ? '' : substr($time, 0, 5);
};
?>
<p class="text-muted mb-4">
    Randevu saatleri bu programa gore uretilir: musteriler yalnizca acik gunlerde,
    acilis-kapanis araligindaki bos saatleri secebilir.
</p>

<?php if (isset($errors['hours'])): ?>
    <div class="alert alert-danger"><?= esc($errors['hours']) ?></div>
<?php endif; ?>

<form action="<?= base_url('dashboard/businesses/' . $business['id'] . '/update') ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="section" value="working_hours">

    <div class="table-responsive">
        <table class="table align-middle working-hours-table">
            <thead>
                <tr>
                    <th style="width: 180px;">Gun</th>
                    <th style="width: 120px;">Acik</th>
                    <th style="width: 200px;">Acilis</th>
                    <th style="width: 200px;">Kapanis</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (BusinessWorkingHourModel::DAY_LABELS as $day => $label): ?>
                    <?php $row = $schedule[$day] ?? ['is_open' => 0, 'start_time' => null, 'end_time' => null]; ?>
                    <tr>
                        <td class="fw-bold"><?= esc($label) ?></td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input working-hours-toggle" type="checkbox"
                                       id="hours-open-<?= $day ?>" name="hours[<?= $day ?>][is_open]" value="1"
                                       data-day="<?= $day ?>" <?= $row['is_open'] ? 'checked' : '' ?>>
                            </div>
                        </td>
                        <td>
                            <input type="time" class="form-control" name="hours[<?= $day ?>][start_time]"
                                   id="hours-start-<?= $day ?>" value="<?= esc($displayTime($row['start_time'])) ?>"
                                   <?= $row['is_open'] ? '' : 'disabled' ?>>
                        </td>
                        <td>
                            <input type="time" class="form-control" name="hours[<?= $day ?>][end_time]"
                                   id="hours-end-<?= $day ?>" value="<?= esc($displayTime($row['end_time'])) ?>"
                                   <?= $row['is_open'] ? '' : 'disabled' ?>>
                        </td>
                        <td class="text-muted small">
                            <?= $row['is_open'] ? '' : 'Kapali' ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-primary">Calisma Saatlerini Kaydet</button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.working-hours-toggle').forEach(function (toggle) {
        toggle.addEventListener('change', function () {
            var day = toggle.getAttribute('data-day');
            var start = document.getElementById('hours-start-' + day);
            var end = document.getElementById('hours-end-' + day);
            var statusCell = toggle.closest('tr').querySelector('td:last-child');

            [start, end].forEach(function (input) {
                if (input) {
                    input.disabled = !toggle.checked;
                }
            });

            if (toggle.checked) {
                if (start && start.value === '') { start.value = '09:00'; }
                if (end && end.value === '') { end.value = '18:00'; }
                if (statusCell) { statusCell.textContent = ''; }
            } else if (statusCell) {
                statusCell.textContent = 'Kapali';
            }
        });
    });
});
</script>
