<?= $this->extend('web/layout') ?>

<?= $this->section('content') ?>
<?php
$coverImage   = ($webSettings['cover_image'] ?? '') !== '' ? $webSettings['cover_image'] : 'web-assets/images/bg/page-bg.jpg';
$introImage   = ($webSettings['intro_image'] ?? '') !== '' ? $webSettings['intro_image'] : $coverImage;
$summaryText  = $webSettings['short_intro'] ?? $business['short_description'] ?? '';
$detailTitle  = $webSettings['page_title'] ?? $business['name'];
$galleryItems = $galleryImages ?? [];
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
                    </div>
                </div>
            </div>

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
                        <li><span class="title">Randevu</span><span>Fiyat ve hizmet detayları panel bağlantılarıyla yayınlanacak</span></li>
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
</style>
<?= $this->endSection() ?>
