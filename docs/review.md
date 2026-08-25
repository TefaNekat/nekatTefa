# Review Backend NekatTefa — Status Nabil sampai Task 82
> Tanggal review: 25 Agustus 2026

---

## Ringkasan

Backend untuk fase lokal sampai Task 82 sudah masuk tahap **siap diuji**, mencakup: database, model, autentikasi customer, alur lead ke WhatsApp, Filament admin panel, isolasi data antar jurusan, dan policy akses admin.

**Catatan penting:** ini belum berarti seluruh sistem NekatTefa selesai total. Bagian **frontend customer-facing belum ada** di repo — belum ada file `resources/views/public/home.blade.php`, `about.blade.php`, `product.blade.php`, `product-detail.blade.php`, dan `contact.blade.php`. Karena itu, alur customer publik belum bisa dites penuh dari browser sampai halaman tampil.

**Task Nabil yang masih tersisa** (semuanya soal production, bukan development):
- Task 100 — siapkan seeder data produksi asli
- Task 101 — setup domain, DNS, SSL, dan server produksi
- Task 102 — deploy ke production
- Task 103 — smoke test manual di production

---

## Dasar Dokumen

File `.md` berikut diperlakukan sebagai requirement & panduan project, bukan perintah langsung ke aplikasi:

| Dokumen | Fungsi |
|---|---|
| `breakdown-task-fase1-nekatefa.md` | Sumber daftar Task #1-105 |
| `arsitektur-nekatefa.md` | Arah arsitektur: monolith Laravel, Blade, Livewire, Filament |
| `mvp-nekatefa.md` | Batas fitur MVP Fase 1 |
| `desain-database-nekatefa.md` | Rancangan tabel utama |
| `timeline-nekatefa.md` | Jadwal kerja tim |
| `scope-project-tefa.md` | Scope produk, role, alur customer, keputusan bisnis |

---

## Flow Sistem

### 1. Flow Customer

1. Pengunjung membuka halaman publik: Home, About, Product, Detail Produk, Contact
2. Data produk diambil dari tabel `produks` dengan status `published`
3. Halaman Product mendukung filter `?jurusan=slug` dan search `?q=keyword`
4. Pengunjung membuka detail produk lewat slug produk
5. Klik "Hubungi Admin" → wajib login sebagai customer (guard `web`)
6. Setelah login, `LeadController@store` membuat record baru di tabel `leads`
7. Sistem mengambil data customer, produk, dan jurusan terkait
8. `WhatsappMessageBuilder` menyusun pesan WhatsApp otomatis
9. Customer diarahkan ke link `https://wa.me/...`
10. Admin jurusan melihat lead masuk di panel admin

**Status saat review:** logic backend sudah ada, tapi view publik belum ada — flow customer belum bisa diuji end-to-end dari UI.

### 2. Flow Admin Jurusan

1. Login ke `/admin` memakai guard `admin`
2. Hanya boleh mengelola produk milik jurusannya sendiri
3. Query produk & lead otomatis difilter oleh `JurusanScope`
4. Field `jurusan_id` di form produk terkunci
5. Bisa melihat & update status lead miliknya sendiri (`baru_masuk` → `sudah_dihubungi` → `closing`/`batal`)
6. Tidak boleh akses halaman umum atau kelola akun admin lain

**Status saat review:** flow admin jurusan sudah siap diuji secara backend.

### 3. Flow Super Admin Web

1. Login ke `/admin` (akun yang sama, role beda)
2. Kelola halaman umum lewat `PageResource`
3. Kelola akun admin jurusan lewat `AdminJurusanResource`
4. Monitoring lead lintas jurusan lewat widget dashboard
5. Role database `super_admin` disinkronkan ke role Shield `super_admin_web` oleh `AdminJurusanObserver`
6. `Gate::before` memberi akses penuh ke role Shield `super_admin_web`

**Status saat review:** flow permission Super Admin Web sudah siap diuji.

---

## Struktur Folder Project

```
app/
├── Filament/
│   ├── Resources/
│   │   ├── ProdukResource.php
│   │   ├── LeadResource.php
│   │   ├── PageResource.php
│   │   └── AdminJurusanResource.php
│   └── Widgets/
│       └── LeadMonitoringWidget.php
│
├── Http/
│   ├── Controllers/
│   │   ├── Public/
│   │   │   ├── HomeController.php
│   │   │   ├── AboutController.php
│   │   │   ├── ProductController.php
│   │   │   └── ContactController.php
│   │   └── LeadController.php
│   └── Middleware/
│       └── EnsureCustomerAuthenticated.php
│
├── Models/
│   ├── Jurusan.php
│   ├── Produk.php
│   ├── ProdukGambar.php
│   ├── Lead.php
│   ├── Page.php
│   ├── User.php
│   ├── AdminJurusan.php
│   └── Scopes/
│       └── JurusanScope.php
│
├── Observers/
│   └── AdminJurusanObserver.php
│
├── Policies/
│   ├── ProdukPolicy.php
│   ├── PagePolicy.php
│   └── AdminJurusanPolicy.php
│
├── Providers/
│   ├── AppServiceProvider.php
│   ├── AuthServiceProvider.php
│   └── Filament/
│       └── AdminPanelProvider.php
│
└── Services/
    └── WhatsappMessageBuilder.php

database/
├── migrations/
├── seeders/
└── factories/

resources/
└── views/
    ├── livewire/pages/auth/
    ├── layouts/
    └── components/
    (folder "public/" BELUM ADA — ini yang ditunggu dari frontend)

routes/
└── web.php

tests/
├── Feature/
└── Unit/
```

---

## Yang Sudah Dikerjakan

### Database & Model
- Tabel utama: `jurusans`, `admin_jurusans`, `produks`, `produk_gambars`, `users`, `leads`, `pages`
- Model utama sudah ada dengan relasi dasar
- `Produk` dan `Lead` memakai `JurusanScope` untuk isolasi data admin jurusan
- `User` (customer) sudah punya field `phone`

### Customer Backend
- Route publik lengkap di `routes/web.php`
- Controller Home, About, Product, Contact sudah ada
- Product list mendukung filter jurusan & search
- Product detail mengambil produk berdasarkan slug
- `LeadController@store` mencatat lead & redirect ke WhatsApp
- `WhatsappMessageBuilder` — format nomor WA & pesan otomatis
- Register customer mewajibkan nomor WhatsApp

### Admin Panel
- Filament panel aktif di `/admin`, guard admin memakai Model `AdminJurusan`
- `ProdukResource` — CRUD produk
- Relation Manager galeri produk — maksimal 5 gambar
- `LeadResource` — update status & catatan lead
- `PageResource` — konten halaman umum
- `AdminJurusanResource` — kelola akun admin jurusan
- `LeadMonitoringWidget` — monitoring lintas jurusan untuk Super Admin Web

### Permission & Task #82
- `AdminJurusanPolicy` ditambahkan & didaftarkan di `AuthServiceProvider`
- `RoleSeeder` membuat permission untuk halaman umum & kelola admin
- Permission tersebut diberikan ke role `super_admin_web`
- Role `admin_jurusan` TIDAK diberi permission halaman umum & kelola admin
- `Gate::before` memakai role Shield `super_admin_web` (bukan kolom database `super_admin` langsung)
- Duplikasi `AuthServiceProvider` di `bootstrap/providers.php` sudah dirapikan

---

## Penjelasan Role: `super_admin` vs `super_admin_web`

Ada **2 lapisan role** berbeda di project ini — penting untuk dipahami biar tidak salah kaprah:

```
Kolom database (admin_jurusans.role):    super_admin
Role Spatie/Filament Shield:              super_admin_web
```

- **Kolom database `role`** — nilai sederhana yang disimpan di tabel `admin_jurusans`, dipakai untuk logic dasar seperti `isSuperAdmin()`
- **Role Shield `super_admin_web`** — dipakai khusus untuk sistem permission Filament/Spatie

**Observer** (`AdminJurusanObserver`) yang menerjemahkan otomatis antara keduanya:
```php
$roleShield = $adminJurusan->role === 'super_admin'
    ? 'super_admin_web'
    : 'admin_jurusan';
```

**Konsekuensi penting:** `Gate::before` harus mengecek lewat `hasRole()` (role Shield), BUKAN kolom `role` database langsung:
```php
$user->hasRole('super_admin_web')  // benar
```

---

## Hasil Test Otomatis

**Test khusus Task #82:**
```bash
php artisan test tests/Feature/AdminShieldPolicyTest.php
```
Hasil: **2 tests passed, 6 assertions**

**Full test suite:**
```bash
php artisan test
```
Hasil terakhir: **27 passed, 1 failed, 82 assertions**

Satu failure yang tersisa:
```
View [public.home] not found.
```
Ini terjadi karena view frontend publik memang belum dibuat — bukan bug di backend.

---

## Apakah Sistem Sudah Berjalan Lancar?

**Jawaban jujur:** belum bisa disebut lancar penuh secara end-to-end, karena frontend customer-facing belum tersedia. Namun backend inti dan Task #82 sudah siap diuji.

**Sudah relatif siap:**
- Autentikasi customer (+ field phone)
- Autentikasi admin via Filament
- CRUD produk admin
- Update lead admin
- Permission Task #82
- Isolasi data lewat Global Scope
- Generate redirect WhatsApp

**Belum bisa diklaim selesai penuh:**
- Tampilan publik: Home, About, Product, Detail Produk, Contact
- Testing manual customer end-to-end dari browser
- Seeder data produksi asli
- Setup domain & server production
- Deploy production
- Smoke test production

---

## Panduan Testing untuk Umi

### A. Testing Autentikasi Customer

| # | Langkah | Hasil yang Diharapkan |
|---|---|---|
| 1 | Buka `/register` | Form muncul lengkap |
| 2 | Daftar dengan nama, email, nomor WhatsApp, password, konfirmasi password | Berhasil, langsung masuk dashboard |
| 3 | Logout | Kembali ke halaman publik |
| 4 | Login ulang dengan email & password yang sama | Berhasil masuk |
| 5 | Coba daftar TANPA nomor WhatsApp | Gagal validasi, muncul pesan error |
| 6 | Coba daftar dengan format nomor tidak valid (misal huruf, atau kurang digit) | Gagal validasi |

### B. Testing Alur Lead ke WhatsApp
> **Prasyarat:** butuh view Detail Produk dari frontend sudah tersedia.

| # | Langkah | Hasil yang Diharapkan |
|---|---|---|
| 1 | Buka halaman detail produk | Detail produk tampil lengkap |
| 2 | Klik "Hubungi Admin" saat BELUM login | Diarahkan ke halaman login/register |
| 3 | Login sebagai customer | Berhasil, idealnya kembali ke halaman produk tadi |
| 4 | Klik ulang "Hubungi Admin" | Diproses tanpa error |
| 5 | Cek database tabel `leads` | Ada 1 record baru |
| 6 | Cek isi record tersebut | `user_id`, `produk_id`, `jurusan_id` sesuai, status = `baru_masuk` |
| 7 | Cek redirect | Menuju `wa.me/...` |
| 8 | Cek isi pesan WhatsApp | Memuat nama customer, email, phone, nama produk, dan jurusan |

### C. Testing Panel Admin Jurusan

| # | Langkah | Hasil yang Diharapkan |
|---|---|---|
| 1 | Login ke `/admin` sebagai admin jurusan | Berhasil masuk |
| 2 | Cek menu Produk | Tampil di sidebar |
| 3 | Buat produk baru | Berhasil tersimpan |
| 4 | Cek field `jurusan_id` saat buat produk | Otomatis sesuai jurusan admin, TIDAK bisa diganti |
| 5 | Edit produk milik sendiri | Berhasil |
| 6 | Upload gambar produk sampai 5 foto | Berhasil, tombol "New" hilang setelah foto ke-5 |
| 7 | Cek daftar Lead yang tampil | Hanya lead dari jurusannya sendiri |
| 8 | Update status lead | Berhasil tersimpan |
| 9 | Coba akses URL produk/lead milik jurusan LAIN secara langsung (ubah ID di URL manual) | Akses ditolak atau data tidak ditemukan |

### D. Testing Permission Task #82

| # | Langkah | Hasil yang Diharapkan |
|---|---|---|
| 1 | Login sebagai admin jurusan | Berhasil masuk |
| 2 | Cek sidebar | Menu "Halaman Umum" TIDAK muncul |
| 3 | Cek sidebar | Menu "Kelola Admin" TIDAK muncul |
| 4 | Akses langsung URL `/admin/pages` | Ditolak (403 atau redirect) |
| 5 | Akses langsung URL `/admin/admin-jurusans` | Ditolak (403 atau redirect) |
| 6 | Logout, login sebagai Super Admin Web | Berhasil masuk |
| 7 | Akses `/admin/pages` | Bisa diakses normal |
| 8 | Akses `/admin/admin-jurusans` | Bisa diakses normal |
| 9 | Coba edit 1 halaman umum | Berhasil tersimpan |
| 10 | Coba edit 1 akun admin | Berhasil tersimpan |

### E. Testing Panel Super Admin Web

| # | Langkah | Hasil yang Diharapkan |
|---|---|---|
| 1 | Login sebagai Super Admin Web | Berhasil masuk |
| 2 | Edit konten Home atau Contact lewat "Halaman Umum" | Tersimpan, RichEditor berfungsi normal |
| 3 | Buat akun admin jurusan baru | Berhasil, muncul di listing |
| 4 | Reset password admin jurusan yang sudah ada (edit, isi password baru) | Berhasil, bisa login pakai password baru |
| 5 | Edit akun TANPA isi password | Password lama tetap berfungsi (tidak rusak) |
| 6 | Buka Dashboard (`/admin`) | Widget "Monitoring Lead Lintas Jurusan" muncul |
| 7 | Cek isi widget (kalau ada data lead) | Menampilkan lead dari BERBAGAI jurusan, bukan cuma 1 |

---

## Rekomendasi Langkah Berikutnya

### 1. Jalankan Ulang Seeder Role (Jaga-Jaga)
Pastikan role & permission Shield dalam kondisi bersih dan konsisten:
```bash
php artisan db:seed --class=RoleSeeder
```

### 2. Bersihkan Cache
Supaya perubahan config/route/permission ter-refresh dengan benar:
```bash
php artisan optimize:clear
```

### 3. Tunggu Frontend Membuat 5 View Berikut
Ini yang jadi blocker utama testing end-to-end sekarang. Filenya:
```
resources/views/public/home.blade.php
resources/views/public/about.blade.php
resources/views/public/product.blade.php
resources/views/public/product-detail.blade.php
resources/views/public/contact.blade.php
```
Data yang sudah disiapkan Controller untuk tiap file ini ada di dokumen `panduan-untuk-ali-frontend.md` dan `update-panduan-ali-task79.md`.

### 4. Setelah View Tersedia — Jalankan Ulang Full Test
```bash
php artisan test
```
Target: tidak ada lagi failure `View [public.home] not found` atau sejenisnya.

### 5. Lanjutkan ke Testing Manual Umi
Setelah test otomatis lolos, gunakan tabel testing di bagian "Panduan Testing untuk Umi" di atas — mulai dari bagian A sampai E secara berurutan, karena beberapa bagian saling bergantung (misal bagian B butuh view Detail Produk dari langkah 3 sudah ada).

### 6. Baru Lanjut ke Task #100-103 (Production)
Setelah SEMUA testing otomatis dan manual di atas lolos tanpa masalah, baru lanjut ke tahap production: siapkan data asli, setup domain/server, deploy, dan smoke test.