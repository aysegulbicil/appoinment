<?php $pages = $pages ?? []; ?>
<div class="content-body">
    <div class="container-fluid">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success solid"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-body d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <h3 class="mb-2"><?= esc($business['name'] ?? '-') ?> - Sayfalar</h3>
                    <p class="text-muted mb-0">Aktif sayfaları yönet, sırala ve menü görünürlüğünü ayarla.</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-pages/create') ?>" class="btn btn-primary">Yeni Sayfa</a>
                    <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-settings/general') ?>" class="btn btn-light border">Genel Ayarlar</a>
                </div>
            </div>
        </div>

        <form action="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-pages/reorder') ?>" method="post">
            <?= csrf_field() ?>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Sıra</th>
                                    <th>Başlık</th>
                                    <th>Tip</th>
                                    <th>Slug</th>
                                    <th>Menü</th>
                                    <th>Durum</th>
                                    <th class="text-end">İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($pages === []): ?>
                                    <tr><td colspan="7" class="text-muted">Henüz sayfa eklenmemiş.</td></tr>
                                <?php endif; ?>
                                <?php foreach ($pages as $index => $page): ?>
                                    <tr>
                                        <td style="width: 120px;">
                                            <input type="hidden" name="page_ids[]" value="<?= esc($page['id']) ?>">
                                            <input type="number" name="sort_orders[]" class="form-control form-control-sm" value="<?= esc($page['sort_order'] ?? ($index + 1)) ?>">
                                        </td>
                                        <td>
                                            <strong><?= esc($page['title']) ?></strong><br>
                                            <small class="text-muted"><?= esc($page['short_intro'] ?: '-') ?></small>
                                        </td>
                                        <td><?= esc($page['page_type']) ?></td>
                                        <td><?= esc($page['slug']) ?></td>
                                        <td>
                                            <span class="badge badge-<?= ($page['is_visible_in_menu'] ?? 1) ? 'success' : 'secondary' ?> light">
                                                <?= ($page['is_visible_in_menu'] ?? 1) ? 'Görünür' : 'Gizli' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?= ($page['is_active'] ?? 1) ? 'success' : 'secondary' ?> light">
                                                <?= ($page['is_active'] ?? 1) ? 'Aktif' : 'Pasif' ?>
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2 flex-wrap">
                                                <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-pages/' . $page['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">Düzenle</a>
                                                <button type="submit" class="btn btn-sm btn-outline-secondary" formaction="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-pages/' . $page['id'] . '/toggle-status') ?>" formmethod="post">Aktif/Pasif</button>
                                                <button type="submit" class="btn btn-sm btn-outline-secondary" formaction="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-pages/' . $page['id'] . '/toggle-menu') ?>" formmethod="post">Menü</button>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" formaction="<?= base_url('dashboard/businesses/' . $business['id'] . '/web-pages/' . $page['id'] . '/delete') ?>" formmethod="post" onclick="return confirm('Bu sayfa silinsin mi?');">Sil</button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Sırayı Kaydet</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
