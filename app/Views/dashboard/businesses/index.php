<?php
$selectedPackage = $selectedPackage ?? null;
$businesses = $businesses ?? [];
$avatarImages = [
    'assets/images/profile/small/pic1.jpg',
    'assets/images/profile/small/pic2.jpg',
    'assets/images/profile/small/pic3.jpg',
    'assets/images/profile/small/pic4.jpg',
    'assets/images/profile/small/pic5.jpg',
    'assets/images/profile/small/pic6.jpg',
    'assets/images/profile/small/pic7.jpg',
    'assets/images/profile/small/pic8.jpg',
];
?>

<div class="content-body">
    <div class="container-fluid">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success solid"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Staff</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example5" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Joining Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($businesses === []): ?>
                                        <tr>
                                            <td></td>
                                            <td>Henuz isletme yok</td>
                                            <td>-</td>
                                            <td><a href="javascript:void(0);"><strong>-</strong></a></td>
                                            <td><a href="javascript:void(0);"><strong>-</strong></a></td>
                                            <td>Ilk isletmenizi ekleyin</td>
                                            <td>-</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="<?= base_url('dashboard/businesses/create') ?>" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fa fa-plus"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($businesses as $index => $business): ?>
                                            <tr>
                                                <td><?= esc($business['name']) ?></td>
                                                <td><?= esc($business['category'] ?: '-') ?></td>
                                                <td><a href="javascript:void(0);"><strong><?= esc($business['phone'] ?: '-') ?></strong></a></td>
                                                <td><a href="javascript:void(0);"><strong><?= esc($business['email'] ?: '-') ?></strong></a></td>
                                                <td><?= esc(trim(($business['city'] ?? '') . ' / ' . ($business['district'] ?? ''), ' /') ?: '-') ?></td>
                                                <td><?= ! empty($business['created_at']) ? esc(date('Y/m/d', strtotime((string) $business['created_at']))) : '-' ?></td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="<?= base_url('dashboard/businesses/' . $business['id'] . '?tab=general') ?>" class="btn btn-primary shadow btn-xs sharp me-1" title="Duzenle"><i class="fa fa-pencil"></i></a>
                                                        <form action="<?= base_url('dashboard/businesses/' . $business['id'] . '/toggle-status') ?>" method="post" class="me-1">
                                                            <?= csrf_field() ?>
                                                            <button type="submit" class="btn btn-warning shadow btn-xs sharp" title="<?= ($business['status'] ?? 'active') === 'active' ? 'Pasif Yap' : 'Aktif Yap' ?>">
                                                                <i class="fa fa-power-off"></i>
                                                            </button>
                                                        </form>
                                                        <a href="<?= base_url('dashboard/businesses/' . $business['id']) ?>" class="btn btn-info shadow btn-xs sharp" title="Detay"><i class="fa fa-eye"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (! empty($selectedPackage)): ?>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-3">Seçili Paket</h4>
                            <span class="badge badge-primary light mb-3"><?= esc($selectedPackage['badge']) ?></span>
                            <h5 class="mb-2"><?= esc($selectedPackage['name']) ?></h5>
                            <p class="text-muted mb-0"><?= esc($selectedPackage['description']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
