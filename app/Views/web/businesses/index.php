<?= $this->extend('web/layout') ?>

<?= $this->section('content') ?>
<section class="page-banner pt-165 pb-170">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-banner-content text-center">
                    <h1 class="page-title">İşletmeler</h1>
                    <ul class="breadcrumb-link">
                        <li><a href="<?= base_url() ?>">Ana Sayfa</a></li>
                        <li class="active">İşletmeler</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="job-section pt-120 pb-90">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-center mb-50 wow fadeInDown">
                    <span class="sub-title">Aktif İşletmeler</span>
                    <h2>Size uygun randevu noktasını seçin</h2>
                </div>
            </div>
        </div>

        <div class="job-wrapper">
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <?php if (($businesses ?? []) === []): ?>
                        <div class="single-job-item d-flex mb-40 wow fadeInUp">
                            <div class="sn-number">00</div>
                            <div class="content d-flex">
                                <div class="text">
                                    <h3 class="title">Henüz yayınlanmış işletme bulunmuyor<span class="duration">Yakında</span></h3>
                                    <p class="salary">Yeni işletmeler yayına alındığında burada listelenecek.</p>
                                </div>
                                <div class="action-box">
                                    <a href="<?= base_url('register') ?>" class="main-btn primary-btn">İşletmeni Ekle<i class="far fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php foreach (($businesses ?? []) as $index => $business): ?>
                        <?php
                        $detailUrl = base_url('businesses/' . ($business['slug'] ?? $business['id']));
                        $cardImage = $business['intro_image'] ?: $business['cover_image'] ?: 'web-assets/images/gallery/career-1.jpg';
                        $intro     = $business['short_intro'] ?: $business['short_description'] ?: 'Bu işletmenin tanıtım detayları yayında.';
                        ?>
                        <div class="single-job-item d-flex mb-40 wow fadeInUp align-items-stretch business-job-item">
                            <div class="sn-number"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></div>
                            <div class="content d-flex flex-column flex-lg-row align-items-lg-center w-100 gap-4">
                                <div class="business-job-thumb">
                                    <img src="<?= base_url($cardImage) ?>" alt="<?= esc($business['name']) ?>">
                                </div>
                                <div class="text flex-grow-1">
                                    <h3 class="title">
                                        <?= esc($business['page_title'] ?: $business['name']) ?>
                                        <span class="duration"><?= esc($business['category'] ?: 'İşletme') ?></span>
                                    </h3>
                                    <p class="salary mb-2"><?= esc(trim(($business['city'] ?? '') . ' / ' . ($business['district'] ?? ''), ' /') ?: 'Konum bilgisi yakında') ?></p>
                                    <p class="business-job-summary mb-0"><?= esc($intro) ?></p>
                                </div>
                                <div class="action-box business-job-action">
                                    <a href="<?= $detailUrl ?>" class="main-btn primary-btn">Detayı İncele<i class="far fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.business-job-item {
    background: #fff;
}

.business-job-thumb {
    width: 180px;
    min-width: 180px;
}

.business-job-thumb img {
    width: 100%;
    height: 130px;
    object-fit: cover;
    border-radius: 8px;
}

.business-job-action {
    min-width: 180px;
}

.business-job-summary {
    color: #696969;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

@media (max-width: 991.98px) {
    .business-job-thumb,
    .business-job-action {
        width: 100%;
        min-width: 100%;
    }

    .business-job-thumb img {
        height: 220px;
    }
}
</style>
<?= $this->endSection() ?>
