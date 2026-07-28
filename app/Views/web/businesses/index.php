<?= $this->extend('web/layout') ?>

<?= $this->section('content') ?>
<section class="directory-hero">
    <div class="site-container">
        <span class="eyebrow">Randevu noktaları</span>
        <h1>İşletmeler</h1>
        <p>Hizmetini seçin, işletmenin uygun saatlerini görün ve online randevunuzu oluşturun.</p>
    </div>
</section>

<section class="directory-section">
    <div class="site-container">
        <?php
        $visibleBusinesses = array_values(array_filter($businesses ?? [], static function (array $business): bool {
            return trim((string) ($business['intro_image'] ?: $business['cover_image'])) !== '';
        }));
        ?>
        <?php if ($visibleBusinesses === []): ?>
            <div class="directory-empty">
                <span class="directory-empty__icon" aria-hidden="true"><i class="far fa-store"></i></span>
                <h2>Henüz yayında bir işletme yok</h2>
                <p>Randevu almaya açık işletmeler yayınlandığında bu sayfada listelenecek.</p>
                <a class="button button--primary" href="<?= base_url('register') ?>">İşletmeni oluştur <i class="far fa-arrow-right"></i></a>
            </div>
        <?php else: ?>
            <div class="business-card-grid">
                <?php foreach ($visibleBusinesses as $business):
                    $detailUrl = base_url('businesses/' . ($business['slug'] ?? $business['id']));
                    $cardImage = $business['intro_image'] ?: $business['cover_image'];
                    $intro = trim((string) ($business['short_intro'] ?: $business['short_description']));
                    $location = trim(implode(' / ', array_filter([$business['city'] ?? '', $business['district'] ?? ''])));
                ?>
                    <article class="business-card">
                        <a class="business-card__image" href="<?= esc($detailUrl) ?>"><img src="<?= base_url($cardImage) ?>" alt="<?= esc($business['name']) ?>" loading="lazy"></a>
                        <div class="business-card__body">
                            <div class="business-card__meta"><span><?= esc($business['category'] ?: 'Hizmet işletmesi') ?></span><?php if ($location !== ''): ?><span><i class="far fa-map-marker-alt"></i> <?= esc($location) ?></span><?php endif; ?></div>
                            <h3><a href="<?= esc($detailUrl) ?>"><?= esc($business['page_title'] ?: $business['name']) ?></a></h3>
                            <?php if ($intro !== ''): ?><p><?= esc($intro) ?></p><?php endif; ?>
                            <a class="text-link" href="<?= esc($detailUrl) ?>">Randevu Al <i class="far fa-arrow-right"></i></a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?= $this->endSection() ?>
