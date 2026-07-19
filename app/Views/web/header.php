<!DOCTYPE html>
<html lang="zxx">

<head>
    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="Akıllı randevu yönetimi, işletme vitrini ve online rezervasyon sistemi">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= esc($pageTitle ?? 'Akıllı Randevu Yönetim Sistemi') ?></title>
    <base href="<?= rtrim(base_url(), '/') ?>/">
    <link rel="shortcut icon" href="web-assets/images/favicon.ico" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Syne:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="web-assets/fonts/flaticon/flaticon_ensuran.css">
    <link rel="stylesheet" href="web-assets/fonts/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="web-assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="web-assets/vendor/magnific-popup/dist/magnific-popup.css">
    <link rel="stylesheet" href="web-assets/vendor/slick/slick.css">
    <link rel="stylesheet" href="web-assets/vendor/nice-select/css/nice-select.css">
    <link rel="stylesheet" href="web-assets/vendor/animate.css">
    <link rel="stylesheet" href="web-assets/css/default.css">
    <link rel="stylesheet" href="web-assets/css/style.css">
</head>

<body>
    <div class="preloader">
        <div class="loader">
            <div class="pre-shadow"></div>
            <div class="pre-box"></div>
        </div>
    </div>
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
    </div>
    <div class="offcanvas-panel">
        <div class="panel-overlay"></div>
        <div class="offcanvas-panel-inner">
            <div class="panel-logo">
                <a href="<?= base_url('/') ?>"><img src="web-assets/images/logo/logo-black.png" alt="Logo"></a>
            </div>
            <div class="about-us">
                <h5 class="panel-widget-title">Randevu Sistemi</h5>
                <p>İşletmenizin online randevu, hizmet, personel ve web vitrini süreçlerini tek panelde yönetin.</p>
            </div>
            <div class="contact-us">
                <h5 class="panel-widget-title">Bize Ulaşın</h5>
                <form>
                    <div class="form_group">
                        <input type="text" class="form_control" placeholder="Adınız" name="name" required>
                    </div>
                    <div class="form_group">
                        <input type="email" class="form_control" placeholder="E-posta adresiniz" name="email" required>
                    </div>
                    <div class="form_group">
                        <textarea class="form_control" placeholder="Mesajınız" name="message" rows="3"></textarea>
                    </div>
                    <div class="form_group">
                        <button class="main-btn secondary-btn">Gönder</button>
                    </div>
                </form>
            </div>
            <a href="#" class="panel-close"><i class="fal fa-times"></i></a>
        </div>
    </div>
    <header class="header-area header-one">
        <div class="header-top-bar green-bg">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="top-left">
                            <span><i class="far fa-envelope"></i><a href="mailto:destek@randevusistemi.test">destek@randevusistemi.test</a></span>
                            <span><i class="far fa-phone"></i><a href="tel:+905551112233">+90 555 111 22 33</a></span>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="top-right">
                            <div class="lang-dropdown">
                                <select>
                                    <option value="tr">Türkçe</option>
                                    <option value="en">English</option>
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
                        <a href="<?= base_url('/') ?>" class="brand-logo"><img src="web-assets/images/logo/logo-black.png" alt="Logo"></a>
                    </div>
                    <div class="nav-menu">
                        <div class="mobile-logo mb-30 d-block d-xl-none">
                            <a href="<?= base_url('/') ?>" class="brand-logo"><img src="web-assets/images/logo/logo-black.png" alt="Site Logo"></a>
                        </div>
                        <div class="nav-search mb-30 d-block d-xl-none ">
                            <form>
                                <div class="form_group">
                                    <input type="search" class="form_control" placeholder="İşletme ara" name="search">
                                    <button class="search-btn"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <nav class="main-menu">
                            <ul>
                                <li><a href="<?= base_url('/') ?>">Ana Sayfa</a></li>
                                <li><a href="<?= base_url('businesses') ?>">İşletmeler</a></li>
                                <li><a href="<?= base_url('/#packages') ?>">Paketler</a></li>
                                <li><a href="<?= base_url('/#featured-businesses') ?>">Öne Çıkanlar</a></li>
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
                        <div class="search-btn" data-bs-toggle="modal" data-bs-target="#search-modal">
                            <i class="fas fa-search"></i>
                        </div>

                        <div class="menu-button d-xl-block d-none">
                            <a href="<?= base_url('login') ?>" class="main-btn secondary-btn">Giriş Yap</a>
                        </div>

                        <div class="menu-button d-xl-block d-none ms-2">
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
    <main>

