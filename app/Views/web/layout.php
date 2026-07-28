<!DOCTYPE html>
<html lang="tr">
<head>
    <?= view('web/partials/head', ['pageTitle' => $pageTitle ?? 'Randevu — İşletme Yönetimi']) ?>
</head>
<body class="public-site">
    <?= view('web/partials/site-header') ?>
    <main id="main-content">
        <?= $this->renderSection('content') ?>
    </main>
    <?= view('web/partials/site-footer') ?>
    <?= view('web/partials/scripts') ?>
</body>
</html>
