<!DOCTYPE html>
<html lang="zxx">
<head>
    <?= view('web/partials/head', ['pageTitle' => $pageTitle ?? 'Surancy - Insurance Agency HTML Template']) ?>
</head>
<body>
    <main>
        <?= $this->renderSection('content') ?>
    </main>
    <?= view('web/partials/footer') ?>
    <?= view('web/partials/scripts') ?>
</body>
</html>
