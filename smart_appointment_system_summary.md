# Smart Appointment Sistem Özeti

Bu doküman, mevcut CodeIgniter 4 projesinde şu ana kadar kurulan ana yapıyı ve tamamlanan modülleri özetler.

---

## Genel Durum

Smart Appointment, çoklu işletme destekli bir randevu ve işletme yönetim sistemi olarak yapılandırıldı. Sistem şu anda kullanıcı hesabı, işletme yönetimi, hizmet yönetimi, çalışan yönetimi, public işletme vitrini, randevu oluşturma başlangıcı, dashboard randevu yönetimi ve e-posta doğrulama altyapısını içeriyor.

---

## Kullanıcı ve Auth Yapısı

- Kullanıcı kayıt ekranı oluşturuldu.
- Kullanıcı giriş ekranı oluşturuldu.
- Çıkış işlemi eklendi.
- Session tabanlı auth yapısı kuruldu.
- Dashboard sayfaları `auth` filtresiyle koruma altına alındı.
- Kullanıcı rolleri için temel yapı eklendi.
- Varsayılan rol yapısı:
  - `admin`
  - `business_owner`
- Kayıt sonrası yönlendirme kuralı düzenlendi:
  - Normal kayıt/giriş yapan kullanıcı `/dashboard` sayfasına gider.
  - Paket seçerek gelen kullanıcı `/dashboard/businesses` sayfasına gider.

---

## E-posta Doğrulama

- Kayıt olan kullanıcıya 6 haneli doğrulama kodu gönderiliyor.
- Kullanıcı doğrulama kodunu girmeden sisteme giriş yapamıyor.
- Doğrulanmamış kullanıcı giriş yapmaya çalışırsa yeni doğrulama kodu gönderiliyor.
- Kod tekrar gönderme akışı eklendi.
- Mevcut eski kullanıcılar migration sırasında doğrulanmış kabul edildi.
- E-posta gönderimi için CodeIgniter SMTP altyapısı kullanılıyor.
- Gmail SMTP/App Password kullanımı için `.env` destekli yapı hazırlandı.

İlgili yapılar:

- `AuthController`
- `MailService`
- `auth/verify_email.php`
- `emails/verification_code.php`
- `AddEmailVerificationFieldsToUsersTable`

---

## Paket Seçimi

- Landing/public tarafta paket seçimi yapılabiliyor.
- Seçilen paket session'da tutuluyor.
- Kullanıcı girişliyse paket doğrudan kullanıcıya işleniyor.
- Kullanıcı girişli değilse login/register akışına yönlendiriliyor.
- Paket seçimiyle gelen kullanıcı kayıt/giriş sonrası işletme kurulum alanına yönlendiriliyor.

İlgili yapı:

- `PackageCatalog`

---

## İşletme Yönetimi

- İşletme oluşturma eklendi.
- İşletme listeleme eklendi.
- İşletme detay ekranı eklendi.
- İşletme genel bilgiler düzenleme eklendi.
- İşletme aktif/pasif durumu eklendi.
- İşletme web ayarları eklendi.
- İşletme kapak görseli, tanıtım görseli ve galeri görselleri yönetimi eklendi.
- TinyMCE editör ile zengin içerik girişi eklendi.
- Editor görsel yükleme endpoint'i eklendi.
- Public işletme listesi ve işletme detay sayfası oluşturuldu.

İlgili yapılar:

- `BusinessController`
- `BusinessModel`
- `BusinessWebSettingModel`
- `businesses/index.php`
- `businesses/show.php`
- `businesses/tabs/general.php`
- `businesses/tabs/web_settings.php`

---

## Hizmet Yönetimi

- Hizmet yönetimi işletme detayındaki tab yapısından çıkarıldı.
- Hizmetler artık sidebar'daki ayrı `Hizmetler` sayfasından yönetiliyor.
- `/dashboard/services` gerçek hizmet yönetim ekranına bağlandı.
- İşletme filtresiyle seçili işletmenin hizmetleri listeleniyor.
- Hizmet ekleme modal ile yapılıyor.
- Hizmet adı, süre, fiyat, durum ve açıklama yönetiliyor.
- Hizmet aktif/pasif yapılabiliyor.
- Eski işletme detay servis endpoint'leri uyumluluk için yeni hizmet sayfasına yönlendiriliyor.

İlgili yapılar:

- `ServiceController`
- `BusinessServiceModel`
- `dashboard/services/index.php`

---

## Çalışan Yönetimi

- Çalışanlar sidebar'daki ayrı `Çalışanlar` sayfasından yönetiliyor.
- `/dashboard/employees` gerçek çalışan yönetim ekranına bağlandı.
- İşletme filtresiyle seçili işletmenin çalışanları listeleniyor.
- Çalışan ekleme modal ile yapılıyor.
- Çalışan bilgileri:
  - ad soyad
  - e-posta
  - telefon
  - rol
  - durum
- Çalışan rolleri:
  - `manager`
  - `staff`
- Çalışan aktif/pasif yapılabiliyor.
- Aynı e-posta aynı işletmeye ikinci kez eklenemiyor.
- Çalışan e-postası ile kullanıcı hesabı eşleşirse işletme erişimi otomatik bağlanıyor.
- Çalışan sisteme davet edildiğinde davet e-postası gönderiliyor.
- Çalışan yönetimi sadece işletme sahibi/admin tarafında açık tutuldu.

İlgili yapılar:

- `EmployeeController`
- `BusinessStaffModel`
- `dashboard/employees/index.php`
- `emails/staff_invitation.php`
- `CreateBusinessStaffTable`

---

## İşletme Erişim Yetkisi

- İşletme erişimi artık sadece işletme sahibine bağlı değil.
- Aktif çalışan üyeliği olan kullanıcılar da ilgili işletmeye erişebiliyor.
- İşletme erişim sorgusu şu kapsamı içeriyor:
  - işletme sahibi
  - işletmeyi oluşturan kullanıcı
  - aktif çalışan üyeliği `user_id`
  - aktif çalışan üyeliği e-posta eşleşmesi
- Admin tüm işletmeleri görebiliyor.

İlgili yapı:

- `BusinessModel::accessibleByUser()`

---

## Randevu Yapısı

- Public işletme detayında randevu oluşturma başlangıç akışı mevcut.
- Dashboard tarafında randevu listesi mevcut.
- Randevu durum güncelleme mevcut.
- İşletme sahibi ve işletmeye bağlı aktif çalışanlar ilgili işletmenin randevularını görebiliyor.
- Randevu durumları:
  - bekliyor
  - onaylandı
  - reddedildi
  - iptal edildi
- Randevu için reddetme nedeni, önerilen tarih/saat ve yönetici notu alanları bulunuyor.

İlgili yapılar:

- `AppointmentController`
- `AppointmentModel`
- `dashboard/appointments/index.php`
- `Public/BusinessController`

---

## Public Taraf

- Landing sayfası mevcut.
- Paket kartları mevcut.
- Public işletme listesi mevcut.
- Public işletme detay sayfası mevcut.
- İşletme detayında hizmetler, görseller, içerik ve randevu modalı gösteriliyor.
- Public randevu oluşturma endpoint'i mevcut.

İlgili yapılar:

- `Public/LandingController`
- `Public/BusinessController`
- `web/index.php`
- `web/businesses/index.php`
- `web/businesses/show.php`

---

## Mail Altyapısı

- Merkezi `MailService` oluşturuldu.
- HTML mail template desteği eklendi.
- Şu mail tipleri hazır:
  - e-posta doğrulama kodu
  - çalışan davet e-postası
- SMTP bilgileri `.env` üzerinden yönetiliyor.

İlgili yapılar:

- `MailService`
- `emails/verification_code.php`
- `emails/staff_invitation.php`

---

## Dashboard Menü Yapısı

Sidebar'da aktif ana bölümler:

- Dashboard
- İşletmelerim
- Hizmetler
- Çalışanlar
- Randevular
- Ayarlar

Çalışma saatleri/müsaitlik menüsü kapsamdan çıkarıldı.

---

## Veritabanı Migration Özeti

Oluşturulan veya genişletilen ana tablolar:

- `users`
- `businesses`
- `business_web_settings`
- `business_services`
- `business_staff`
- `appointments`

Kullanıcı doğrulama alanları:

- `email_verified_at`
- `email_verification_code_hash`
- `email_verification_expires_at`

Çalışan tablosu:

- `business_id`
- `user_id`
- `name`
- `email`
- `phone`
- `role`
- `status`
- `invited_at`
- `accepted_at`

---

## Şu An Bilerek Dışarıda Bırakılanlar

- Çalışma saatleri/müsaitlik modülü
- Online ödeme
- SMS bildirimi
- Kupon sistemi
- Yorum sistemi
- Çoklu dil
- Subdomain desteği
- Gelişmiş raporlama

---

## Sonraki Mantıklı Geliştirme Başlıkları

- Kullanıcının kendi randevularını görebileceği public alan
- Dashboard ana özet ekranı
- Randevu bildirim mailleri
- Manager/staff için daha detaylı yetki ayrımı
- Randevu çakışma kontrolünün güçlendirilmesi
- Çalışan-hizmet eşleştirme
- README ve kurulum dokümantasyonu
