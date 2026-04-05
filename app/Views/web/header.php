<!DOCTYPE html>
<html lang="zxx">
<head>
    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="Insurance, Health, Agency">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= esc($pageTitle ?? 'Surancy - Insurance Agency HTML Template') ?></title>
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
                <a href="index.html"><img src="web-assets/images/logo/logo-black.png" alt="Logo"></a>
            </div>
            <div class="about-us">
                <h5 class="panel-widget-title">About Us</h5>
                <p>Ut enim ad minima veniam, quis nostrum aliquid commodie buy business insurance the set experience.</p>
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
    </div>
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
                                <li class="menu-item has-children"><a href="#">Home</a>
                                    <ul class="sub-menu">
                                        <li><a href="index.html">Home 01</a></li>
                                        <li><a href="index-2.html">Home 02</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children"><a href="#">Insurance</a>
                                    <ul class="sub-menu">
                                        <li><a href="services.html">Our Insurance</a></li>
                                        <li><a href="service-details.html">Insurance Details</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children"><a href="#">Portfolio</a>
                                    <ul class="sub-menu">
                                        <li><a href="portfolio.html">Our Portfolio</a></li>
                                        <li><a href="portfolio-details.html">Portfolio Details</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children"><a href="#">Blog</a>
                                    <ul class="sub-menu">
                                        <li><a href="blog-standard.html">Our Blog</a></li>
                                        <li><a href="blog-details.html">Blog Details</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children"><a href="#">Pages</a>
                                    <ul class="sub-menu">
                                        <li><a href="about.html">About Us</a></li>
                                        <li><a href="career.html">Career</a></li>
                                        <li><a href="job-details.html">Career Details</a></li>
                                        <li><a href="team.html">Our Team</a></li>
                                        <li><a href="team-details.html">Team Details</a></li>
                                        <li><a href="faq.html">Faq</a></li>
                                        <li><a href="contact.html">Contact</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                        <div class="menu-button mt-40 d-xl-none">
                            <a href="contact.html" class="main-btn secondary-btn">Get a Quote<i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="nav-right-item">
                        <div class="search-btn" data-bs-toggle="modal" data-bs-target="#search-modal"><i class="fas fa-search"></i></div>
                        <div class="menu-button d-xl-block d-none">
                            <a href="contact.html" class="main-btn primary-btn">Get a Quote<i class="fas fa-arrow-right"></i></a>
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
