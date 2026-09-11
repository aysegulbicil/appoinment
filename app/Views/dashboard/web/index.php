<?php
$businesses = $businesses ?? [];
$section = (string) service('request')->getGet('section');
$sections = ['pages' => 'Sayfalar', 'general' => 'Görünüm', 'menu' => 'Menü', 'seo' => 'SEO'];
$section = array_key_exists($section, $sections) ? $section : 'pages';
?>
<div class="content-body">
    <div class="container-fluid">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success solid"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <div class="sa-page-heading">
            <h1><?= esc($sections[$section]) ?></h1>
            <a href="<?= base_url('dashboard/businesses/create') ?>" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> İşletme ekle</a>
        </div>
        <?php if ($businesses === []): ?>
            <div class="sa-empty"><i class="fa fa-globe" aria-hidden="true"></i><h2>Henüz işletme eklenmedi</h2><a class="btn btn-primary" href="<?= base_url('dashboard/businesses/create') ?>"><i class="fa fa-plus" aria-hidden="true"></i> İşletme ekle</a></div>
        <?php endif; ?>
        <div class="row">
            <?php foreach ($businesses as $business): ?>
                <div class="col-lg-6 mb-4">
                    <div class="card sa-business-item h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                                <div>
                                    <h4 class="mb-1"><?= esc($business['name']) ?></h4>
                                    <p class="text-muted mb-0"><?= esc($business['category'] ?? '-') ?> · <?= esc($business['city'] ?? '-') ?></p>
                                </div>
                                <span class="badge badge-<?= ($business['status'] ?? 'active') === 'active' ? 'success' : 'secondary' ?> light">
                                    <?= ($business['status'] ?? 'active') === 'active' ? 'Aktif' : 'Pasif' ?>
                                </span>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mt-4">
                                <a class="btn btn-outline-primary" href="<?= base_url('dashboard/businesses/' . $business['id'] . ($section === 'pages' ? '/web-pages' : '/web-settings/' . $section)) ?>"><?= esc($sections[$section]) ?> <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
