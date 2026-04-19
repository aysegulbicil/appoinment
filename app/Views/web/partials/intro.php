<!--====== Start Preloader ======-->
<div class="preloader">
    <div class="loader">
        <div class="pre-shadow"></div>
        <div class="pre-box"></div>
    </div>
</div><!--====== End Preloader ======-->
<!--====== Search From ======-->
<div class="modal fade search-modal" id="search-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form>
                <div class="form_group">
                    <input type="search" class="form_control" placeholder="Search here" name="search">
                    <label><i class="fa fa-search"></i></label>
                </div>
            </form>
        </div>
    </div>
</div><!--====== Search From ======-->
<!--====== offcanvas-panel ======-->
<div class="offcanvas-panel">
    <div class="panel-overlay"></div>
    <div class="offcanvas-panel-inner">
        <div class="panel-logo">
            <a href="index.html"><img src="web-assets/images/logo/logo-black.png" alt="Logo"></a>
        </div>
        <div class="about-us">
            <h5 class="panel-widget-title">About Us</h5>
            <p>
                Ut enim ad minima veniam, quis nostrum aliquid commodie buy business insurance the set experience.
            </p>
        </div>
        <div class="contact-us">
            <h5 class="panel-widget-title">Contact Us</h5>
            <form>
                <div class="form_group">
                    <input type="text" class="form_control" placeholder="Enter Name" name="name" required>
                </div>
                <div class="form_group">
                    <input type="email" class="form_control" placeholder="Enter Email" name="email" required>
                </div>
                <div class="form_group">
                    <textarea class="form_control" placeholder="Message" name="message" rows="3"></textarea>
                </div>
                <div class="form_group">
                    <button class="main-btn secondary-btn">Submit Now</button>
                </div>
            </form>
        </div>
        <a href="#" class="panel-close"><i class="fal fa-times"></i></a>
    </div>
</div><!--====== offcanvas-panel ======-->
<!--====== Start Hero Section ======-->
<header class="header-area header-one">
    <div class="header-top-bar green-bg">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-7">
                    <div class="top-left">
                        <span><i class="far fa-envelope"></i><a href="mailto:supportinsurance@gmail.com">supportinsurance@gmail.com</a></span>
                        <span><i class="far fa-phone"></i><a href="tel:+222(345)66688">+222 (345) 666 88</a></span>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="top-right">
                        <div class="lang-dropdown">
                            <select>
                                <option value="01">English</option>
                                <option value="02">French</option>
                            </select>
                        </div>
                        <ul class="social-link">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-navigation">
        <div class="nav-overlay"></div>
        <div class="container-fluid">
            <div class="primary-menu">
                <div class="site-branding">
                    <a href="index.html" class="brand-logo"><img src="web-assets/images/logo/logo-black.png" alt="Logo"></a>
                </div>
                <div class="nav-menu">
                    <div class="mobile-logo mb-30 d-block d-xl-none">
                        <a href="index.html" class="brand-logo"><img src="web-assets/images/logo/logo-black.png" alt="Site Logo"></a>
                    </div>
                    <div class="nav-search mb-30 d-block d-xl-none ">
                        <form>
                            <div class="form_group">
                                <input type="email" class="form_control" placeholder="Search Here" name="email" required>
                                <button class="search-btn"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <nav class="main-menu">
                        <ul>
                            <li><a href="<?= base_url('/') ?>">Ana Sayfa</a></li>
                            <li><a href="<?= base_url('businesses') ?>">İşletmeler</a></li>
                            <li><a href="<?= base_url('/#process') ?>">Nasıl Çalışır?</a></li>
                            <li><a href="<?= base_url('login') ?>">Giriş Yap</a></li>
                            <li><a href="<?= base_url('register') ?>">Kayıt Ol</a></li>
                        </ul>
                    </nav>
                    <div class="menu-button mt-40 d-xl-none">
                        <a href="<?= base_url('register') ?>" class="main-btn secondary-btn">Ücretsiz Başla<i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="nav-right-item">
                    <div class="search-btn" data-bs-toggle="modal" data-bs-target="#search-modal"><i class="fas fa-search"></i></div>
                    <div class="menu-button d-xl-block d-none">
                        <a href="<?= base_url('register') ?>" class="main-btn primary-btn">Ücretsiz Başla<i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="bar-item"><img src="web-assets/images/bar.png" alt="dot"></div>
                    <div class="navbar-toggler">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
