<section class="process-section pt-120">
    <div class="process-wrapper p-r z-1">
        <div class="shape line-shape wow fadeInUp">
            <span><img src="web-assets/images/shape/line.png" alt="Line Shape"></span>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="section-title text-center mb-65 wow fadeInDown">
                        <span class="sub-title">How to Get Load</span>
                        <h2>How To Get Online Insurance Loan</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                $steps = [
                    ['#E1EEDD', 'step1.png', 'icon-7.png', 'Download & complete Data', false],
                    ['#0F0F2D', 'step2.png', 'icon-8.png', 'Verification to get a Credit limit', true],
                    ['#FFB966', 'step3.png', 'icon-9.png', 'Select Truncations and funding', false],
                    ['#193B1E', 'step4.png', 'icon-10.png', 'Use Insurance anytime anywhere', true],
                ];
                foreach ($steps as [$bg, $step, $icon, $title, $white]):
                ?>
                    <div class="col-xl-3 col-md-6 col-sm-12">
                        <div class="single-process-item<?= $white ? ' text-white' : '' ?> mb-60 wow fadeInUp">
                            <div class="process-inner-content" style="background-color: <?= esc($bg) ?>;">
                                <div class="step"><img src="web-assets/images/shape/<?= esc($step) ?>" alt="Step"></div>
                                <div class="icon">
                                    <img src="web-assets/images/icon/<?= esc($icon) ?>" alt="icon">
                                </div>
                                <div class="content">
                                    <h5><?= esc($title) ?></h5>
                                    <p>Senounce with righteous indignation like men</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
