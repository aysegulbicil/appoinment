<?php $errors = session('errors') ?? []; ?>
<!DOCTYPE html>
<html lang="tr" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title><?= esc($pageTitle ?? 'Kayit Ol') ?></title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body class="h-100">
    <div class="login-account">
        <div class="row h-100">
            <div class="col-lg-6 align-self-start">
                <div class="account-info-area" style="background-image: url('<?= base_url('assets/images/rainbow.gif') ?>')">
                    <div class="login-content">
                        <p class="sub-title">Kurumsal hesabinizi olusturup yonetim paneline erisin</p>
                        <h1 class="title">Smart <span>Appointment</span></h1>
                        <p class="text">Musteri, randevu ve operasyon sureclerini tek ekrandan yonetin.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-8 col-sm-12 mx-auto align-self-center">
                <div class="login-form">
                    <div class="login-head">
                        <h3 class="title">Yeni Hesap Olustur</h3>
                        <p>Bilgilerinizi girin, hesabiniz hemen olussun.</p>
                    </div>
                    <h6 class="login-title"><span>Kayit Ol</span></h6>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger solid alert-dismissible fade show">
                            <?= esc(session()->getFlashdata('error')) ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('register/process') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-4">
                            <label class="mb-1 text-dark" for="full_name">Ad Soyad</label>
                            <input
                                id="full_name"
                                name="full_name"
                                type="text"
                                class="form-control form-control-lg<?= isset($errors['full_name']) ? ' is-invalid' : '' ?>"
                                value="<?= esc(old('full_name')) ?>"
                                placeholder="Ad Soyad"
                            >
                            <?php if (isset($errors['full_name'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['full_name']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1 text-dark" for="email">E-posta</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                class="form-control form-control-lg<?= isset($errors['email']) ? ' is-invalid' : '' ?>"
                                value="<?= esc(old('email')) ?>"
                                placeholder="ornek@mail.com"
                            >
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['email']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1 text-dark" for="phone">Telefon Numarasi</label>
                            <input
                                id="phone"
                                name="phone"
                                type="text"
                                class="form-control form-control-lg<?= isset($errors['phone']) ? ' is-invalid' : '' ?>"
                                value="<?= esc(old('phone')) ?>"
                                placeholder="05xx xxx xx xx"
                            >
                            <?php if (isset($errors['phone'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['phone']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1 text-dark" for="company_name">Kurum Adi</label>
                            <input
                                id="company_name"
                                name="company_name"
                                type="text"
                                class="form-control form-control-lg<?= isset($errors['company_name']) ? ' is-invalid' : '' ?>"
                                value="<?= esc(old('company_name')) ?>"
                                placeholder="Opsiyonel"
                            >
                            <?php if (isset($errors['company_name'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['company_name']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1 text-dark" for="password">Sifre</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="form-control form-control-lg<?= isset($errors['password']) ? ' is-invalid' : '' ?>"
                                placeholder="Sifreniz"
                            >
                            <?php if (isset($errors['password'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['password']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1 text-dark" for="password_confirm">Sifre Tekrar</label>
                            <input
                                id="password_confirm"
                                name="password_confirm"
                                type="password"
                                class="form-control form-control-lg<?= isset($errors['password_confirm']) ? ' is-invalid' : '' ?>"
                                placeholder="Sifrenizi tekrar girin"
                            >
                            <?php if (isset($errors['password_confirm'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['password_confirm']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="text-center mb-4">
                            <button type="submit" class="btn btn-primary btn-block">Kayit Ol</button>
                        </div>

                        <p class="text-center mb-0">
                            Zaten hesabiniz var mi?
                            <a class="btn-link text-primary" href="<?= base_url('login') ?>">Giris Yap</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/vendor/global/global.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/custom.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/deznav-init.js') ?>"></script>
</body>
</html>
