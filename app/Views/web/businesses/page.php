<?php
$page = $currentPage ?? [];
$galleryItems = $galleryImages ?? [];
$services = $services ?? [];
?>

<section class="portfolio-details-section pt-120 pb-55">
    <div class="container">
        <div class="portfolio-details-wrapper">
            <div class="row align-items-center mb-4">
                <div class="col-lg-6">
                    <h2 class="mb-3"><?= esc($page['title'] ?? $business['name']) ?></h2>
                    <?php if (! empty($page['short_intro'])): ?>
                        <p class="mb-0"><?= esc($page['short_intro']) ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <button type="button" class="main-btn filled-btn mt-3 mt-lg-0" data-bs-toggle="modal" data-bs-target="#appointmentModal">
                        Randevu Al
                    </button>
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
                        <li><span class="title">Randevu</span><span><?= $services === [] ? 'Hizmet listesi hazırlanıyor' : 'Online randevu talebi alınabilir' ?></span></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="content mb-45 wow fadeInLeft">
                        <h3>Sayfa İçeriği</h3>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="content mb-45 wow fadeInRight business-detail-content">
                        <?php if (! empty($page['content'])): ?>
                            <?= $page['content'] ?>
                        <?php elseif (! empty($page['short_intro'])): ?>
                            <p><?= esc($page['short_intro']) ?></p>
                        <?php else: ?>
                            <p>Bu sayfa için içerik henüz eklenmemiş.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if (($page['intro_image'] ?? '') !== ''): ?>
                <div class="row mb-5">
                    <div class="col-lg-12">
                        <div class="business-page-intro-image">
                            <img src="<?= base_url($page['intro_image']) ?>" alt="<?= esc($page['title'] ?? $business['name']) ?>" class="img-fluid rounded-4">
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($galleryItems !== []): ?>
                <div class="row pt-3">
                    <div class="col-lg-6">
                        <div class="content mb-45 wow fadeInLeft">
                            <h3>Galeri</h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="content mb-45 wow fadeInRight">
                            <p>Bu sayfaya ait görseller burada listelenir.</p>
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

            <?php if (($page['page_type'] ?? '') === 'services' && $services !== []): ?>
                <div class="row mt-4">
                    <div class="col-12">
                        <h3 class="mb-4">Hizmetler</h3>
                    </div>
                    <?php foreach ($services as $service): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title"><?= esc($service['title']) ?></h5>
                                    <?php if (! empty($service['description'])): ?>
                                        <p class="card-text"><?= esc($service['description']) ?></p>
                                    <?php endif; ?>
                                    <div class="small text-muted">
                                        <?php if (! empty($service['duration_minutes'])): ?><?= esc($service['duration_minutes']) ?> dk<?php endif; ?>
                                        <?php if ($service['price'] !== null && $service['price'] !== ''): ?>
                                            <?php if (! empty($service['duration_minutes'])): ?> · <?php endif; ?>
                                            <?= esc(number_format((float) $service['price'], 2, ',', '.')) ?> TL
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
