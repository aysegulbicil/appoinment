<?php $businesses = $businesses ?? []; ?>
<div class="content-body">
    <div class="container-fluid">
        <?php foreach (['success' => 'success', 'error' => 'danger'] as $key => $style): ?>
            <?php if (session()->getFlashdata($key)): ?><div role="status" class="alert alert-<?= $style ?> solid"><?= esc(session()->getFlashdata($key)) ?></div><?php endif; ?>
        <?php endforeach; ?>
        <div class="sa-page-heading">
            <h1>İşletmelerim <span class="sa-heading-count"><?= count($businesses) ?> işletme</span></h1>
            <a href="<?= base_url('dashboard/businesses/create') ?>" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> İşletme ekle</a>
        </div>
        <?php if ($businesses === []): ?>
            <div class="sa-empty">
                <i class="fa fa-building" aria-hidden="true"></i>
                <h2>Henüz işletme eklenmedi</h2>
                <p>İlk işletmenizle başlayın.</p>
                <a href="<?= base_url('dashboard/businesses/create') ?>" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> İşletme ekle</a>
            </div>
        <?php else: ?>
            <section data-list-filter aria-label="İşletme listesi">
                <div class="sa-list-toolbar">
                    <label class="sa-search"><i class="fa fa-search" aria-hidden="true"></i><input type="search" class="form-control" data-search aria-label="İşletmelerde ara" placeholder="İşletme, şehir veya e-posta ara"></label>
                    <select class="form-control sa-status-filter" data-status-filter aria-label="İşletme durumu"><option value="">Tüm durumlar</option><option value="active">Aktif</option><option value="passive">Pasif</option></select>
                    <span class="sa-result-summary" aria-live="polite"><span data-result-count><?= count($businesses) ?></span> işletme</span>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead><tr><th>İşletme</th><th>İletişim</th><th>Konum</th><th>Durum</th><th>Kayıt tarihi</th><th class="text-end">İşlemler</th></tr></thead>
                        <tbody>
                            <?php foreach ($businesses as $business): ?>
                                <?php $active = ($business['status'] ?? 'active') === 'active'; ?>
                                <tr data-filter-row data-status="<?= $active ? 'active' : 'passive' ?>">
                                    <td><div class="sa-business-cell"><span class="sa-business-initial"><?= esc(mb_strtoupper(mb_substr($business['name'], 0, 1))) ?></span><div><a class="sa-business-name" href="<?= base_url('dashboard/businesses/' . $business['id']) ?>"><?= esc($business['name']) ?></a><small><?= esc($business['category'] ?: '-') ?></small></div></div></td>
                                    <td><div><?= esc($business['phone'] ?: '-') ?></div><small class="text-muted"><?= esc($business['email'] ?: '-') ?></small></td>
                                    <td><?= esc(trim(($business['city'] ?? '') . ' / ' . ($business['district'] ?? ''), ' /') ?: '-') ?></td>
                                    <td><span class="badge badge-<?= $active ? 'success' : 'secondary' ?> light"><?= $active ? 'Aktif' : 'Pasif' ?></span></td>
                                    <td><?= ! empty($business['created_at']) ? esc(date('d.m.Y', strtotime($business['created_at']))) : '-' ?></td>
                                    <td><div class="sa-row-actions">
                                        <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '?tab=general') ?>" class="sa-icon-button" title="İşletmeyi düzenle" aria-label="<?= esc($business['name']) ?>: düzenle"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-pages') ?>" class="sa-icon-button" title="Web sayfaları" aria-label="<?= esc($business['name']) ?>: web sayfaları"><i class="fa fa-globe" aria-hidden="true"></i></a>
                                        <form action="<?= base_url('dashboard/businesses/' . $business['id'] . '/toggle-status') ?>" method="post">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="sa-icon-button" title="<?= $active ? 'Pasif yap' : 'Aktif yap' ?>" aria-label="<?= esc($business['name']) ?>: <?= $active ? 'pasif yap' : 'aktif yap' ?>"><i class="fa fa-power-off" aria-hidden="true"></i></button>
                                        </form>
                                    </div></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="sa-empty-small" data-no-results hidden><p>Aramanıza uygun işletme bulunamadı.</p><button type="button" class="btn btn-light" data-reset-filter>Filtreleri temizle</button></div>
            </section>
        <?php endif; ?>
    </div>
</div>
