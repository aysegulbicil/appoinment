<section class="blog-section pt-120 pb-80">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="section-title mb-55 wow fadeInLeft">
                    <span class="sub-title">News & Blog</span>
                    <h2>Read Every Insurance
                        News & Blog</h2>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="blog-button float-lg-end mb-60 wow fadeInRight">
                    <a href="blog-standard.html" class="main-btn secondary-btn">View More News<i class="far fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <?php
            $blogs = [
                ['blog-1.jpg', 'Insurance covers risk of fire absence'],
                ['blog-2.jpg', 'Erving the interests Insurance clients'],
                ['blog-3.jpg', 'Insurance covers risk of fire absence'],
            ];
            foreach ($blogs as [$image, $title]):
            ?>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="single-blog-post mb-40 wow fadeInUp">
                        <div class="post-thumbnail">
                            <img src="web-assets/images/blog/<?= esc($image) ?>" alt="Blog Image">
                        </div>
                        <div class="entry-content">
                            <div class="post-meta">
                                <span><i class="far fa-calendar-alt"></i>March 23, 2023</span>
                                <span><a href="#">Insurance</a></span>
                            </div>
                            <h3 class="title"><a href="blog-details.html"><?= esc($title) ?></a></h3>
                            <a href="blog-details.html" class="btn-link">Learn More<i class="far fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
