<section class="hero-section">
    <div class="hero-wrapper-one">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 order-2 order-xl-1">
                    <div class="hero-content">
                        <span class="tag-line wow fadeInDown" data-wow-delay=".3s"><i class="far fa-arrow-right"></i>Akıllı Randevu Yönetim Sistemi</span>
                        <h1 class="wow fadeInUp" data-wow-delay=".5s">Randevularınızı Otomatikleştirin, İşinizi Büyütün</h1>
                        <div class="hero-button mb-40 wow fadeInDown" data-wow-delay=".7s">
                            <a href="<?= base_url('register') ?>" class="main-btn primary-btn">Ücretsiz Başla<i class="far fa-arrow-right"></i></a>
                            <a href="#process" class="main-btn secondary-btn">Nasıl Çalışır?<i class="far fa-arrow-right"></i></a>
                        </div>
                        <div class="award-box wow fadeInUp" data-wow-delay=".8s">
                            <p>Müşterileriniz online randevu alsın, siz zaman kaybetmeden işinize odaklanın. Tüm randevularınızı, çalışanlarınızı ve hizmetlerinizi tek panelden yönetin.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 order-1 order-xl-2">
                    <div class="hero-one-image wow fadeInRight" data-wow-delay=".8s">
                        <img src="web-assets/images/hero/hero-one_img-1.webp" alt="Hero Image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--====== Start Pricing Section ======-->
<section class="pricing-section pb-90">
    <div class="container-fluid">
        <div class="pricing-wrapper bg_cover pt-120 pb-90" style="background-image: url(assets/images/bg/pattern-bg.jpg);">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <div class="section-title text-center mb-55 wow fadeInDown">
                            <span class="sub-title">Ücretlendirme</span>
                            <h2>Kendinize Uygun Planı Seçin ve Başlayın</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <?php foreach (($packages ?? []) as $package): ?>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="single-pricing-item mb-40 wow fadeInUp">
                                <div class="pricing-head">
                                    <span class="badge bg-white text-dark mb-3"><?= esc($package['badge']) ?></span>
                                    <h3 class="title"><?= esc($package['name']) ?></h3>
                                    <p class="price"><?= esc($package['priceLabel']) ?></p>
                                </div>
                                <div class="pricing-body">
                                    <a href="<?= base_url('packages/select/' . $package['code']) ?>" class="main-btn primary-btn"><?= esc($package['ctaLabel']) ?><i class="far fa-arrow-right"></i></a>
                                    <p><?= esc($package['description']) ?></p>
                                    <ul class="pricing-check">
                                        <?php foreach ($package['features'] as $feature): ?>
                                            <li class="check"><i class="flaticon-check"></i><?= esc($feature) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section><!--====== End Pricing Section ======-->

<section class="cta-section cta_area-one">
    <div class="container-fluid">
        <div class="cta-wrapper yellow-bg">
            <div class="row align-items-center">
                <div class="col-lg-6 order-2 order-lg-1">
                    <div class="cta_one-content-box mb-30 wow fadeInUp">
                        <h2>Doğru paketi seçin, kurulumu hemen başlatın</h2>
                        <a href="#process" class="main-btn primary-btn">Süreci İncele<i class="far fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2">
                    <div class="cta_image-one float-xl-end p-r z-1 mb-30 wow fadeInDown">
                        <div class="shape"><span><img src="web-assets/images/gallery/experience.png" alt=""></span></div>
                        <img src="web-assets/images/gallery/cta-2.jpg" alt="Kurulum Görseli">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="gallery-section pt-60 wow fadeInUp">
    <div class="container-fluid">
        <div class="slider-active-4-item">
            <?php $galleryImages = ['gallery-1.jpg', 'gallery-2.jpg', 'gallery-3.jpg', 'gallery-4.jpg', 'gallery-2.jpg']; ?>
            <?php foreach ($galleryImages as $image): ?>
                <div class="single-portfolio-item">
                    <div class="img-holder">
                        <img src="web-assets/images/gallery/<?= esc($image) ?>" alt="Galeri Görseli">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section id="process" class="process-section pt-120">
    <div class="process-wrapper p-r z-1">
        <div class="shape line-shape wow fadeInUp">
            <span><img src="web-assets/images/shape/line.png" alt="Line Shape"></span>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="section-title text-center mb-65 wow fadeInDown">
                        <span class="sub-title">Peki Süreç Nasıl İşliyor?</span>
                        <h2>Gelin beraber bakalım</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                $steps = [
                    ['#E1EEDD', 'step1.png', 'icon-7.png', 'Paketinizi seçin', false],
                    ['#0F0F2D', 'step2.png', 'icon-8.png', 'Giriş yapın veya kayıt olun', true],
                    ['#FFB966', 'step3.png', 'icon-9.png', 'İşletme bilgilerinizi ekleyin', false],
                    ['#193B1E', 'step4.png', 'icon-10.png', 'Hizmet ve personel yapınızı kurun', true],
                ];
                foreach ($steps as [$bg, $step, $icon, $title, $white]):
                ?>
                    <div class="col-xl-3 col-md-6 col-sm-12">
                        <div class="single-process-item<?= $white ? ' text-white' : '' ?> mb-60 wow fadeInUp">
                            <div class="process-inner-content" style="background-color: <?= esc($bg) ?>;">
                                <div class="step"><img src="web-assets/images/shape/<?= esc($step) ?>" alt="Adım"></div>
                                <div class="icon"><img src="web-assets/images/icon/<?= esc($icon) ?>" alt="İkon"></div>
                                <div class="content">
                                    <h5><?= esc($title) ?></h5>
                                    <p>Kurulum sürecini birkaç adımda tamamlayıp yönetim paneline geçin.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<section class="faq-section pt-70 pb-100">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="faq-content-box pr-lg-70 mb-20 wow fadeInLeft">
                    <div class="section-title mb-40">
                        <span class="sub-title">Sık Sorulan Sorular</span>
                        <h2>Paket ve kurulum süreci hakkında merak ettikleriniz</h2>
                    </div>
                    <div class="accordion" id="accordionOne">
                        <?php
                        $faqItems = [
                            ['collapse0', 'Önce paket mi seçiyorum?', true],
                            ['collapse1', 'Paket seçtikten sonra ne oluyor?', false],
                            ['collapse2', 'Üyeliğim yoksa kayıt olabilir miyim?', false],
                            ['collapse3', 'İşletme bilgilerimi sonradan güncelleyebilir miyim?', false],
                        ];
                        foreach ($faqItems as $index => [$id, $question, $open]):
                        ?>
                            <div class="accordion-card mb-25">
                                <div class="accordion-header">
                                    <h6 class="accordion-title<?= $open ? '' : ' collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#<?= esc($id) ?>" aria-expanded="<?= $open ? 'true' : 'false' ?>">
                                        <span class="number"><?= esc(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)) ?>.</span><?= esc($question) ?>
                                    </h6>
                                </div>
                                <div id="<?= esc($id) ?>" class="accordion-collapse collapse<?= $open ? ' show' : '' ?>" data-bs-parent="#accordionOne">
                                    <div class="accordion-body">
                                        <p>Paket seçimi sonrası kullanıcı giriş yapar veya kayıt olur, ardından doğrudan işletme bilgilerini girerek kurulumuna devam eder.</p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="faq-image-box pl-lg-70 mb-50 wow fadeInRight">
                    <img src="web-assets/images/gallery/faq-1.jpg" alt="Sık Sorulan Sorular">
                </div>
            </div>
        </div>
    </div>
</section>

<!--=== Start Animate Headline ===-->
<div class="animate-headline">
    <div class="headline-text mb-90">
        <div class="animate-text">
            <span class="bgi">Akıllı Randevu Sistemi</span>
        </div>
    </div>
</div><!--=== End Animate Headline ===-->
