<?php
$featuredBusinesses = $featuredBusinesses ?? [];
$packages = $packages ?? [];
$freePackage = $packages[0] ?? null;
?>

<section class="saas-hero">
    <div class="site-container saas-hero__grid">
        <div class="saas-hero__content">
            <span class="eyebrow"><i class="far fa-sparkles" aria-hidden="true"></i> İşletmeniz için online randevu sistemi</span>
            <h1>Randevular WhatsApp’ta kaybolmasın.</h1>
            <p class="saas-hero__lead">Müşterileriniz uygun saati kendisi seçsin; siz hizmetlerinizi, ekibinizi ve randevularınızı tek panelden yönetin.</p>
            <div class="button-group">
                <a class="button button--primary" href="<?= base_url('register') ?>">Ücretsiz hesabını oluştur <i class="far fa-arrow-right" aria-hidden="true"></i></a>
                <a class="button button--secondary" href="#product">Sistemi incele <i class="far fa-play-circle" aria-hidden="true"></i></a>
            </div>
            <p class="proof-line"><i class="far fa-check-circle" aria-hidden="true"></i> Kredi kartı gerekmez <span>•</span> 5 dakikada kurulum <span>•</span> Ücretsiz başlayın</p>
        </div>

        <div class="hero-product" aria-label="Randevu yönetim paneli ön izlemesi">
            <div class="hero-product__glow" aria-hidden="true"></div>
            <div class="browser-frame hero-product__desktop">
                <div class="browser-frame__bar"><span></span><span></span><span></span><small>Yönetim paneli</small></div>
                <img src="web-assets/images/landing-digital/operations-dashboard.webp" alt="Randevu, doluluk ve operasyon bilgilerinin yer aldığı yönetim paneli" width="1536" height="1024">
            </div>
            <div class="phone-frame hero-product__phone" aria-label="Mobil randevu ekranı">
                <div class="phone-frame__notch"></div>
                <div class="phone-frame__body">
                    <span class="mini-brand"><i class="far fa-calendar-check"></i> Randevu</span>
                    <strong>Uygun saatini seç</strong>
                    <small>28 Temmuz, Salı</small>
                    <div class="mini-times"><span>10:30</span><span class="is-selected">11:00</span><span>11:30</span><span>13:00</span></div>
                    <button type="button" tabindex="-1">Devam et</button>
                </div>
            </div>
            <div class="floating-fact floating-fact--top"><span class="fact-icon fact-icon--green"><i class="far fa-check"></i></span><div><small>Yeni randevu</small><strong>Bugün, 11:00</strong></div></div>
            <div class="floating-fact floating-fact--bottom"><small>Bugünkü doluluk</small><strong>%78</strong><span class="fact-progress"><i></i></span></div>
        </div>
    </div>
</section>

<section class="industry-strip" aria-label="Uygun sektörler">
    <div class="site-container industry-strip__inner">
        <span class="industry-strip__label">Her hizmet işletmesine uyum sağlar</span>
        <div class="industry-chips"><span>Güzellik salonları</span><span>Kuaförler</span><span>Klinikler</span><span>Danışmanlar</span><span>Spor eğitmenleri</span><span>Teknik servisler</span></div>
    </div>
</section>

<section class="section section--soft" id="process">
    <div class="site-container">
        <div class="section-heading section-heading--center">
            <span class="eyebrow">Nasıl çalışır?</span>
            <h2>Üç adımda randevu almaya başlayın.</h2>
            <p>Karmaşık kurulum yok. Temel bilgilerinizi ekleyin, bağlantınızı paylaşın ve programınızı yönetin.</p>
        </div>
        <ol class="process-grid">
            <li><span class="step-number">01</span><span class="step-icon"><i class="far fa-building"></i></span><h3>İşletmeni oluştur</h3><p>Hizmetlerini, çalışma saatlerini ve ekip üyelerini ekle.</p></li>
            <li><span class="step-number">02</span><span class="step-icon"><i class="far fa-link"></i></span><h3>Randevu bağlantını paylaş</h3><p>Müşterilerin boş saatlerini görerek online randevu oluştursun.</p></li>
            <li><span class="step-number">03</span><span class="step-icon"><i class="far fa-calendar-check"></i></span><h3>Tek panelden yönet</h3><p>Randevuları onayla, düzenle ve günlük programını takip et.</p></li>
        </ol>
    </div>
</section>

<section class="section" id="features">
    <div class="site-container">
        <div class="section-heading section-heading--split">
            <div><span class="eyebrow">Temel özellikler</span><h2>Günlük iş yükünüzü hafifleten araçlar.</h2></div>
            <p>Randevudan ekip planlamasına kadar ihtiyaç duyduğunuz temel süreçler tek, anlaşılır bir çalışma alanında.</p>
        </div>
        <div class="benefit-grid">
            <article><span><i class="far fa-clock"></i></span><h3>7/24 online randevu</h3><p>Müşterileriniz işletme saatleri dışında da uygun zamanı seçebilsin.</p></article>
            <article><span><i class="far fa-users"></i></span><h3>Personel ve hizmet yönetimi</h3><p>Hizmetleri, süreleri ve ekip üyelerini kolayca düzenleyin.</p></article>
            <article><span><i class="far fa-calendar-alt"></i></span><h3>Çakışmasız müsaitlik</h3><p>Çalışma saatlerine göre doğru zaman aralıklarını otomatik sunun.</p></article>
            <article><span><i class="far fa-check-circle"></i></span><h3>Onay ve iptal akışı</h3><p>Randevu taleplerini tek yerden onaylayın veya güncelleyin.</p></article>
            <article><span><i class="far fa-store"></i></span><h3>İşletme profili</h3><p>Hizmetlerinizi ve işletme bilgilerinizi düzenli bir vitrinde sunun.</p></article>
            <article><span><i class="far fa-chart-line"></i></span><h3>Tek ekranda operasyon</h3><p>Günlük programınızı ve randevu durumlarını hızlıca takip edin.</p></article>
        </div>
    </div>
</section>

<section class="section product-stories" id="product">
    <div class="site-container">
        <article class="product-story">
            <div class="product-story__copy"><span class="eyebrow">Yönetim paneli</span><h2>Gününüzü tek ekrandan yönetin.</h2><p>Kim, hangi hizmet için, ne zaman geliyor? Günlük akışınızı tek bakışta görün; ekip ve randevu değişikliklerini aynı yerden yönetin.</p><ul class="check-list"><li>Günlük ve haftalık randevu görünümü</li><li>Personel bazlı program takibi</li><li>Onay, iptal ve durum yönetimi</li></ul><a class="text-link" href="<?= base_url('register') ?>">Paneli ücretsiz deneyin <i class="far fa-arrow-right"></i></a></div>
            <div class="product-story__visual product-story__visual--desktop"><span class="visual-label"><i class="far fa-circle"></i> Canlı operasyon görünümü</span><div class="browser-frame"><div class="browser-frame__bar"><span></span><span></span><span></span><small>Randevu paneli</small></div><img src="web-assets/images/landing-digital/operations-dashboard.webp" alt="Günlük randevu ve işletme operasyon paneli" loading="lazy" width="1536" height="1024"></div></div>
        </article>
        <article class="product-story product-story--reverse">
            <div class="product-story__copy"><span class="eyebrow">Müşteri deneyimi</span><h2>Müşterileriniz beklemeden randevu alsın.</h2><p>Telefon trafiğini azaltın. Müşterileriniz hizmeti, personeli ve uygun saati mobil uyumlu sayfanızdan kendi seçsin.</p><ul class="check-list"><li>Mobil uyumlu hızlı rezervasyon</li><li>Yalnızca müsait saatlerin gösterimi</li><li>Kolay ve anlaşılır randevu adımları</li></ul><a class="text-link" href="<?= base_url('businesses') ?>">İşletme sayfalarını inceleyin <i class="far fa-arrow-right"></i></a></div>
            <div class="product-story__visual product-story__visual--mobile"><img src="web-assets/images/landing-digital/customer-booking.webp" alt="Mobil cihazdan online randevu oluşturma deneyimi" loading="lazy" width="1536" height="1024"><div class="visual-fact"><i class="far fa-bolt"></i><span><strong>Hızlı seçim</strong>Hizmet, ekip ve saat</span></div></div>
        </article>
    </div>
</section>

<?php if ($featuredBusinesses !== []): ?>
<section class="section section--soft" id="featured-businesses">
    <div class="site-container">
        <div class="section-heading section-heading--split"><div><span class="eyebrow">Öne çıkan işletmeler</span><h2>Online randevu alan işletmeleri keşfedin.</h2></div><a class="text-link" href="<?= base_url('businesses') ?>">Tüm işletmeler <i class="far fa-arrow-right"></i></a></div>
        <div class="business-card-grid">
            <?php foreach ($featuredBusinesses as $business): $url = base_url('businesses/' . $business['slug']); ?>
                <article class="business-card"><a class="business-card__image" href="<?= esc($url) ?>"><img src="<?= base_url($business['image']) ?>" alt="<?= esc($business['name']) ?>" loading="lazy"></a><div class="business-card__body"><div class="business-card__meta"><span><?= esc($business['category']) ?></span><?php if ($business['location'] !== ''): ?><span><i class="far fa-map-marker-alt"></i> <?= esc($business['location']) ?></span><?php endif; ?></div><h3><a href="<?= esc($url) ?>"><?= esc($business['name']) ?></a></h3><?php if ($business['description'] !== ''): ?><p><?= esc($business['description']) ?></p><?php endif; ?><a class="text-link" href="<?= esc($url) ?>">Randevu Al <i class="far fa-arrow-right"></i></a></div></article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="section packages-brief" id="packages">
    <div class="site-container packages-brief__card">
        <div><span class="eyebrow eyebrow--light">Sade fiyatlandırma</span><h2>Ücretsiz başlayın, ihtiyacınız büyüdüğünde planınızı geliştirin.</h2><p><?= esc($freePackage['description'] ?? 'İşletmenizi kurmak ve online randevu almaya başlamak için ihtiyacınız olan temel araçlar hazır.') ?></p></div>
        <div class="packages-brief__action"><span class="plan-status"><i class="far fa-check"></i> Ücretsiz plan aktif</span><strong><?= esc($freePackage['priceLabel'] ?? 'Ücretsiz') ?></strong><a class="button button--light" href="<?= base_url('packages/select/free') ?>">Paketleri incele <i class="far fa-arrow-right"></i></a><small>Standart ve Premium planlar yakında.</small></div>
    </div>
</section>

<section class="section faq-section" id="faq">
    <div class="site-container faq-layout">
        <div class="section-heading"><span class="eyebrow">Sık sorulan sorular</span><h2>Başlamadan önce bilmeniz gerekenler.</h2><p>Kurulum ve randevu akışıyla ilgili temel soruların kısa yanıtları.</p></div>
        <div class="accordion faq-list" id="faqAccordion">
            <?php
            $faqs = [
                ['Ücretsiz başlayabilir miyim?', 'Evet. Ücretsiz planla işletme profilinizi oluşturabilir, hizmet ve ekip yapınızı hazırlayabilirsiniz. Kredi kartı gerekmez.'],
                ['Kurulum ne kadar sürer?', 'İşletme bilgileriniz hazırsa hizmetlerinizi, çalışma saatlerinizi ve ekibinizi birkaç dakika içinde ekleyebilirsiniz.'],
                ['Müşteriler nasıl randevu alır?', 'İşletme bağlantınız üzerinden hizmeti ve uygun saati seçerek online randevu talebi oluştururlar.'],
                ['Randevuları onaylayabilir veya iptal edebilir miyim?', 'Evet. Gelen talepleri panelden onaylayabilir, reddedebilir veya durumunu güncelleyebilirsiniz.'],
                ['Birden fazla personel ekleyebilir miyim?', 'Personel yapınızı panelden oluşturabilir ve hizmetlerinizi ilgili ekip üyeleriyle birlikte yönetebilirsiniz.'],
                ['Bilgilerimi daha sonra değiştirebilir miyim?', 'Evet. İşletme, hizmet, personel ve çalışma saati bilgilerinizi yönetim panelinden güncelleyebilirsiniz.'],
            ];
            foreach ($faqs as $index => [$question, $answer]): $id = 'faq-' . $index; ?>
                <div class="accordion-item"><h3 class="accordion-header"><button class="accordion-button<?= $index === 0 ? '' : ' collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $id ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="<?= $id ?>"><span><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span><?= esc($question) ?></button></h3><div id="<?= $id ?>" class="accordion-collapse collapse<?= $index === 0 ? ' show' : '' ?>" data-bs-parent="#faqAccordion"><div class="accordion-body"><?= esc($answer) ?></div></div></div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="final-cta"><div class="site-container final-cta__inner"><div><span>Bugün başlayın</span><h2>Randevu trafiğini düzene sokun.</h2><p>İşletmenizi birkaç adımda kurun ve müşterilerinize kolay bir randevu deneyimi sunun.</p></div><a class="button button--light" href="<?= base_url('register') ?>">Ücretsiz hesabını oluştur <i class="far fa-arrow-right"></i></a></div></section>
