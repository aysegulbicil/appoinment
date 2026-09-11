# Proje Özeti ve Panel Planı

Bu dosya mevcut CodeIgniter 4 projesinin kısa ve net haritasıdır. Amaç, projeyi yeniden yazarken önce paneli doğru planlamak, panel bittikten sonra web tarafına geçmektir.

## Genel Durum

Proje bir randevu ve işletme yönetim sistemi olarak kurulmuş. Sistemde kullanıcı kaydı, giriş, e-posta doğrulama, paket seçimi, işletme yönetimi, hizmet yönetimi, çalışan yönetimi, web sayfası yönetimi ve randevu talebi alma yapıları mevcut.

Mevcut proje çalışır bir temel kurmuş ama panel tarafı dağınık ilerlemiş. Panel sayfaları gerçek bir panel akışı gibi ayrılmamış; bazı controllerlar içerikleri `public/home/index` layoutu içine basıyor. Header, sidebar ve bazı view dosyalarında hazır admin tema kalıntıları var.

Yeni senaryoda önce panel tamamen netleşmeli. Panelde hangi sayfa neyi yönetecek, hangi veri web tarafında nasıl görünecek, hangi paket hangi alanı kullanabilecek bunlar önce planlanmalı. Panel bittikten sonra web vitrin tarafı hazırlanmalı.

## Teknoloji ve Ana Yapı

- Backend: PHP, CodeIgniter 4.
- Veritabanı: MySQL odaklı migration yapısı var.
- Admin tema: MotaAdmin tabanlı hazır panel şablonu kullanılmış.
- Web tema: `web-template` ve `public/web-assets` altında ayrı web teması var.
- Auth: Session tabanlı çalışıyor.
- Mail: CodeIgniter Email servisi ve `MailService` ile yönetiliyor.

## Mevcut Rotalar

Public rotalar:

- `/` ana landing sayfası.
- `/businesses` aktif işletme listesi.
- `/businesses/{slug}` işletme web vitrini.
- `/businesses/{slug}/{pageSlug}` işletmeye ait özel web sayfası.
- `/businesses/{id}/appointments` public randevu talebi kaydı.

Auth rotaları:

- `/login`
- `/register`
- `/packages/select/{packageCode}`
- `/verify-email`
- `/logout`

Panel rotaları:

- `/dashboard`
- `/dashboard/businesses`
- `/dashboard/businesses/create`
- `/dashboard/businesses/{id}`
- `/dashboard/services`
- `/dashboard/employees`
- `/dashboard/appointments`
- `/dashboard/settings`
- `/dashboard/web`
- `/dashboard/businesses/{id}/web-pages`
- `/dashboard/businesses/{id}/web-settings/general`
- `/dashboard/businesses/{id}/web-settings/menu`
- `/dashboard/businesses/{id}/web-settings/seo`

## Controller Özeti

`AuthController`

- Kayıt, giriş, çıkış ve e-posta doğrulama işlemlerini yapıyor.
- Paket seçimini sessionda tutuyor.
- Kullanıcı giriş yaptıktan sonra seçilen paketi kullanıcıya işliyor.
- Doğrulanmamış kullanıcıya tekrar doğrulama kodu gönderebiliyor.
- Çalışan e-postası ile kullanıcı hesabını eşleştiriyor.

`Dashboard\BusinessController`

- İşletme listeleme, oluşturma, detay, güncelleme ve aktif/pasif işlemlerini yapıyor.
- Yeni işletme oluşturulunca web ayarı ve varsayılan web sayfalarını oluşturuyor.
- Varsayılan sayfalar: Anasayfa, Hakkımızda, Hizmetler, Galeri, İletişim, SSS.
- İşletme genel bilgileri ve eski web ayarları aynı controller içinde karışık duruyor.

`Dashboard\ServiceController`

- Seçili işletmeye göre hizmet listeliyor.
- Hizmet ekleme, düzenleme ve durum değiştirme yapıyor.
- Hizmet alanları: ad, açıklama, süre, fiyat, durum.

`Dashboard\EmployeeController`

- Çalışanları işletmeye göre listeliyor.
- Çalışan ekleme, düzenleme ve durum değiştirme yapıyor.
- Çalışan rolleri: yönetici ve çalışan.
- Çalışan eklenince davet e-postası gönderiliyor.
- Sadece işletme sahibi veya admin çalışan yönetebiliyor.

`Dashboard\AppointmentController`

- İşletmeye gelen randevuları listeliyor.
- Randevu durumunu güncelliyor.
- Durumlar: bekliyor, onaylandı, reddedildi, iptal edildi.
- Red/iptal sebebi, alternatif tarih/saat ve iç not alanları var.

`Dashboard\BusinessWebController`

- Web ayarı yönetimi için işletmeleri kart halinde listeliyor.
- Her işletme için sayfalar, sayfa ekle, genel ayarlar, menü ayarları ve SEO ayarlarına link veriyor.

`Dashboard\BusinessWebPageController`

- İşletmeye ait web sayfalarını yönetiyor.
- Sayfa ekleme, düzenleme, silme, aktif/pasif yapma, menüde göster/gizle ve sıralama yapıyor.
- Sayfa alanları: başlık, slug, sayfa tipi, kısa giriş, içerik, kapak görseli, intro görseli, galeri, SEO alanları, sosyal görsel, menü etiketi, sıra, aktiflik.

`Dashboard\BusinessWebSettingController`

- İşletmenin genel web ayarlarını yönetiyor.
- Genel ayarlar: site başlığı, açıklama, logo, footer metni, renkler.
- Menü ayarları: hizmetler, çalışanlar, fiyatlar, iletişim, harita göster/gizle.
- SEO ayarları: varsayılan SEO başlığı, açıklaması, anahtar kelimeleri ve sosyal görsel.

`Public\LandingController`

- Ana landing sayfasını açıyor.
- Paketleri ve öne çıkan işletmeleri gösteriyor.
- Veritabanında işletme yoksa örnek işletme kartları kullanıyor.

`Public\BusinessController`

- Public işletme listesini gösteriyor.
- İşletme detay ve işletmeye ait sayfa gösterimini yapıyor.
- Aktif hizmetleri web tarafına gönderiyor.
- Randevu talebini kaydediyor.
- Randevu için şu an sadece tarih/saat inputu var; slot üretimi ve çakışma kontrolü yok.

## Model Özeti

`UserModel`

- Kullanıcı adı, e-posta, telefon, firma adı, rol, paket, şifre ve e-posta doğrulama alanlarını tutuyor.

`BusinessModel`

- İşletme temel bilgilerini tutuyor.
- Sahip, oluşturan kullanıcı ve aktif çalışan üzerinden erişim sorgusu yapabiliyor.

`BusinessServiceModel`

- İşletmeye bağlı hizmetleri tutuyor.
- Hizmet adı, açıklama, süre, fiyat ve durum alanları var.

`BusinessStaffModel`

- İşletmeye bağlı çalışanları tutuyor.
- Kullanıcı hesabı ile e-posta üzerinden eşleşebiliyor.

`AppointmentModel`

- Randevu taleplerini tutuyor.
- Müşteri bilgileri, hizmet, tarih, saat, durum, not ve yönetici cevap alanları var.

`BusinessWebSettingModel`

- İşletmenin genel web ayarlarını tutuyor.
- Logo, renk, footer, iletişim, sosyal medya, varsayılan SEO ve görünürlük ayarları var.

`BusinessWebPageModel`

- İşletmeye ait web sayfalarını tutuyor.
- Soft delete aktif.
- Sayfa tipi, içerik, görseller, SEO, menü görünürlüğü ve sıralama alanları var.

## View ve Masaüstü Panel Görünümü

Panel masaüstünde sol menülü klasik admin panel gibi düşünülmüş. Sol sidebar içinde şu ana bölümler var:

- Dashboard
- İşletmelerim
- Hizmetler
- Çalışanlar
- Randevular
- Ayarlar
- Web Ayarları altında: Sayfalar, Sayfa Ekle, Genel Ayarlar, Menü Ayarları, SEO Ayarları

Mevcut masaüstü panel görünümünde problemli noktalar:

- Header içinde MotaAdmin demo içerikleri duruyor.
- Bazı metinler İngilizce demo olarak kalmış.
- `layouts/sidebar.php` içinde `return` sonrası eski tema kodu kalmış.
- `layouts/header.php` çok uzun ve demo chat/notification/profile alanları içeriyor.
- İşletmeler sayfasında tablo başlıkları hala "All Staff, Designation, Joining Date" gibi yanlış demo metinleri kullanıyor.
- Türkçe karakterler bazı dosyalarda bozulmuş görünüyor.
- Web ayarları sidebar linkleri `/dashboard/web?section=...` gibi görünüyor ama asıl gerçek rotalar işletme id isteyen `/dashboard/businesses/{id}/web-settings/...` rotaları. Bu yüzden sidebar mantığı yeniden düzenlenmeli.

## Mevcut Panel Sayfaları

### Dashboard

Şu an gerçek bir özet dashboard yok. `layouts/main.php` içinde hazır tema istatistik kartları ve demo tablolar var.

Yeni yazımda burası gerçek verilerle kurulmalı:

- Bugünkü randevular.
- Bekleyen randevular.
- Aktif hizmet sayısı.
- Aktif çalışan sayısı.
- Son randevu talepleri.
- Web sayfası durumu.

### İşletmelerim

Mevcut durumda işletmeleri listeliyor. Düzenle, aktif/pasif yap ve detay butonları var.

Yeni yazımda bu sayfa işletme seçme merkezi olmalı. Bir işletme seçilince panelin diğer sayfaları o işletmeye göre çalışmalı.

Gerekli alanlar:

- İşletme adı.
- Kategori.
- Telefon.
- E-posta.
- Şehir/ilçe.
- Durum.
- Paket.
- Web vitrini linki.

### İşletme Detayı

Mevcut sekmeler:

- Genel Bilgiler.
- Web Sayfaları.
- Web Ayarları.

Kodda `staff` tab kontrolü var ama tab listesinde aktif değil. Bu yapı karışık. Yeni planda çalışanlar ayrı sayfada kalmalı.

### Hizmetler

Mevcut durumda işletme filtresi var. Seçili işletmenin hizmetleri tablo içinde düzenleniyor. Yeni hizmet modal ile ekleniyor.

Web tarafına etkisi:

- Public işletme sayfasında hizmet listesi görünür.
- Randevu formundaki hizmet seçimi buradan gelir.
- Fiyat ve süre gösterimi web ayarındaki `show_prices` gibi ayarlarla kontrol edilir.

Eksik:

- Hizmet silme yok.
- Hizmete görsel yok.
- Hizmet kategorisi yok.
- Hizmetin hangi çalışanlar tarafından verileceği yok.

### Çalışanlar

Mevcut durumda işletme filtresi var. Çalışan ekleme modal ile yapılıyor. Çalışan bilgileri tablo içinde düzenleniyor.

Web tarafına etkisi:

- Public sayfada ekip/çalışan alanı açılabilir.
- Randevu akışında çalışan seçimi ileride buradan gelir.

Eksik:

- Çalışan çalışma saatleri yok.
- Çalışan-hizmet eşleştirmesi yok.
- Çalışan fotoğrafı yok.
- Yetki seviyesi sadece basit rol olarak var.

### Randevular

Mevcut durumda gelen randevular listeleniyor. Modal ile durum güncelleniyor.

Web tarafına etkisi:

- Public formdan gelen talepler burada yönetiliyor.

Eksik:

- Takvim görünümü yok.
- Slot çakışma kontrolü yok.
- Otomatik onay akışı yok.
- Müşteriye durum maili yok.
- Çalışan bazlı randevu dağılımı yok.

### Ayarlar

Mevcut `/dashboard/settings` sayfası `SectionController` üzerinden genel placeholder sayfaya gidiyor. Gerçek ayarlar modülü yok.

Yeni yazımda ayarlar üçe ayrılmalı:

- Hesap ayarları.
- İşletme ayarları.
- Paket ve kullanım ayarları.

### Web Ayarları

Mevcut durumda iki farklı yapı var:

- `/dashboard/web` işletmeleri listeliyor ve işletme bazlı web yönetimi linkleri veriyor.
- İşletme detayında da web sayfaları ve web ayarları sekmeleri var.

Yeni yazımda tek mantık seçilmeli. En temiz yapı:

- Sol menüde "Web Sitesi" bölümü olmalı.
- Kullanıcı önce aktif işletmeyi seçmiş olmalı.
- Web Sitesi altında şu sayfalar olmalı:
  - Sayfalar
  - Menü
  - Tema ve Genel Ayarlar
  - SEO
  - Galeri
  - Önizleme

## Public Web Tarafı

Public tarafta landing sayfası, işletme listesi ve işletme detay/vitrin sayfası var.

İşletme vitrini şu verileri kullanıyor:

- İşletme adı.
- Kategori.
- Şehir/ilçe.
- Telefon/e-posta.
- Web ayarları.
- Web sayfaları.
- Hizmetler.
- Galeri.
- Randevu modalı.

Public web tarafı paneldeki sayfa yönetimine bağlanmış durumda. Panelde oluşturulan sayfalar publicte `/businesses/{slug}/{pageSlug}` olarak açılabiliyor.

Eksik:

- Web vitrini tasarımı panel planına göre yeniden düzenlenmeli.
- Sayfa tiplerine göre özel görünüm detayları net değil.
- Randevu akışı sadece basit form. Akıllı slot yok.
- Müşteri kendi randevularını göremiyor.

## Paket Yapısı

Mevcut paketler:

- Ücretsiz.
- Standart.
- Premium.

Paketler `PackageCatalog` içinde tanımlı. Şu an limitler gerçek anlamda uygulanmıyor; `businesses` ve `employees` limitleri `null`.

Benim önerim senin fikrinle aynı: önce paneli premium özelliklere göre eksiksiz tasarlayalım. Sonra ücretsiz ve standart paketlerde hangi menü, hangi limit, hangi alan kapalı olacak onu filtreleyelim.

Bu daha doğru çünkü:

- Önce tam sistemi görürüz.
- Veri modeli geniş kalır.
- Paket kısıtlaması sonradan permission/limit katmanında yapılır.
- Ücretsiz ve standart için ayrı ayrı eksik ekran tasarlamak zorunda kalmayız.

## Premium Panel Öncelikli Yeni Plan

### 1. Panel İskeleti

Önce gerçek bir panel layoutu yapılmalı.

Yapılacaklar:

- `dashboard` için ayrı layout oluştur.
- Header, sidebar, content ve footer temizlensin.
- Demo chat, notification ve örnek profil alanları kaldırılsın.
- Menü sadece gerçek modülleri göstersin.
- Türkçe karakterler düzeltilsin.
- Aktif işletme seçici eklensin.

### 2. Dashboard Ana Sayfa

Premium panelin ilk ekranı gerçek özet ekranı olmalı.

Kartlar:

- Bugünkü randevular.
- Bekleyen randevular.
- Onaylanan randevular.
- Aktif hizmetler.
- Aktif çalışanlar.
- Web sitesi durumu.

Listeler:

- Son randevular.
- Bugünkü program.
- Eksik kurulum uyarıları.

### 3. İşletme Yönetimi

İşletme oluşturma ve düzenleme merkezi yapılmalı.

Alanlar:

- Temel bilgiler.
- Adres ve konum.
- İletişim.
- Kategori.
- Durum.
- Logo/kapak gibi temel marka alanları.

Web tarafına etkisi:

- İşletme adı, kategori, konum ve iletişim bilgileri public vitrinde görünür.

### 4. Hizmet Yönetimi

Premium mantıkla hizmet modülü geniş tasarlanmalı.

Alanlar:

- Hizmet adı.
- Açıklama.
- Süre.
- Fiyat.
- Durum.
- Hizmet görseli.
- Hizmet kategorisi.
- Online randevuya açık/kapalı.

Sonradan paket filtreleri:

- Ücretsiz paket: sınırlı hizmet sayısı.
- Standart paket: daha fazla hizmet.
- Premium paket: kategori, görsel, gelişmiş ayarlar.

### 5. Çalışan Yönetimi

Çalışan modülü randevu algoritmasının temeli olacak.

Alanlar:

- Ad soyad.
- E-posta.
- Telefon.
- Rol.
- Durum.
- Fotoğraf.
- Verdiği hizmetler.
- Çalışma saatleri.

Sonradan paket filtreleri:

- Ücretsiz paket: az çalışan limiti.
- Standart paket: çalışan-hizmet eşleştirme.
- Premium paket: özel çalışma saatleri, izin günleri, gelişmiş yetki.

### 6. Çalışma Saatleri ve Müsaitlik

Bu modül şu an yok. Randevu sisteminin doğru çalışması için panelde olmalı.

Sayfalar:

- İşletme çalışma saatleri.
- Çalışan özel çalışma saatleri.
- Kapalı günler.
- Mola saatleri.
- Tatil/izin günleri.

Web tarafına etkisi:

- Randevu formunda sadece uygun saatler gösterilir.

### 7. Randevu Yönetimi

Mevcut randevu listesi korunup geliştirilmeli.

Görünümler:

- Liste görünümü.
- Takvim görünümü.
- Günlük akış.
- Durum filtreleri.

İşlemler:

- Onayla.
- Reddet.
- İptal et.
- Alternatif tarih/saat öner.
- İç not ekle.
- Müşteriye mail gönder.

### 8. Web Sitesi Yönetimi

Panel bittikten sonra web tarafının sağlam bağlanması için bu bölüm iyi tasarlanmalı.

Sayfalar:

- Sayfalar: Anasayfa, Hakkımızda, Hizmetler, Galeri, İletişim, SSS, Özel Sayfa.
- Menü: sayfa sıralama, menü etiketi, görünürlük.
- Tema: logo, renkler, kapak görselleri, footer.
- SEO: varsayılan SEO, sayfa bazlı SEO, sosyal paylaşım görseli.
- Galeri: işletme genel galeri yönetimi.
- Önizleme: public vitrini açan bağlantı.

Web tarafına etkisi:

- Her panel alanı public vitrinde karşılık bulmalı.
- Panelde görünürlük kapalıysa webde o bölüm çıkmamalı.

### 9. Ayarlar

Gerçek ayarlar modülü oluşturulmalı.

Alt sayfalar:

- Hesap bilgileri.
- Şifre değiştirme.
- Bildirim tercihleri.
- Paket bilgisi.
- Firma varsayılanları.

### 10. Paket ve Yetki Katmanı

Premium panel tamamlandıktan sonra paket kuralları eklensin.

Kontrol edilecek şeyler:

- Menü görünürlüğü.
- Sayfa erişimi.
- Kayıt limitleri.
- Form alanı görünürlüğü.
- Premium özellik kilidi.

Örnek:

- Ücretsiz pakette web sayfası sayısı sınırlı olabilir.
- Standart pakette SEO açılabilir.
- Premium pakette gelişmiş tema, çalışan-hizmet eşleştirme, takvim, gelişmiş raporlar açılabilir.

## Öncelik Sırası

1. Panel layout temizliği.
2. Sidebar ve header düzeni.
3. Dashboard ana sayfa.
4. Aktif işletme seçimi mantığı.
5. İşletme yönetimi.
6. Hizmet yönetimi.
7. Çalışan yönetimi.
8. Çalışma saatleri.
9. Randevu yönetimi.
10. Web sitesi yönetimi.
11. Ayarlar.
12. Paket filtreleri.
13. Web vitrin tasarımı.
14. Public randevu akışı.

## Kısa Sonuç

Proje tamamen sıfır değil; iyi bir temel var. Ama panel şu an ürün gibi değil, daha çok parçalar halinde ilerlemiş bir geliştirme alanı gibi duruyor.

Yeni yazımda en doğru yaklaşım şudur:

Önce premium panelin tüm sayfalarını ve veri bağlantılarını eksiksiz kuralım. Sonra ücretsiz ve standart paket için aynı panel üzerinden limit ve kilit mantığı ekleyelim. Paneldeki her alanın web tarafında nerede görüneceğini baştan belirleyelim. Panel tamamlanmadan web tarafına geçmeyelim.
