<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title><?= esc($pageTitle ?? 'Panel') ?> | Smart Appointment</title>
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
    <?php if (! empty($pageStyles ?? '')): ?><?= $pageStyles ?><?php endif; ?>
    <link href="<?= base_url('assets/css/panel-premium.css') ?>?v=1" rel="stylesheet">
</head>
<body class="sa-panel">
<a href="#panel-content" class="sa-skip">İçeriğe geç</a>
<div id="main-wrapper" class="show">
    <header class="sa-topbar">
        <button type="button" class="sa-icon-button sa-menu-toggle" aria-label="Menüyü aç" aria-controls="panel-sidebar" aria-expanded="false" title="Menüyü aç"><i class="fa fa-bars" aria-hidden="true"></i></button>
        <div class="sa-business-switch">
            <i class="fa fa-building" aria-hidden="true"></i>
            <div>
                <label for="panel-business">İşletme</label>
                <select id="panel-business" aria-label="Aktif işletme"<?= $panelBusinesses === [] ? ' disabled' : '' ?>>
                    <?php if ($panelBusiness !== null && in_array($panelPath, ['dashboard/appointments', 'appointments'], true)): ?><option value="<?= base_url('dashboard/appointments') ?>">Tüm işletmeler</option><?php endif; ?>
                    <?php if ($panelBusiness === null): ?><option value=""><?= $panelBusinesses === [] ? 'Henüz işletme yok' : 'Tüm işletmeler' ?></option><?php endif; ?>
                    <?php foreach ($panelBusinesses as $item): ?>
                        <option value="<?= esc(base_url($panelSwitchPaths[$item['id']])) ?>" <?= (int) ($panelBusiness['id'] ?? 0) === (int) $item['id'] ? 'selected' : '' ?>><?= esc($item['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="sa-topbar-actions">
            <?php if (! empty($panelBusiness['slug']) && ($panelBusiness['status'] ?? '') === 'active'): ?>
                <a class="sa-web-link" href="<?= base_url('businesses/' . $panelBusiness['slug']) ?>" target="_blank" rel="noopener"><i class="fa fa-external-link" aria-hidden="true"></i><span>Web sitesini aç</span></a>
            <?php endif; ?>
            <details class="sa-account">
                <summary aria-label="Hesap menüsü" title="Hesap menüsü"><span class="sa-avatar"><?= esc(mb_strtoupper(mb_substr((string) (session('userName') ?: 'P'), 0, 1))) ?></span><span class="sa-account-name"><?= esc(session('userName') ?: 'Hesabım') ?></span><i class="fa fa-angle-down" aria-hidden="true"></i></summary>
                <div class="sa-account-menu">
                    <strong><?= esc(session('userName') ?: 'Hesabım') ?></strong>
                    <small><?= esc(session('userEmail') ?: '') ?></small>
                    <a href="<?= base_url('dashboard/settings') ?>"><i class="fa fa-cog" aria-hidden="true"></i> Hesap ayarları</a>
                    <a href="<?= base_url('logout') ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Çıkış yap</a>
                </div>
            </details>
        </div>
    </header>
