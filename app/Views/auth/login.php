<?php $errors = session('errors') ?? []; ?>
<!DOCTYPE html>
<html lang="tr" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title><?= esc($pageTitle ?? 'Giris Yap') ?></title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body class="h-100">
    <div class="login-account">
        <div class="row h-100">
            <div class="col-lg-6 align-self-start">
                <div class="account-info-area" style="background-image: url('<?= base_url('assets/images/rainbow.gif') ?>')">
                    <div class="login-content">
                        <p class="sub-title">Yonetime erismek icin hesabinizla giris yapin</p>
                        <h1 class="title">Smart <span>Appointment</span></h1>
                        <p class="text">Randevu, musteri ve operasyon akisini tek panelden yonetin.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-7 col-sm-12 mx-auto align-self-center">
                <div class="login-form">
                    <div class="login-head">
                        <h3 class="title">Hos Geldiniz</h3>
                        <p>Devam etmek icin e-posta ve sifrenizle giris yapin.</p>
                    </div>
                    <h6 class="login-title"><span>Giris Yap</span></h6>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger solid alert-dismissible fade show">
                            <?= esc(session()->getFlashdata('error')) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success solid alert-dismissible fade show">
                            <?= esc(session()->getFlashdata('success')) ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('login/process') ?>" method="post">
                        <?= csrf_field() ?>
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

                        <div class="text-center mb-4">
                            <button type="submit" class="btn btn-primary btn-block">Giris Yap</button>
                        </div>

                        <p class="text-center mb-0 text-muted">
                            Varsayilan test kullanicisi: <strong>admin@appoinment.local</strong>
                        </p>
                        <p class="text-center text-muted">
                            Varsayilan sifre: <strong>Admin123!</strong>
                        </p>
                        <p class="text-center mb-0">
                            Hesabiniz yok mu?
                            <a class="btn-link text-primary" href="<?= base_url('register') ?>">Kayit Ol</a>
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
