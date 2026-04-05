# Smart Appointment SaaS Platform  
## CodeIgniter 4 + PHP ile Adım Adım Geliştirme Planı

Bu doküman, **çoklu işletme destekli Akıllı Randevu Sistemi** projesini **PHP + CodeIgniter 4** ile geliştirirken adım adım nasıl ilerlemen gerektiğini anlatır.

---

# 1. Proje Özeti

## Proje Adı
**Smart Appointment SaaS Platform**

## Proje Amacı
Bir platform üzerinden:
- işletmeler sisteme kayıt olacak
- kendi panelini yönetecek
- kullanıcılar tek hesapla farklı işletmelerden randevu alabilecek
- sistem uygun slotları akıllı şekilde gösterecek

## Sistem Yapısı
Uygulama iki ana bölümden oluşacak:

### Public taraf
- ana sayfa
- işletme listesi
- işletme detay sayfası
- kayıt / giriş
- randevu alma
- kullanıcının randevuları

### Dashboard tarafı
- işletme paneli
- hizmet yönetimi
- çalışan yönetimi
- çalışma saatleri
- randevu yönetimi
- ayarlar
- temel istatistikler

---

# 2. Temel Sistem Kararları

Projeye başlamadan önce net olan kararlar:

- proje **SaaS mantığında** olacak
- birden fazla işletme sisteme kayıt olabilecek
- kullanıcı tarafında **tek hesap sistemi** olacak
- kullanıcı aynı hesapla farklı işletmelerden randevu alabilecek
- işletmeler sadece kendi verilerini görebilecek
- sistemde **slot üretme ve çakışma kontrolü** olacak
- ilk sürümde gereksiz özellik eklenmeyecek

---

# 3. Kullanıcı Rolleri

## 3.1 Normal Kullanıcı
Şunları yapabilir:
- kayıt olur
- giriş yapar
- işletmeleri görüntüler
- işletme detaylarını inceler
- randevu alır
- kendi randevularını görür
- randevu iptal eder

## 3.2 İşletme Sahibi / Admin
Şunları yapabilir:
- işletme oluşturur
- paneline giriş yapar
- hizmet ekler / düzenler / siler
- çalışan ekler / düzenler / siler
- çalışma saatlerini belirler
- randevuları yönetir
- temel yoğunluk verilerini görür

---

# 4. Geliştirme Stratejisi

Bu projeyi tek seferde komple yapmaya çalışma.

Doğru yöntem:
1. önce proje iskeleti
2. sonra veritabanı
3. sonra auth
4. sonra dashboard CRUD yapıları
5. sonra public taraf
6. sonra randevu algoritması
7. sonra akıllı sistem geliştirmeleri
8. sonra test ve deploy

---

# 5. Teknoloji Kararları

## Backend
- PHP
- CodeIgniter 4

## Veritabanı
- MySQL veya PostgreSQL  
Başlangıç için **MySQL** ile ilerlemek daha kolay olabilir.

## Frontend
- CI4 View sistemi
- Bootstrap / Tailwind / hazır tema  
Eğer hazır tema kullanacaksan önce onun HTML yapısını CI4 view yapısına böl.

## Diğer
- Session tabanlı auth ile başlanabilir
- Daha sonra ihtiyaç olursa role/permission genişletilebilir

---

# 6. Önerilen Klasör Organizasyonu

CI4 içinde düzenli gitmek için mantıklı yapı:

```text
app/
 ├── Controllers/
 │    ├── Auth/
 │    ├── Public/
 │    ├── Dashboard/
 │    └── Api/   (ileride gerekirse)
 │
 ├── Models/
 │
 ├── Views/
 │    ├── layouts/
 │    ├── public/
 │    ├── auth/
 │    └── dashboard/
 │
 ├── Filters/
 ├── Libraries/
 └── Helpers/
```

## Açıklama
- `Controllers/Auth` → giriş, kayıt, çıkış
- `Controllers/Public` → ana sayfa, işletmeler, randevu alma
- `Controllers/Dashboard` → panel
- `Views/layouts` → header, footer, sidebar, main layout
- `Libraries` → slot üretme gibi özel iş mantıkları
- `Filters` → auth ve role kontrolü

---

# 7. Geliştirme Aşamaları

---

# Aşama 1 — Proje Kurulumu

## Yapılacaklar
- yeni bir CI4 projesi oluştur
- `.env` dosyasını aktif hale getir
- baseURL ayarla
- veritabanı bağlantısını yap
- hazır tema kullanacaksan projeye entegre et
- ortak layout dosyalarını ayır

## Bu aşamada oluşturulacak yapılar
- ana layout
- dashboard layout
- public layout
- header / footer / sidebar partial dosyaları

## Hedef
Uygulamanın temel iskeleti ayağa kalksın.

---

# Aşama 2 — Veritabanı Planlaması

Önce tablo yapısını netleştir, sonra migration yaz.

## Temel tablolar
- users
- businesses
- business_users
- services
- employees
- employee_services
- availabilities
- appointments

## Tabloların mantığı

### users
Platformdaki tüm kullanıcılar

Alan örneği:
- id
- full_name
- email
- password
- role
- created_at
- updated_at

### businesses
Sistemdeki işletmeler

Alan örneği:
- id
- owner_user_id
- name
- slug
- description
- phone
- email
- address
- logo
- created_at
- updated_at

### business_users
İleride bir işletmeye birden fazla admin bağlamak için ara tablo

Alan örneği:
- id
- business_id
- user_id
- role

### services
İşletmenin sunduğu hizmetler

Alan örneği:
- id
- business_id
- name
- duration
- price
- description
- status

### employees
Çalışanlar

Alan örneği:
- id
- business_id
- full_name
- email
- phone
- status

### employee_services
Hangi çalışan hangi hizmeti verebilir

Alan örneği:
- id
- employee_id
- service_id

### availabilities
Çalışanların çalışma saatleri

Alan örneği:
- id
- business_id
- employee_id
- day_of_week
- start_time
- end_time
- is_active

### appointments
Randevular

Alan örneği:
- id
- business_id
- user_id
- service_id
- employee_id
- appointment_date
- start_time
- end_time
- status
- notes
- created_at
- updated_at

## Hedef
Veritabanı ilişkileri oturmuş olsun.

---

# Aşama 3 — Migration ve Seeder

## Yapılacaklar
- her tablo için migration oluştur
- test verileri için seed yaz
- örnek kullanıcı
- örnek işletme
- örnek hizmet
- örnek çalışan

## Hedef
Sistem test edilebilir hale gelsin.

---

# Aşama 4 — Authentication Sistemi

## Yapılacaklar
- register sayfası
- login sayfası
- logout işlemi
- session kontrolü
- role kontrolü

## Public kullanıcı auth
- kullanıcı kayıt olur
- giriş yapar
- randevu almak için oturum açmış olmalıdır

## İşletme sahibi auth
Burada iki yöntem var:

### Yöntem 1
Tek kayıt sistemi, kullanıcı sonradan işletme oluşturur

### Yöntem 2
Ayrı işletme kayıt ekranı

Bu proje için en mantıklısı:
**tek kullanıcı hesabı + sonradan işletme oluşturma**

## Hedef
Kullanıcı ve işletme sahibi oturum sistemi çalışsın.

---

# Aşama 5 — Filter Yapısı

CI4 içinde filter kullan.

## Oluşturulacak filterlar
- AuthFilter
- GuestFilter
- BusinessOwnerFilter

## Görevleri
- giriş yapmayan kullanıcıyı korumalı sayfalardan engellemek
- giriş yapan kullanıcıyı login/register sayfalarından uzak tutmak
- dashboard tarafına sadece ilgili rolü almak

## Hedef
Yetkilendirme düzenli olsun.

---

# Aşama 6 — Public Tarafın Oluşturulması

## Sayfalar
- ana sayfa
- işletmeler listesi
- işletme detay
- kayıt / giriş
- randevu alma
- benim randevularım

## Yapılacaklar

### Ana sayfa
- platform tanıtımı
- öne çıkan işletmeler
- çağrı butonları

### İşletmeler listesi
- tüm aktif işletmeler
- arama / filtre ileride eklenebilir

### İşletme detay sayfası
- işletme adı
- açıklama
- hizmet listesi
- çalışan listesi
- çalışma bilgileri
- randevu al butonu

### Randevu akışı
- kullanıcı işletmeyi seçer
- hizmet seçer
- çalışan seçer veya sistem önerir
- tarih seçer
- uygun saatleri görür
- randevu oluşturur

## Hedef
Kullanıcının public tarafta tüm temel işlemleri yapabilmesi.

---

# Aşama 7 — Dashboard Temel Yapısı

## Sayfalar
- dashboard home
- services
- employees
- availabilities
- appointments
- settings

## Dashboard ana sayfa
- toplam randevu
- bugünkü randevular
- aktif çalışan sayısı
- hizmet sayısı

## Hedef
İşletme panelinin iskeleti hazır olsun.

---

# Aşama 8 — Hizmet Yönetimi

## Yapılacaklar
- hizmet listeleme
- hizmet ekleme
- hizmet düzenleme
- hizmet silme
- aktif/pasif yapma

## Dikkat
Her hizmet mutlaka ilgili `business_id` ile kayıt edilmeli.

## Hedef
İşletme kendi hizmetlerini yönetebilsin.

---

# Aşama 9 — Çalışan Yönetimi

## Yapılacaklar
- çalışan listeleme
- çalışan ekleme
- çalışan düzenleme
- çalışan silme
- çalışana hizmet bağlama

## Hedef
Her işletme kendi çalışanlarını yönetebilsin.

---

# Aşama 10 — Çalışma Saatleri / Müsaitlik Yapısı

Bu proje için en kritik modüllerden biri.

## Yapılacaklar
- çalışan bazlı müsaitlik girişi
- haftanın günlerine göre çalışma saatleri
- aktif / pasif kontrolü

## Örnek
Pazartesi:
- 09:00 - 18:00

Salı:
- 10:00 - 17:00

## Hedef
Sistemin slot üretmesi için temel veri oluşsun.

---

# Aşama 11 — Randevu Algoritmasının Temeli

Bu kısmı ayrı bir servis veya library mantığında yazman daha temiz olur.

Örneğin:
- `app/Libraries/AppointmentService.php`
- `app/Libraries/SlotService.php`

## Slot üretme mantığı
Sistem şu verilere bakacak:
- işletme
- seçilen hizmet
- seçilen çalışan
- hizmet süresi
- çalışanın müsaitliği
- mevcut randevular

## Kurallar
- geçmiş saatler görünmez
- dolu saatler görünmez
- hizmet süresine yetmeyen saatler görünmez
- çalışan aynı saatte iki randevu alamaz
- saatler belirli aralıklarla üretilir

## Örnek
Hizmet süresi: 30 dakika  
Çalışma aralığı: 09:00 - 12:00

Üretilen slotlar:
- 09:00
- 09:30
- 10:00
- 10:30
- 11:00
- 11:30

Ama eğer 10:00 doluysa:
- 10:00 slotu kaldırılır

## Hedef
Randevu sisteminin çekirdeği çalışsın.

---

# Aşama 12 — Randevu Oluşturma

## Yapılacaklar
- randevu formu
- backend validasyonu
- slot kontrolü
- çakışma kontrolü
- randevu kaydı

## Validasyonlar
- kullanıcı giriş yapmış mı
- işletme aktif mi
- hizmet aktif mi
- çalışan aktif mi
- seçilen tarih geçerli mi
- slot gerçekten müsait mi

## Hedef
Kullanıcı başarılı şekilde randevu oluşturabilsin.

---

# Aşama 13 — Benim Randevularım

## Yapılacaklar
- kullanıcının geçmiş ve yaklaşan randevularını listeleme
- işletme adıyla birlikte gösterme
- durum bilgisi
- iptal etme

## Görünecek bilgiler
- işletme adı
- hizmet adı
- çalışan adı
- tarih
- saat
- durum

## Hedef
Kullanıcı kendi randevularını yönetebilsin.

---

# Aşama 14 — İşletme Randevu Yönetimi

## Yapılacaklar
- gelen randevuları listeleme
- durum filtreleme
- onaylandı / bekliyor / iptal edildi gibi durumlar
- randevu detayını görüntüleme

## Hedef
İşletme sahibi panelden randevuları yönetebilsin.

---

# Aşama 15 — Akıllı Özellikler

Bu aşama projeni sıradanlıktan çıkaracak.

## Eklenebilecek akıllı yapılar

### 1. En yakın uygun saat önerisi
Kullanıcı tarih seçtiğinde en yakın boş saatleri öne çıkar.

### 2. En uygun çalışan önerisi
Kullanıcı çalışan seçmemişse uygun çalışanları getir.

### 3. Yoğunluk analizi
Dashboard tarafında:
- en yoğun gün
- en çok tercih edilen hizmet
- en yoğun çalışan

### 4. Verimsiz boşlukları azaltma
Slot önerirken saatleri optimize etme mantığı daha sonra eklenebilir.

## Hedef
Sistemin “akıllı” kısmı görünür hale gelsin.

---

# Aşama 16 — Ayarlar Modülü

## Yapılacaklar
- işletme bilgileri güncelleme
- logo
- açıklama
- iletişim bilgileri
- adres
- belki çalışma politikası

## Hedef
İşletme kendi profilini yönetebilsin.

---

# Aşama 17 — Route Planı

CI4 içinde route yapısını baştan düzenli kur.

## Örnek route grupları

### Public
- `/`
- `/businesses`
- `/businesses/{slug}`
- `/book/{slug}`
- `/my-appointments`

### Auth
- `/login`
- `/register`
- `/logout`

### Dashboard
- `/dashboard`
- `/dashboard/services`
- `/dashboard/employees`
- `/dashboard/availabilities`
- `/dashboard/appointments`
- `/dashboard/settings`

## Hedef
Route karmaşasını baştan önlemek.

---

# Aşama 18 — Controller Planı

## Public Controllers
- HomeController
- BusinessController
- BookingController
- AppointmentController

## Auth Controllers
- LoginController
- RegisterController
- LogoutController

## Dashboard Controllers
- DashboardController
- ServiceController
- EmployeeController
- AvailabilityController
- BusinessAppointmentController
- SettingsController

## Hedef
Controller sorumlulukları net olsun.

---

# Aşama 19 — Model Planı

## Oluşturulacak modeller
- UserModel
- BusinessModel
- BusinessUserModel
- ServiceModel
- EmployeeModel
- EmployeeServiceModel
- AvailabilityModel
- AppointmentModel

## Hedef
Her tablo için düzenli model yapısı oluşturmak.

---

# Aşama 20 — View Planı

## Public view yapısı
```text
Views/public/
 ├── home/
 ├── businesses/
 ├── booking/
 ├── appointments/
```

## Dashboard view yapısı
```text
Views/dashboard/
 ├── home/
 ├── services/
 ├── employees/
 ├── availabilities/
 ├── appointments/
 └── settings/
```

## Auth view yapısı
```text
Views/auth/
 ├── login.php
 └── register.php
```

## Layouts
```text
Views/layouts/
 ├── public.php
 ├── dashboard.php
 ├── header.php
 ├── footer.php
 └── sidebar.php
```

## Hedef
Görsel yapı düzenli olsun.

---

# Aşama 21 — Test Sırası

Her modülü yaptıktan sonra test et.

## Test sırası
1. auth çalışıyor mu
2. işletme oluşturma çalışıyor mu
3. hizmet CRUD çalışıyor mu
4. çalışan CRUD çalışıyor mu
5. müsaitlik kaydı çalışıyor mu
6. slotlar doğru üretiliyor mu
7. randevu oluşturuluyor mu
8. çakışma engelleniyor mu
9. kullanıcı kendi randevularını görüyor mu
10. işletme sadece kendi verisini görüyor mu

## Hedef
Sorunları erken yakalamak.

---

# Aşama 22 — İlk Versiyonda Yapılmayacaklar

Bunları en başta ekleme:

- online ödeme
- SMS sistemi
- e-posta bildirim sistemi
- kupon sistemi
- yorum sistemi
- çoklu dil desteği
- subdomain desteği
- gelişmiş raporlama

Bu özellikler ikinci aşamada eklenebilir.

---

# Aşama 23 — GitHub ve Sunum İçin Hazırlık

## GitHub'da olması gerekenler
- temiz README
- proje açıklaması
- kurulum adımları
- ekran görüntüleri
- veritabanı şeması özeti
- özellik listesi

## README içinde yer alabilecek başlıklar
- Project Overview
- Features
- Tech Stack
- Installation
- Database Structure
- Future Improvements

## Hedef
Projeyi profesyonel göstermek.

---

# Aşama 24 — Geliştirme Sırası Özet Checklist

## Kurulum
- [ ] CI4 projesini kur
- [ ] veritabanını bağla
- [ ] tema yapısını yerleştir
- [ ] layout sistemini ayır

## Veritabanı
- [ ] migration planı hazırla
- [ ] tabloları oluştur
- [ ] seeder yaz

## Auth
- [ ] register
- [ ] login
- [ ] logout
- [ ] session kontrolü
- [ ] filter yapısı

## Dashboard
- [ ] dashboard ana sayfa
- [ ] hizmet yönetimi
- [ ] çalışan yönetimi
- [ ] müsaitlik yönetimi
- [ ] randevu yönetimi
- [ ] ayarlar

## Public
- [ ] ana sayfa
- [ ] işletme listesi
- [ ] işletme detay
- [ ] randevu alma
- [ ] benim randevularım

## Akıllı sistem
- [ ] slot üretimi
- [ ] çakışma kontrolü
- [ ] uygun saat önerisi
- [ ] temel yoğunluk analizi

## Son
- [ ] responsive kontrol
- [ ] hata mesajları
- [ ] validasyonlar
- [ ] README
- [ ] deploy

---

# 25. Sana En Doğru Çalışma Düzeni

Her şeyi aynı anda yapma.

Doğru sıra şöyle:

1. iskelet
2. migration
3. auth
4. dashboard CRUD
5. public sayfalar
6. booking algoritması
7. kullanıcı randevuları
8. akıllı özellikler
9. son düzenlemeler

---

# 26. Son Not

Bu projede seni güçlü gösterecek şey:
- çok sayıda özellik değil
- düzenli mimari
- temiz veritabanı
- doğru auth
- çalışan slot sistemi
- çakışma kontrolü
- kullanıcı deneyimi

Yani hedefin:
**“bitmiş, çalışan, temiz bir sistem”** olsun.

Eksik ama dağınık büyük proje yerine,  
daha sade ama düzenli ve çalışan proje çok daha değerlidir.
