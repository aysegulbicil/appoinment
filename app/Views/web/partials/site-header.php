<a class="skip-link" href="#main-content">İçeriğe geç</a>
<header class="site-header" data-site-header>
    <div class="site-container site-header__inner">
        <a class="site-brand" href="<?= base_url('/') ?>" aria-label="Randevu ana sayfa">
            <span class="site-brand__mark" aria-hidden="true"><i class="far fa-calendar-check"></i></span>
            <span><strong>Randevu</strong><small>İşletme yönetimi</small></span>
        </a>
        <button class="site-menu-toggle" type="button" aria-expanded="false" aria-controls="site-navigation" data-menu-toggle>
            <span class="visually-hidden">Menüyü aç</span><i class="far fa-bars" aria-hidden="true"></i>
        </button>
        <div class="site-nav-wrap" id="site-navigation" data-site-navigation>
            <nav class="site-nav" aria-label="Ana menü">
                <a href="<?= base_url('/#features') ?>">Özellikler</a>
                <a href="<?= base_url('/#process') ?>">Nasıl Çalışır?</a>
                <a href="<?= base_url('businesses') ?>">İşletmeler</a>
                <a href="<?= base_url('/#packages') ?>">Paketler</a>
            </nav>
            <div class="site-header__actions">
                <a class="site-login" href="<?= base_url('login') ?>">Giriş Yap</a>
                <a class="button button--primary button--small" href="<?= base_url('register') ?>">Ücretsiz Başla <i class="far fa-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</header>

