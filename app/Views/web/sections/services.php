<section class="services-section pt-120 pb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-center mb-50 wow fadeInDown">
                    <span class="sub-title">ÖNE ÇIKAN İŞLETMELER</span>
                    <h2>Randevu almak istediğiniz işletmeyi seçin ve başlayın.</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            $services = [
                ['icon-1.png', 'House Insurance'],
                ['icon-2.png', 'Car Insurance'],
                ['icon-3.png', 'Health Insurance'],
                ['icon-4.png', 'Travel Insurance'],
                ['icon-5.png', 'Business Insurance'],
                ['icon-6.png', 'Agri Insurance'],
            ];
            foreach ($services as [$icon, $title]):
            ?>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="single-service-item text-center mb-30 wow fadeInUp">
                        <div class="content">
                            <div class="icon">
                                <img src="web-assets/images/icon/<?= esc($icon) ?>" alt="Icon">
                            </div>
                            <h3 class="title"><a href="service-details.html"><?= esc($title) ?></a></h3>
                            <p>We denounce with righteous indignation
                                dislike beguiled and demoralized</p>
                        </div>
                        <div class="read-more">
                            <a href="service-details.html" class="btn-link">Read More <i class="far fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<div class="animate-headline">
    <div class="headline-text mb-100">
        <div class="animate-text">
            <span class="bgi">Akıllı Randevu Sistemi İle İşlerinizi Kolaylaştırın!W</span>
        </div>
    </div>
</div>
