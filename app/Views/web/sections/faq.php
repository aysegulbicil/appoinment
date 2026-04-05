<section class="faq-section pt-70 pb-100">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="faq-content-box pr-lg-70 mb-20 wow fadeInLeft">
                    <div class="section-title mb-40">
                        <span class="sub-title">Faqs</span>
                        <h2>Learn About Our
                            Insurance Solution</h2>
                    </div>
                    <div class="accordion" id="accordionOne">
                        <?php
                        $faqItems = [
                            ['collapse0', 'How to Get Insurance Services?', true],
                            ['collapse1', 'Why Choose Our Products?', false],
                            ['collapse2', 'Learn Our Setting & Privacy ?', false],
                            ['collapse3', "We've Experience Team ?", false],
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
                                        <p>Quis autem vel eum iure reprehenderit quinea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariature minima veniam, quis nostrum exercitationem</p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="faq-image-box pl-lg-70 mb-50 wow fadeInRight">
                    <img src="web-assets/images/gallery/faq-1.jpg" alt="Faq Image">
                </div>
            </div>
        </div>
    </div>
</section>
<div class="animate-headline">
    <div class="headline-text mb-100">
        <div class="animate-text">
            <span class="bgi">Insurance Services</span>
        </div>
    </div>
</div>
