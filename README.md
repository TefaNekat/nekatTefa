# nekatefa.com

Website profil & katalog produk untuk **TEFA Katapang** — Teaching Factory yang menaungi 7 jurusan sebagai unit usaha semi-mandiri. Situs ini menampilkan produk dari tiap jurusan dan mengarahkan pengunjung yang berminat ke WhatsApp admin jurusan terkait untuk closing manual.

> **Ini bukan e-commerce checkout.** Tidak ada payment gateway. Alur transaksi berhenti di titik "Hubungi Admin" — negosiasi, konfirmasi, dan pembayaran dilakukan manual lewat WhatsApp.

---

## Daftar Isi

- [Konteks](#konteks)
- [Fitur (Fase 1 / MVP)](#fitur-fase-1--mvp)
- [Tech Stack](#tech-stack)
- [Arsitektur](#arsitektur)
- [Skema Database](#skema-database)
- [Role & Akses](#role--akses)
- [Struktur Folder](#struktur-folder)
- [Instalasi](#instalasi)
- [Tim](#tim)
- [Roadmap (Fase 2)](#roadmap-fase-2)
- [Dokumentasi Lengkap](#dokumentasi-lengkap)

---

## Konteks

TEFA Katapang menaungi 7 jurusan yang masing-masing memproduksi barang setara kualitas industri. `nekatefa.com` menjadi etalase terpusat untuk seluruh produk tersebut, dengan tujuan:

- Memberi kredibilitas produk lewat deskripsi, harga, dan galeri foto yang lengkap.
- Menyalurkan minat pembeli langsung ke admin jurusan terkait via WhatsApp.
- Mencatat setiap minat (lead) secara otomatis agar admin jurusan bisa follow up dan tracking.

Domain **nekatefa.com** berasal dari singkatan "web tefa nekat".

## Fitur (Fase 1 / MVP)

**Customer-facing**
- **Home** — pengantar TEFA Katapang & daftar jurusan
- **About** — profil tiap jurusan + CTA "Lihat Produk" (redirect ke Product terfilter)
- **Product** — katalog produk terpusat semua jurusan, dengan filter jurusan & pencarian keyword
- **Detail Produk** — deskripsi lengkap, galeri 2-5 foto, tombol **"Hubungi Admin"**
- **Contact** — kontak resmi institusi (email TEFA Katapang)
- **Login/daftar akun customer** (nama, email, telepon) — wajib sebelum klik "Hubungi Admin", dipakai untuk auto-fill pesan WhatsApp dan pencatatan lead otomatis

**Panel Admin Jurusan** (7 akun, satu per jurusan)
- CRUD produk (nama, deskripsi, harga) + galeri gambar
- Lihat daftar lead masuk (nama, email, telepon, produk, waktu)
- Update status lead manual: `Baru Masuk → Sudah Dihubungi → Closing → Batal`
- Akses terisolasi — hanya bisa melihat/mengelola data jurusan sendiri

**Panel Super Admin Web**
- Dipegang staf TEFA (bukan developer)
- Kelola halaman umum: Home, About, Contact
- Kelola 7 akun Admin Jurusan
- Monitoring ringan lintas jurusan (lihat semua lead)
- Tidak ada approval produk — begitu admin jurusan publish, langsung live
- **Tidak** mencakup akses infrastruktur (server, hosting, domain, DB) — itu domain Super Admin Server (developer), murni di luar aplikasi

Detail lengkap ada di [`mvp-nekatefa.md`](./mvp-nekatefa.md) dan [`scope-project-tefa.md`](./scope-project-tefa.md).

## Tech Stack

| Layer | Teknologi |
|---|---|
| Framework | Laravel 12 |
| Admin Panel | Filament 3.x + Filament Shield |
| Interaktivitas Frontend | Livewire |
| Templating | Blade |
| Styling | Tailwind CSS |
| Database | MySQL |
| Role & Permission | Spatie Permission |
| Autentikasi Customer | Laravel Breeze |
| Storage Gambar | Laravel Storage (`Storage::disk('public')`) |

## Arsitektur

**Monolith Laravel** (Blade + Livewire), bukan API terpisah + SPA. Alasan utama: tim kecil (1 FE, 1 BE) dalam ~5 minggu, dan situs ini pada dasarnya adalah profil + katalog + CRUD admin — bukan aplikasi real-time yang benar-benar butuh SPA. Dengan satu bahasa (PHP + Blade), anggota tim bisa saling backup lintas peran.

Keputusan arsitektur kunci:
- **Global Scope** Laravel untuk isolasi data antar jurusan (bukan `WHERE jurusan_id = ...` manual di tiap controller)
- Satu panel Filament di `/admin`, permission berbasis role via **Filament Shield**
- Dua role terpisah: **Super Admin Web** (staf TEFA, di dalam aplikasi) dan **Super Admin Server** (developer, akses SSH/cPanel — tidak direpresentasikan sebagai akun di aplikasi)
- Service class terpusat `WhatsappMessageBuilder` untuk generate link `wa.me`
- Satu tombol CTA "Hubungi Admin" (bukan dual Tanya/Beli)

Detail lengkap di [`arsitektur-nekatefa.md`](./arsitektur-nekatefa.md).

## Skema Database

6 tabel inti:

```
jurusans ──< admin_jurusans
    │
    ├──< produks ──< produk_gambars
    │
    └──< leads >── users
```

- **`jurusans`** — 7 jurusan (nama, slug, deskripsi, nomor WA)
- **`admin_jurusans`** — akun admin per jurusan + role (`super_admin_web` / `admin_jurusan`)
- **`produks`** — produk per jurusan (nama, deskripsi, fungsi, manfaat, harga, status)
- **`produk_gambars`** — galeri 2-5 foto per produk
- **`users`** — akun customer (nama, email, telepon)
- **`leads`** — pencatatan otomatis klik "Hubungi Admin" (user + produk + jurusan + status + waktu)

Skema lengkap dan alasan desain ada di [`desain-database-nekatefa.md`](./desain-database-nekatefa.md).

## Role & Akses

| Role | Lokasi | Kewenangan |
|---|---|---|
| **Super Admin Web** | Di dalam aplikasi (`/admin`) | Kelola halaman umum, kelola akun admin jurusan, monitoring lead lintas jurusan |
| **Admin Jurusan** (×7) | Di dalam aplikasi (`/admin`) | CRUD produk & galeri, kelola lead — terbatas ke jurusan sendiri |
| **Super Admin Server** | Di luar aplikasi (SSH / cPanel / `php artisan tinker`) | Server, hosting, domain, DNS, database — tidak punya akun di sistem |

## Struktur Folder

```
app/
├── Models/          → Jurusan, Produk, ProdukGambar, User, Lead, AdminJurusan
├── Http/
│   ├── Controllers/
│   │   ├── Public/       → HomeController, AboutController, ProductController, ContactController
│   │   ├── Admin/        → ProdukController, LeadController (admin jurusan)
│   │   └── SuperAdminWeb/→ JurusanController, PageController, AdminController
│   ├── Livewire/     → ProductFilter, ProductSearch, LeadStatusUpdater, dll
│   └── Middleware/   → EnsureJurusanScope, EnsureAuthenticated
├── Policies/         → ProdukPolicy
resources/views/
├── public/           → home, about, product, product-detail, contact
├── admin/            → dashboard, produk, leads
└── layouts/          → shared layout, navbar, footer
```

## Instalasi

```bash
git clone <repo-url> nekatefa
cd nekatefa

composer install
npm install

cp .env.example .env
php artisan key:generate

# sesuaikan koneksi database di .env, lalu:
php artisan migrate --seed

npm run build
php artisan serve
```

> Laravel 12 tidak lagi memakai `Kernel.php` — middleware didaftarkan lewat `bootstrap/app.php` dan provider lewat `bootstrap/providers.php`.

## Tim

| Peran | Nama |
|---|---|
| Project Manager | Alghani |
| Analis | Rafi |
| Frontend | Ali |
| Backend | Nabil |
| Desain | Keyra |
| Tester | Umi |

Timeline pengerjaan (5 minggu) ada di [`timeline-nekatefa.md`](./timeline-nekatefa.md).

## Roadmap (Fase 2)

Fitur berikut sengaja ditunda agar Fase 1 tetap ramping:

- Riwayat pesanan customer + halaman status/tracking
- Logic "produk terlaris" otomatis di homepage (data lead sudah tersedia sejak Fase 1)
- Rekap lead lintas jurusan yang lebih detail untuk Super Admin Web
- Jam operasional respons per jurusan
- Galeri kegiatan/portofolio tambahan di halaman About
- Urutan pin manual untuk produk

## Dokumentasi Lengkap

| Dokumen | Isi |
|---|---|
| [`scope-project-tefa.md`](./scope-project-tefa.md) | Scope bisnis/produk — living document |
| [`mvp-nekatefa.md`](./mvp-nekatefa.md) | Breakdown fitur per fase |
| [`arsitektur-nekatefa.md`](./arsitektur-nekatefa.md) | Keputusan arsitektur & alasan |
| [`desain-database-nekatefa.md`](./desain-database-nekatefa.md) | Skema 6 tabel + rasional desain |
| [`timeline-nekatefa.md`](./timeline-nekatefa.md) | Jadwal harian 5 minggu per role |

---

*Proyek internal TEFA Katapang. Tidak untuk distribusi publik tanpa izin.*
