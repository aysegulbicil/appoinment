<?php
$errors = session('errors') ?? [];
$selectedPackage = $selectedPackage ?? null;
$businesses = $businesses ?? [];
$showBusinessForm = $businesses === [] || $errors !== [];
?>
<div class="content-body">
    <div class="container-fluid">
        <?php if (($sectionKey ?? '') === 'business'): ?>
            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-3">Seçili Paket</h4>
                            <?php if ($selectedPackage): ?>
                                <span class="badge badge-primary light mb-3"><?= esc($selectedPackage['badge']) ?></span>
                                <h5 class="mb-2"><?= esc($selectedPackage['name']) ?></h5>
                                <p class="text-muted mb-3"><?= esc($selectedPackage['description']) ?></p>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($selectedPackage['features'] as $feature): ?>
                                        <li class="list-group-item px-0"><?= esc($feature) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success solid">
                            <?= esc(session()->getFlashdata('success')) ?>
                        </div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h4 class="card-title mb-0">İşletmelerim</h4>
                            <button
                                class="btn btn-primary"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#business-form-wrapper"
                                aria-expanded="<?= $showBusinessForm ? 'true' : 'false' ?>"
                                aria-controls="business-form-wrapper"
                            >
                                İşletme Ekle
                            </button>
                        </div>
                        <div class="card-body">
                            <?php if ($businesses === []): ?>
                                <p class="mb-0 text-muted">Henüz kayıtlı işletme yok. İlk işletmenizi eklemek için İşletme Ekle butonunu kullanın.</p>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-responsive-md">
                                        <thead>
                                            <tr>
                                                <th>İşletme</th>
                                                <th>Paket</th>
                                                <th>Şehir</th>
                                                <th>Durum</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($businesses as $business): ?>
                                                <tr>
                                                    <td>
                                                        <strong><?= esc($business['name']) ?></strong><br>
                                                        <small class="text-muted"><?= esc($business['phone'] ?: '-') ?></small>
                                                    </td>
                                                    <td><?= esc(strtoupper((string) ($business['package_code'] ?? '-'))) ?></td>
                                                    <td><?= esc(trim(($business['city'] ?? '') . ' ' . ($business['district'] ?? '')) ?: '-') ?></td>
                                                    <td><span class="badge badge-success light">Aktif</span></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div id="business-form-wrapper" class="collapse<?= $showBusinessForm ? ' show' : '' ?>">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">İşletme Bilgileri</h4>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('business/save') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="name">İşletme Adı</label>
                                            <input id="name" name="name" type="text" class="form-control<?= isset($errors['name']) ? ' is-invalid' : '' ?>" value="<?= esc(old('name')) ?>" placeholder="Örnek Güzellik Merkezi">
                                            <?php if (isset($errors['name'])): ?>
                                                <div class="invalid-feedback"><?= esc($errors['name']) ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="phone">Telefon</label>
                                            <input id="phone" name="phone" type="text" class="form-control<?= isset($errors['phone']) ? ' is-invalid' : '' ?>" value="<?= esc(old('phone')) ?>" placeholder="05xx xxx xx xx">
                                            <?php if (isset($errors['phone'])): ?>
                                                <div class="invalid-feedback"><?= esc($errors['phone']) ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="email">E-posta</label>
                                            <input id="email" name="email" type="email" class="form-control<?= isset($errors['email']) ? ' is-invalid' : '' ?>" value="<?= esc(old('email')) ?>" placeholder="isletme@mail.com">
                                            <?php if (isset($errors['email'])): ?>
                                                <div class="invalid-feedback"><?= esc($errors['email']) ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label" for="city">Şehir</label>
                                            <input id="city" name="city" type="text" class="form-control<?= isset($errors['city']) ? ' is-invalid' : '' ?>" value="<?= esc(old('city')) ?>" placeholder="İstanbul">
                                            <?php if (isset($errors['city'])): ?>
                                                <div class="invalid-feedback"><?= esc($errors['city']) ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label" for="district">İlçe</label>
                                            <input id="district" name="district" type="text" class="form-control<?= isset($errors['district']) ? ' is-invalid' : '' ?>" value="<?= esc(old('district')) ?>" placeholder="Kadıköy">
                                            <?php if (isset($errors['district'])): ?>
                                                <div class="invalid-feedback"><?= esc($errors['district']) ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label" for="address">Adres</label>
                                            <textarea id="address" name="address" class="form-control<?= isset($errors['address']) ? ' is-invalid' : '' ?>" rows="3" placeholder="Açık adresinizi girin"><?= esc(old('address')) ?></textarea>
                                            <?php if (isset($errors['address'])): ?>
                                                <div class="invalid-feedback"><?= esc($errors['address']) ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-12 mb-4">
                                            <label class="form-label" for="notes">Notlar</label>
                                            <textarea id="notes" name="notes" class="form-control<?= isset($errors['notes']) ? ' is-invalid' : '' ?>" rows="3" placeholder="Şube, kategori veya iç operasyon notları"><?= esc(old('notes')) ?></textarea>
                                            <?php if (isset($errors['notes'])): ?>
                                                <div class="invalid-feedback"><?= esc($errors['notes']) ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <button type="submit" class="btn btn-primary">İşletmeyi Kaydet</button>
                                        <button
                                            class="btn btn-light border"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#business-form-wrapper"
                                            aria-expanded="<?= $showBusinessForm ? 'true' : 'false' ?>"
                                            aria-controls="business-form-wrapper"
                                        >
                                            Vazgeç
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body py-5">
                            <h3 class="mb-3"><?= esc($pageTitle) ?></h3>
                            <p class="mb-0 text-muted">
                                Bu alan menüde hazır. İçeriği bir sonraki aşamada doldurulacak.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>