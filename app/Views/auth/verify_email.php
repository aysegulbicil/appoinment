<?php
$errors = session('errors') ?? [];
$email = $email ?? session('pendingVerificationEmail') ?? '';
?>
<!DOCTYPE html>
<html lang="tr" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title><?= esc($pageTitle ?? 'E-posta Doğrulama') ?></title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body class="h-100">
    <div class="login-account">
        <div class="row h-100">
            <div class="col-lg-6 align-self-start">
                <div class="account-info-area" style="background-image: url('<?= base_url('assets/images/rainbow.gif') ?>')">
                    <div class="login-content">
                        <p class="sub-title">Hesabınızı güvenle aktifleştirin</p>
                        <h1 class="title">Smart <span>Appointment</span></h1>
                        <p class="text">E-posta doğrulamasından sonra yönetim paneline geçebilirsiniz.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-7 col-sm-12 mx-auto align-self-center">
                <div class="login-form">
                    <div class="login-head">
                        <h3 class="title">E-posta Doğrulama</h3>
                        <p><?= esc($email) ?> adresine gönderilen 6 haneli kodu girin.</p>
                    </div>
                    <h6 class="login-title"><span>Doğrulama Kodu</span></h6>

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

                    <form action="<?= base_url('verify-email/process') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="email" value="<?= esc($email) ?>">

                        <div class="mb-4">
                            <label class="mb-1 text-dark" for="code">Kod</label>
                            <input
                                id="code"
                                name="code"
                                type="text"
                                inputmode="numeric"
                                maxlength="6"
                                class="form-control form-control-lg<?= isset($errors['code']) ? ' is-invalid' : '' ?>"
                                value="<?= esc(old('code')) ?>"
                                placeholder="123456"
                            >
                            <?php if (isset($errors['code'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['code']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="text-center mb-4">
                            <button type="submit" class="btn btn-primary btn-block">Hesabı Doğrula</button>
                        </div>
                    </form>

                    <form action="<?= base_url('verify-email/resend') ?>" method="post" class="text-center">
                        <?= csrf_field() ?>
                        <input type="hidden" name="email" value="<?= esc($email) ?>">
                        <button type="submit" class="btn btn-link text-primary">Kodu tekrar gönder</button>
                    </form>

                    <p class="text-center mb-0 mt-3">
                        <a class="btn-link text-primary" href="<?= base_url('login') ?>">Giriş sayfasına dön</a>
                    </p>
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
