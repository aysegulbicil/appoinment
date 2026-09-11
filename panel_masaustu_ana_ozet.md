# Panel Masaüstü Ana Özeti

Bu dosya kod içi teknik detayları anlatmaz. Masaüstü panelde kullanıcı ne görecek, hangi sayfalar olacak, her sayfanın içinde hangi ayarlar bulunacak bunu net şekilde özetler.

## Genel Yaklaşım

Yeni geliştirme sırası panel öncelikli olacak. Önce paneldeki tüm sayfalar premium paket mantığıyla eksiksiz tasarlanacak. Daha sonra ücretsiz ve standart paketlerde hangi özelliklerin kapalı, limitli veya gizli olacağı belirlenecek.

Panel bittikten sonra web tarafına geçilecek. Web tarafında görünecek her alanın panelde bir karşılığı olacak.

## Panelin Ana Yapısı

Masaüstü panel sol menülü bir yönetim ekranı olmalı.

Sol menüde ana bölümler:

- Dashboard
- İşletmelerim
- Hizmetler
- Çalışanlar
- Çalışma Saatleri
- Randevular
- Web Sitesi
- Ayarlar
- Paket / Abonelik

Panelin üst kısmında:

- Aktif işletme seçici
- Kullanıcı adı
- Paket bilgisi
- Web sitesini görüntüle butonu
- Çıkış butonu

## 1. Dashboard

Panel açıldığında ilk görünen sayfa olmalı.

Bu sayfanın amacı işletme sahibine hızlı durum özeti vermek.

İçerikler:

- Bugünkü randevu sayısı
- Bekleyen randevu sayısı
- Onaylanan randevu sayısı
- Aktif hizmet sayısı
- Aktif çalışan sayısı
- Web sitesi yayında mı bilgisi
- Son gelen randevular
- Bugünkü randevu listesi
- Eksik kurulum uyarıları

Örnek uyarılar:

- Henüz hizmet eklenmemiş.
- Çalışma saatleri belirlenmemiş.
- Web sitesi kapak görseli eklenmemiş.
- SEO bilgileri tamamlanmamış.

## 2. İşletmelerim

Bu sayfa işletme yönetim merkezi olmalı.

Kullanıcı burada sahip olduğu işletmeleri görür. Birden fazla işletme varsa aktif işletmeyi buradan seçebilir.

Liste alanları:

- İşletme adı
- Kategori
- Şehir / ilçe
- Telefon
- E-posta
- Durum
- Paket
- Web sitesi linki

İşlemler:

- Yeni işletme ekle
- İşletmeyi düzenle
- Aktif / pasif yap
- Web sitesini görüntüle
- Panelde bu işletmeye geç

İşletme düzenleme içinde:

- İşletme adı
- Kategori
- Telefon
- E-posta
- Şehir
- İlçe
- Adres
- Kısa açıklama
- Durum
- Logo
- Kapak görseli

Web tarafına etkisi:

- İşletme adı, kategori, konum, iletişim ve açıklama web sitesinde görünür.

## 3. Hizmetler

Bu sayfa işletmenin sunduğu hizmetleri yönetir.

Liste alanları:

- Hizmet adı
- Süre
- Fiyat
- Durum
- Açıklama
- Online randevuya açık mı

İşlemler:

- Hizmet ekle
- Hizmet düzenle
- Hizmeti aktif / pasif yap
- Hizmet sil
- Hizmet sıralaması yap

Hizmet formunda:

- Hizmet adı
- Kısa açıklama
- Detaylı açıklama
- Süre
- Fiyat
- Hizmet görseli
- Hizmet kategorisi
- Durum
- Randevuya açık / kapalı

Web tarafına etkisi:

- Hizmetler web sitesindeki hizmetler bölümünde görünür.
- Randevu formundaki hizmet seçimi buradan gelir.
- Fiyat gösterimi web ayarlarına göre açılıp kapanabilir.

## 4. Çalışanlar

Bu sayfa işletmede çalışan kişileri yönetir.

Liste alanları:

- Ad soyad
- E-posta
- Telefon
- Rol
- Durum
- Hesap durumu
- Verdiği hizmetler

İşlemler:

- Çalışan ekle
- Çalışan düzenle
- Çalışanı aktif / pasif yap
- Çalışana hizmet bağla
- Davet gönder

Çalışan formunda:

- Ad soyad
- E-posta
- Telefon
- Rol
- Fotoğraf
- Durum
- Verdiği hizmetler
- Kişisel çalışma saatleri

Roller:

- İşletme yöneticisi
- Çalışan

Web tarafına etkisi:

- İstenirse çalışanlar web sitesinde ekip alanında gösterilir.
- Randevu alırken çalışan seçimi bu sayfadaki verilere göre yapılır.

## 5. Çalışma Saatleri

Bu sayfa randevu sisteminin temel ayarlarını belirler.

İşletme çalışma saatleri:

- Pazartesi
- Salı
- Çarşamba
- Perşembe
- Cuma
- Cumartesi
- Pazar

Her gün için:

- Açık / kapalı
- Başlangıç saati
- Bitiş saati
- Mola başlangıcı
- Mola bitişi

Ek ayarlar:

- Tatil günleri
- Özel kapalı günler
- Randevu aralığı
- En erken randevu alma süresi
- En geç randevu alma süresi

Çalışan bazlı ayarlar:

- Çalışanın özel saatleri
- Çalışanın izin günleri
- Çalışanın hizmet verdiği günler

Web tarafına etkisi:

- Randevu formunda sadece uygun gün ve saatler görünür.
- Dolu saatler otomatik kapanır.

## 6. Randevular

Bu sayfa gelen tüm randevu taleplerini yönetir.

Görünümler:

- Liste görünümü
- Takvim görünümü
- Günlük görünüm

Liste alanları:

- Randevu kodu
- Müşteri adı
- Telefon
- E-posta
- Hizmet
- Çalışan
- Tarih
- Saat
- Durum

Durumlar:

- Bekliyor
- Onaylandı
- Reddedildi
- İptal edildi
- Tamamlandı

İşlemler:

- Randevuyu onayla
- Randevuyu reddet
- Randevuyu iptal et
- Alternatif tarih / saat öner
- İç not ekle
- Müşteriye bilgilendirme gönder

Randevu detayında:

- Müşteri bilgileri
- Hizmet bilgileri
- Çalışan bilgileri
- Randevu tarihi ve saati
- Müşteri notu
- Yönetici notu
- Durum geçmişi

Web tarafına etkisi:

- Web sitesinden gelen randevu talepleri bu sayfaya düşer.
- Panelde yapılan durum değişiklikleri müşteriye bildirilebilir.

## 7. Web Sitesi

Bu bölüm panel ile web tarafı arasındaki ana bağlantıdır.

Alt sayfalar:

- Sayfalar
- Menü
- Tema
- Galeri
- SEO
- Önizleme

### 7.1 Sayfalar

İşletmenin web sitesindeki sayfalar buradan yönetilir.

Varsayılan sayfalar:

- Anasayfa
- Hakkımızda
- Hizmetler
- Galeri
- İletişim
- SSS

İşlemler:

- Sayfa ekle
- Sayfa düzenle
- Sayfayı aktif / pasif yap
- Menüde göster / gizle
- Sayfa sırasını değiştir
- Sayfa sil

Sayfa formunda:

- Sayfa başlığı
- Sayfa tipi
- Slug
- Menü etiketi
- Kısa giriş
- İçerik
- Kapak görseli
- Intro görseli
- Galeri görselleri
- SEO başlığı
- SEO açıklaması
- SEO anahtar kelimeleri
- Sosyal paylaşım görseli
- Aktiflik
- Menüde görünürlük

### 7.2 Menü

Web sitesindeki üst menü buradan yönetilir.

Ayarlar:

- Sayfa sırası
- Menü adı
- Menüde göster / gizle
- Ana sayfa linki
- Randevu al butonu göster / gizle

### 7.3 Tema

Web sitesinin görsel kimliği buradan yönetilir.

Ayarlar:

- Logo
- Ana renk
- Yardımcı renk
- Kapak görseli
- Footer metni
- Site başlığı
- Site açıklaması
- İletişim bilgileri
- Sosyal medya linkleri

### 7.4 Galeri

İşletmenin web sitesinde görünecek görseller buradan yönetilir.

İşlemler:

- Görsel ekle
- Görsel sil
- Görselleri sırala
- Kapak olarak seç

### 7.5 SEO

Web sitesinin arama motoru ayarları buradan yönetilir.

Ayarlar:

- Varsayılan SEO başlığı
- Varsayılan SEO açıklaması
- Varsayılan anahtar kelimeler
- Sosyal paylaşım görseli
- Sayfa bazlı SEO bilgileri

### 7.6 Önizleme

Panelde yapılan değişikliklerin web tarafındaki görüntüsü kontrol edilir.

İşlemler:

- Web sitesini aç
- Anasayfayı önizle
- Sayfa önizle
- Mobil görünüm kontrolü

## 8. Ayarlar

Bu bölüm hesap ve genel panel ayarlarını içerir.

Hesap ayarları:

- Ad soyad
- E-posta
- Telefon
- Şifre değiştirme

Bildirim ayarları:

- Randevu mail bildirimi
- Çalışan davet maili
- Müşteri bilgilendirme maili

İşletme varsayılanları:

- Varsayılan para birimi
- Varsayılan randevu aralığı
- Varsayılan saat formatı
- Varsayılan dil

## 9. Paket / Abonelik

Bu sayfa kullanıcının mevcut paketini ve kullanım durumunu gösterir.

Gösterilecek bilgiler:

- Mevcut paket
- Paket özellikleri
- Kullanılan işletme sayısı
- Kullanılan çalışan sayısı
- Kullanılan hizmet sayısı
- Paket yükseltme seçenekleri

Paket mantığı:

- Önce premium panel tam yapılacak.
- Sonra ücretsiz ve standart paketlerde bazı özellikler kapatılacak.
- Kapalı özellikler panelde kilitli olarak gösterilebilir.

Örnek paket ayrımı:

- Ücretsiz: sınırlı işletme, sınırlı hizmet, temel randevu.
- Standart: daha fazla çalışan, SEO, gelişmiş web sayfaları.
- Premium: çalışma saatleri, çalışan-hizmet eşleştirme, takvim, gelişmiş raporlar, gelişmiş web yönetimi.

## Panelden Webe Bağlantı Mantığı

Panelde girilen her bilgi web tarafında bir yere bağlanmalı.

Bağlantı özeti:

- İşletme bilgileri web sitesinin genel tanıtım alanına gider.
- Hizmetler web sitesindeki hizmetler bölümüne ve randevu formuna gider.
- Çalışanlar ekip alanına ve randevu çalışan seçimine gider.
- Çalışma saatleri randevu saatlerini belirler.
- Web sayfaları public web menüsünü oluşturur.
- Tema ayarları web sitesinin görünümünü belirler.
- SEO ayarları arama motoru ve sosyal paylaşım görünümünü belirler.
- Randevular web formundan panele düşer.

## Öncelikli Yapım Sırası

1. Panel iskeleti ve temiz masaüstü görünüm.
2. Dashboard.
3. Aktif işletme seçimi.
4. İşletmelerim.
5. Hizmetler.
6. Çalışanlar.
7. Çalışma saatleri.
8. Randevular.
9. Web sitesi yönetimi.
10. Ayarlar.
11. Paket / abonelik filtreleri.
12. Web tarafı tasarımı.

## Net Sonuç

Yeni projede önce panel ürün gibi tamamlanmalı. Paneldeki her sayfa sade, anlaşılır ve gerçek iş akışına uygun olmalı.

Benim önerim premium özelliklerin tamamını önce panelde kurmak. Ücretsiz ve standart paketleri sonradan bu tam panel üzerinden filtrelemek daha doğru olur. Böylece sistem eksik tasarlanmaz, sadece paketlere göre kontrollü şekilde sınırlandırılır.
