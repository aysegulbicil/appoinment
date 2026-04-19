<?= $this->extend('web/layout') ?>

<?= $this->section('content') ?>
<?php
$coverImage   = ($webSettings['cover_image'] ?? '') !== '' ? $webSettings['cover_image'] : 'web-assets/images/bg/page-bg.jpg';
$introImage   = ($webSettings['intro_image'] ?? '') !== '' ? $webSettings['intro_image'] : $coverImage;
$summaryText  = $webSettings['short_intro'] ?? $business['short_description'] ?? '';
$detailTitle  = $webSettings['page_title'] ?? $business['name'];
$galleryItems = $galleryImages ?? [];
$services     = $services ?? [];
$appointmentErrors = session()->getFlashdata('appointment_errors') ?? [];
$hasAppointmentErrors = $appointmentErrors !== [];
?>

<section class="page-banner overlay pt-170 pb-170 bg_cover" style="background-image: url('<?= base_url($coverImage) ?>');">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-banner-content text-center text-white">
                    <span class="sub-title"><?= esc($business['category'] ?: 'Isletme') ?></span>
                    <h1 class="page-title"><?= esc($detailTitle) ?></h1>
                    <ul class="breadcrumb-link text-white">
                        <li><a href="<?= base_url() ?>">Ana Sayfa</a></li>
                        <li><a href="<?= base_url('businesses') ?>">Isletmeler</a></li>
                        <li class="active"><?= esc($business['name']) ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="portfolio-details-section pt-120 pb-55">
    <div class="container">
        <div class="portfolio-details-wrapper">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="content mb-50 wow fadeInLeft">
                        <h2><?= esc($detailTitle) ?></h2>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="content mb-50 wow fadeInRight">
                        <?php if ($summaryText !== ''): ?>
                            <p><?= esc($summaryText) ?></p>
                        <?php else: ?>
                            <p>Bu isletme icin detayli tanitim icerigi panelden guncelleniyor.</p>
                        <?php endif; ?>
                        <button type="button" class="main-btn filled-btn mt-3" data-bs-toggle="modal" data-bs-target="#appointmentModal">
                            Randevu Al
                        </button>
                    </div>
                </div>
            </div>

            <?php if (session()->getFlashdata('appointment_success')): ?>
                <div class="alert alert-success mb-4"><?= esc(session()->getFlashdata('appointment_success')) ?></div>
            <?php endif; ?>

            <?php if ($hasAppointmentErrors): ?>
                <div class="alert alert-danger mb-4">Randevu formunda eksik veya hatali alanlar var.</div>
            <?php endif; ?>

            <div class="portfolio-info-area business-info-area gray-bg mb-80 wow fadeInUp">
                <h3>İşletme Bilgileri</h3>
                <ul>
                    <li><span class="title">Kategori</span><span><?= esc($business['category'] ?: '-') ?></span></li>
                    <li><span class="title">Konum</span><span><?= esc(trim(($business['city'] ?? '') . ' / ' . ($business['district'] ?? ''), ' /') ?: '-') ?></span></li>
                    <?php if (($webSettings['show_contact'] ?? true)): ?>
                        <li><span class="title">Telefon</span><span><?= esc($business['phone'] ?: '-') ?></span></li>
                        <li><span class="title">E-posta</span><span><?= esc($business['email'] ?: '-') ?></span></li>
                    <?php endif; ?>
                    <?php if (($webSettings['show_prices'] ?? true)): ?>
                        <li><span class="title">Randevu</span><span><?= $services === [] ? 'Hizmet listesi hazirlaniyor' : 'Online randevu talebi alinabilir' ?></span></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="content mb-45 wow fadeInLeft">
                        <h3>Isletme Tanitimi</h3>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="content mb-45 wow fadeInRight business-detail-content">
                        <?php if (! empty($webSettings['content'])): ?>
                            <?= $webSettings['content'] ?>
                        <?php elseif ($summaryText !== ''): ?>
                            <p><?= esc($summaryText) ?></p>
                        <?php else: ?>
                            <p>Bu alan paneldeki web ayarlarindan doldurulacaktir.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if ($galleryItems !== []): ?>
                <div class="row pt-3">
                    <div class="col-lg-6">
                        <div class="content mb-45 wow fadeInLeft">
                            <h3>Galeri</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="content mb-45 wow fadeInRight">
                            <p>Isletmenin panelden ekledigi gorseller burada listelenir.</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php foreach ($galleryItems as $image): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="block-image mb-30 wow fadeInUp business-gallery-card">
                                <a href="<?= base_url($image) ?>" class="img-popup">
                                    <img src="<?= base_url($image) ?>" alt="<?= esc($business['name']) ?>">
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content business-appointment-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="appointmentModalLabel"><?= esc($business['name']) ?> - Randevu Al</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <form action="<?= base_url('businesses/' . $business['id'] . '/appointments') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <?php if ($services === []): ?>
                        <div class="alert alert-warning mb-0">Bu isletme icin henuz aktif hizmet bulunmuyor.</div>
                    <?php else: ?>
                        <div class="row g-3">
                            <div class="col-md-12 appointment-service-field">
                                <label class="form-label" for="appointment-service">Hizmet</label>
                                <select id="appointment-service" name="business_service_id" class="form-control appointment-service-select<?= isset($appointmentErrors['business_service_id']) ? ' is-invalid' : '' ?>" required>
                                    <option value="">Hizmet secin</option>
                                    <?php foreach ($services as $service): ?>
                                        <option value="<?= esc($service['id']) ?>" <?= (string) old('business_service_id') === (string) $service['id'] ? 'selected' : '' ?>>
                                            <?= esc($service['title']) ?>
                                            <?php if (! empty($service['duration_minutes'])): ?> - <?= esc($service['duration_minutes']) ?> dk<?php endif; ?>
                                            <?php if ($service['price'] !== null && $service['price'] !== ''): ?> - <?= esc(number_format((float) $service['price'], 2, ',', '.')) ?> TL<?php endif; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (isset($appointmentErrors['business_service_id'])): ?><div class="invalid-feedback"><?= esc($appointmentErrors['business_service_id']) ?></div><?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="appointment-name">Ad Soyad</label>
                                <input id="appointment-name" name="customer_name" type="text" class="form-control<?= isset($appointmentErrors['customer_name']) ? ' is-invalid' : '' ?>" value="<?= esc(old('customer_name')) ?>" required>
                                <?php if (isset($appointmentErrors['customer_name'])): ?><div class="invalid-feedback"><?= esc($appointmentErrors['customer_name']) ?></div><?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="appointment-phone">Telefon</label>
                                <input id="appointment-phone" name="customer_phone" type="tel" class="form-control<?= isset($appointmentErrors['customer_phone']) ? ' is-invalid' : '' ?>" value="<?= esc(old('customer_phone')) ?>" required>
                                <?php if (isset($appointmentErrors['customer_phone'])): ?><div class="invalid-feedback"><?= esc($appointmentErrors['customer_phone']) ?></div><?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="appointment-email">E-posta</label>
                                <input id="appointment-email" name="customer_email" type="email" class="form-control<?= isset($appointmentErrors['customer_email']) ? ' is-invalid' : '' ?>" value="<?= esc(old('customer_email')) ?>" required>
                                <?php if (isset($appointmentErrors['customer_email'])): ?><div class="invalid-feedback"><?= esc($appointmentErrors['customer_email']) ?></div><?php endif; ?>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="appointment-date">Tarih</label>
                                <input id="appointment-date" name="appointment_date" type="date" min="<?= esc(date('Y-m-d')) ?>" class="form-control<?= isset($appointmentErrors['appointment_date']) ? ' is-invalid' : '' ?>" value="<?= esc(old('appointment_date')) ?>" required>
                                <?php if (isset($appointmentErrors['appointment_date'])): ?><div class="invalid-feedback"><?= esc($appointmentErrors['appointment_date']) ?></div><?php endif; ?>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="appointment-time">Saat</label>
                                <input id="appointment-time" name="appointment_time" type="time" class="form-control<?= isset($appointmentErrors['appointment_time']) ? ' is-invalid' : '' ?>" value="<?= esc(old('appointment_time')) ?>" required>
                                <?php if (isset($appointmentErrors['appointment_time'])): ?><div class="invalid-feedback"><?= esc($appointmentErrors['appointment_time']) ?></div><?php endif; ?>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="appointment-note">Not</label>
                                <textarea id="appointment-note" name="note" rows="4" class="form-control<?= isset($appointmentErrors['note']) ? ' is-invalid' : '' ?>"><?= esc(old('note')) ?></textarea>
                                <?php if (isset($appointmentErrors['note'])): ?><div class="invalid-feedback"><?= esc($appointmentErrors['note']) ?></div><?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Vazgec</button>
                    <button type="submit" class="btn btn-primary" <?= $services === [] ? 'disabled' : '' ?>>Randevu Talebi Gonder</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.business-detail-content img {
    max-width: 100%;
    height: auto;
    border-radius: 16px;
    margin: 18px 0;
}

.business-detail-content p:last-child {
    margin-bottom: 0;
}

.business-gallery-card img {
    width: 100%;
    height: 280px;
    object-fit: cover;
}

.business-info-area > ul {
    display: grid;
    gap: 22px 32px;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    width: 100%;
}

.business-info-area > ul > li {
    display: block;
    margin-bottom: 0;
    min-width: 0;
    width: auto;
}

.business-info-area > ul > li span {
    display: block;
    overflow-wrap: anywhere;
}

.business-info-area > ul > li span.title {
    font-size: 16px;
    line-height: 1.35;
    margin-bottom: 6px;
}

.business-info-area > ul > li span.title:after {
    display: none;
}

.business-appointment-modal .form-label {
    color: #1f2933;
    font-weight: 600;
}

.business-appointment-modal .form-control {
    border-color: #d7dde8;
    min-height: 48px;
}

.business-appointment-modal .appointment-service-field {
    position: relative;
    z-index: 3;
}

.business-appointment-modal .appointment-service-select {
    width: 100%;
}

.business-appointment-modal .nice-select {
    background-color: #fff;
    border-color: #d7dde8;
    border-radius: 4px;
    box-sizing: border-box;
    clear: both;
    display: block;
    float: none;
    height: 48px;
    line-height: 46px;
    margin-top: 0;
    padding-left: 14px;
    padding-right: 34px;
    width: 100%;
}

.business-appointment-modal .nice-select .current {
    display: block;
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.business-appointment-modal .nice-select .list {
    max-height: 240px;
    overflow-y: auto;
    width: 100%;
}

.business-appointment-modal textarea.form-control {
    min-height: 120px;
}
</style>

<?php if ($hasAppointmentErrors): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modalElement = document.getElementById('appointmentModal');
    if (modalElement && window.bootstrap && bootstrap.Modal) {
        bootstrap.Modal.getOrCreateInstance(modalElement).show();
    }
});
</script>
<?php endif; ?>
<?= $this->endSection() ?>
