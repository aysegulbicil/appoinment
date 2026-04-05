<section class="gallery-section pt-60 wow fadeInUp">
    <div class="container-fluid">
        <div class="slider-active-4-item">
            <?php $galleryImages = ['gallery-1.jpg', 'gallery-2.jpg', 'gallery-3.jpg', 'gallery-4.jpg', 'gallery-2.jpg']; ?>
            <?php foreach ($galleryImages as $image): ?>
                <div class="single-portfolio-item">
                    <div class="img-holder">
                        <img src="web-assets/images/gallery/<?= esc($image) ?>" alt="Gallery Image">
                        <div class="content-hover">
                            <div class="content">
                                <div class="inner-content">
                                    <a href="service-details.html" class="icon-btn"><i class="fal fa-arrow-right"></i></a>
                                    <h3 class="title"><a href="service-details.html">Life Insurance</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
