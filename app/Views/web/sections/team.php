<section class="team-section team_area-one green-bg pt-120 p-r z-1">
    <div class="shape shape-one"><span><img src="web-assets/images/shape/frame1.png" alt="Frame Shape"></span></div>
    <div class="shape shape-two"><span><img src="web-assets/images/shape/frame2.png" alt="Frame Shape"></span></div>
    <div class="container-fluid">
        <div class="team-wrapper">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="section-title text-white mb-55 wow fadeInLeft">
                            <span class="sub-title">Exclusive Team</span>
                            <h2>Meet Our Professional
                                Team Members</h2>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="team-button float-lg-end mb-55 wow fadeInRight">
                            <a href="team.html" class="main-btn secondary-btn">Become a Member<i class="far fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php
                    $team = [
                        ['team-1.jpg', 'Keith N. McSwain', 'CEO & Founder'],
                        ['team-2.jpg', 'Nathaniel R. Smith', 'Marketing Developer'],
                        ['team-3.jpg', 'Shawn D. Keeling', 'Senior Manager'],
                        ['team-4.jpg', 'Keith N. McSwain', 'Junior Consultant'],
                    ];
                    foreach ($team as [$image, $name, $role]):
                    ?>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="single-team-item mb-40 wow fadeInUp">
                                <div class="member-img">
                                    <img src="web-assets/images/team/<?= esc($image) ?>" alt="Member Image">
                                    <div class="hover-content">
                                        <div class="social-box">
                                            <ul class="social-link">
                                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                                <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="member-info">
                                    <h3 class="title"><a href="team-details.html"><?= esc($name) ?></a></h3>
                                    <p class="position"><?= esc($role) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
