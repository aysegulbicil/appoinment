<section class="features-section pt-130 mb-50">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-6">
                <div class="features-one_content-box mb-50 wow fadeInLeft">
                    <div class="section-title mb-35">
                        <span class="sub-title">Consultations</span>
                        <h2>Learn Insurance
                        Solution With Our
                        Professionals</h2>
                    </div>
                    <p class="para">At vero eos et accusamus et iusto odio dignissimos ducimus blanditiis praesentium voluptatum deleniti atque</p>
                    <a href="about.html" class="main-btn filled-btn">Learn More<i class="far fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="row">
                    <?php
                    $features = [
                        'Knowledgeable Consulting',
                        'Best Rates and Converge',
                        'Well Known Reputations',
                        'Professional & Exclusive Team',
                    ];
                    foreach ($features as $feature):
                    ?>
                        <div class="col-md-6">
                            <div class="single-features-item mb-50 wow fadeInUp">
                                <div class="content">
                                    <div class="hover-bg bg_cover" style="background-image: url(web-assets/images/bg/hover-bg.jpg);"></div>
                                    <div class="icon">
                                        <img src="web-assets/images/icon/check.png" alt="check">
                                    </div>
                                    <h4 class="title"><?= esc($feature) ?></h4>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="animate-headline">
    <div class="headline-text">
        <div class="animate-text">
            <span class="bgi">Look Gallery Insight</span>
        </div>
    </div>
</div>
