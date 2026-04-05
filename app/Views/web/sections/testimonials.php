<section class="testimonial-section pt-120 blue-bg pb-130">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-center text-white mb-70 wow fadeInDown">
                    <span class="sub-title">Clients Testimonials</span>
                    <h2>Clients Say About Insurance
                    Services & Our Team</h2>
                </div>
            </div>
        </div>
        <div class="testimonial-slider-one wow fadeInUp">
            <?php for ($i = 1; $i <= 3; $i++): ?>
                <div class="single-testimonial-item text-white">
                    <div class="testimonial-inner-content">
                        <div class="author-thumb">
                            <img src="web-assets/images/testimonial/author-<?= $i ?>.jpg" alt="Author Image">
                        </div>
                        <div class="testimonial-content">
                            <p>At veroeos accusamus eustodio digncsimos ducmue blanditiis praese voluptatum deleniti atque corre.</p>
                            <div class="quote-title-box">
                                <div class="quote">
                                    <img src="web-assets/images/icon/quote.png" alt="quote">
                                </div>
                                <div class="author-title">
                                    <h4>Joseph B. Renn</h4>
                                    <p class="position">CEO & Founder</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>
