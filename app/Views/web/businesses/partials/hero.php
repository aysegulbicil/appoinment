<?php
$heroImage = ! empty($currentPage['cover_image'])
    ? $currentPage['cover_image']
    : (! empty($webSettings['cover_image']) ? $webSettings['cover_image'] : 'web-assets/images/bg/page-bg.jpg');

$heroTitle = $currentPage['title'] ?? ($business['name'] ?? '');
$heroIntro = $currentPage['short_intro'] ?? $webSettings['short_intro'] ?? $business['short_description'] ?? '';
?>
<section class="page-banner overlay pt-170 pb-170 bg_cover" style="background-image: url('<?= base_url($heroImage) ?>');">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-banner-content text-center text-white">
                    <span class="sub-title"><?= esc($business['category'] ?: 'İşletme') ?></span>
                    <h1 class="page-title"><?= esc($heroTitle) ?></h1>
                    <?php if ($heroIntro !== ''): ?>
                        <p class="mt-3 mb-0"><?= esc($heroIntro) ?></p>
                    <?php endif; ?>
                    <ul class="breadcrumb-link text-white mt-3">
                        <li><a href="<?= base_url() ?>">Ana Sayfa</a></li>
                        <li><a href="<?= base_url('businesses') ?>">İşletmeler</a></li>
                        <li class="active"><?= esc($business['name']) ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
