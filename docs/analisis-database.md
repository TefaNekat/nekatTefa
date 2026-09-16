# ANALISIS DATABASE LENGKAP - NEKATEFA.COM

## Ringkasan 7 Tabel Utama

```
jurusans
  ├── produks
  │   └── produk_gambars
  ├── admin_jurusans
  └── leads ──┬── users
             └── (junction: user + produk + jurusan)

pages (standalone - konten halaman publik)
```

---

## 1. TABEL: `jurusans`
**Fungsi:** Menyimpan data 7 jurusan di TEFA Katapang

| Kolom | Tipe | Penjelasan |
|---|---|---|
| `id` | INT PK | Primary key |
| `nama` | VARCHAR | Nama jurusan (misal: "Teknik Mesin") |
| `slug` | VARCHAR UNIQUE | URL-friendly identifier (misal: "teknik-mesin") |
| `deskripsi` | TEXT | Profil & deskripsi jurusan |
| `nomor_wa` | VARCHAR | Nomor WhatsApp admin jurusan (untuk routing lead) |
| `created_at`, `updated_at` | TIMESTAMP | Metadata |

**Model:** `Jurusan` (app/Models/Jurusan.php)

**Relasi Keluar:**
- `hasMany('Produk')` — 1 jurusan → banyak produk
- `hasMany('AdminJurusan')` — 1 jurusan → banyak admin (biasanya 1)
- `hasMany('Lead')` — 1 jurusan → banyak lead masuk

---

## 2. TABEL: `produks`
**Fungsi:** Katalog produk semua jurusan

| Kolom | Tipe | Penjelasan |
|---|---|---|
| `id` | INT PK | Primary key |
| `jurusan_id` | INT FK | Foreign key ke `jurusans` (onDelete: restrict) |
| `nama` | VARCHAR | Nama produk |
| `slug` | VARCHAR UNIQUE | URL-friendly identifier |
| `deskripsi` | TEXT | Deskripsi umum produk |
| `fungsi` | TEXT | Fungsi/kegunaan produk |
| `manfaat` | TEXT | Manfaat bagi customer |
| `fitur_keunggulan` | TEXT | Keunggulan kompetitif |
| `harga` | DECIMAL(12,2) | Harga produk (Rp) |
| `status` | ENUM('draft','published') | Draft atau live di katalog |
| `created_at`, `updated_at` | TIMESTAMP | Metadata |

**Model:** `Produk` (app/Models/Produk.php)

**Global Scope:** `JurusanScope` — Otomatis filter produk sesuai jurusan admin yang login (kecuali Super Admin)

**Relasi Keluar:**
- `belongsTo('Jurusan')` — Produk milik 1 jurusan
- `hasMany('ProdukGambar')` — 1 produk → banyak foto
- `hasMany('Lead')` — 1 produk → banyak lead

**Accessor:**
- `hargaFormatted` — Format harga ke "Rp 1.500.000"

---

## 3. TABEL: `produk_gambars`
**Fungsi:** Galeri foto per produk (2-5 foto)

| Kolom | Tipe | Penjelasan |
|---|---|---|
| `id` | INT PK | Primary key |
| `produk_id` | INT FK | Foreign key ke `produks` (onDelete: cascade) |
| `path_gambar` | VARCHAR | Path file foto (misal: "products/123/photo-1.jpg") |
| `urutan` | TINYINT | Urutan tampil (1-5) |
| `created_at`, `updated_at` | TIMESTAMP | Metadata |

**Model:** `ProdukGambar` (app/Models/ProdukGambar.php)

**Global Scope:** Otomatis `orderBy('urutan')` saat query

**Relasi Keluar:**
- `belongsTo('Produk')` — Foto milik 1 produk

---

## 4. TABEL: `users` (Customer)
**Fungsi:** Akun pelanggan yang ingin menghubungi admin

| Kolom | Tipe | Penjelasan |
|---|---|---|
| `id` | INT PK | Primary key |
| `name` | VARCHAR | Nama customer |
| `email` | VARCHAR UNIQUE | Email (wajib untuk login) |
| `phone` | VARCHAR | Nomor telepon (ditambah via migration, auto-fill WhatsApp) |
| `email_verified_at` | TIMESTAMP | Status verifikasi email (optional) |
| `password` | VARCHAR | Password terenkripsi |
| `remember_token` | VARCHAR | Token "Remember me" |
| `created_at`, `updated_at` | TIMESTAMP | Metadata |

**Model:** `User` (app/Models/User.php)

**Guard:** `web` (Laravel Breeze)

**Relasi Keluar:**
- `hasMany('Lead')` — 1 customer → banyak lead (misal: tanya produk A, lalu produk B)

**Alur:**
1. Customer belum login → Redirect ke halaman login/register
2. Register/Login → Simpan data (nama, email, phone)
3. Klik "Hubungi Admin" → Lead tercatat otomatis

---

## 5. TABEL: `admin_jurusans`
**Fungsi:** Akun admin per jurusan (untuk Filament panel)

| Kolom | Tipe | Penjelasan |
|---|---|---|
| `id` | INT PK | Primary key |
| `jurusan_id` | INT FK | Foreign key ke `jurusans` (onDelete: restrict) — nullable untuk Super Admin |
| `name` | VARCHAR | Nama lengkap admin |
| `email` | VARCHAR UNIQUE | Email login (wajib unique) |
| `password` | VARCHAR | Password terenkripsi |
| `role` | ENUM('super_admin','admin_jurusan') | Tingkatan akses |
| `remember_token` | VARCHAR | Token "Remember me" |
| `created_at`, `updated_at` | TIMESTAMP | Metadata |

**Model:** `AdminJurusan` (app/Models/AdminJurusan.php)

**Guard:** `admin` (Filament Auth)

**Traits:** `HasRoles` (Spatie Permission)

**Role System:**
- **`super_admin`** (1 akun): Akses penuh halaman publik, kelola 7 akun admin, monitoring semua lead
- **`admin_jurusan`** (7 akun, 1 per jurusan): CRUD produk & galeri jurusan sendiri, kelola lead jurusan sendiri

**Relasi Keluar:**
- `belongsTo('Jurusan')` — Admin mengelola 1 jurusan (kecuali Super Admin: `jurusan_id = null`)

**Method:**
- `isSuperAdmin()` — Check apakah role = 'super_admin'

---

## 6. TABEL: `leads`
**Fungsi:** Pencatatan otomatis setiap klik "Hubungi Admin" (prospek/lead masuk)

| Kolom | Tipe | Penjelasan |
|---|---|---|
| `id` | INT PK | Primary key |
| `user_id` | INT FK | Foreign key ke `users` (onDelete: restrict) |
| `produk_id` | INT FK | Foreign key ke `produks` (onDelete: restrict) |
| `jurusan_id` | INT FK | Foreign key ke `jurusans` (onDelete: restrict) |
| `status` | ENUM('baru_masuk','sudah_dihubungi','closing','batal') | Status lead progression |
| `catatan_admin` | TEXT | Catatan follow-up dari admin |
| `created_at`, `updated_at` | TIMESTAMP | Waktu lead masuk & update terakhir |

**Model:** `Lead` (app/Models/Lead.php)

**Global Scope:** `JurusanScope` — Otomatis filter lead sesuai jurusan admin (kecuali Super Admin)

**Relasi Keluar:**
- `belongsTo('User')` — Lead dari 1 customer
- `belongsTo('Produk')` — Lead tertarik pada 1 produk
- `belongsTo('Jurusan')` — Lead masuk ke 1 jurusan

**Status Flow:**
```
baru_masuk → sudah_dihubungi → closing (selesai)
                              → batal (tidak jadi)
```

---

## 7. TABEL: `pages`
**Fungsi:** Konten halaman publik (CMS standalone)

| Kolom | Tipe | Penjelasan |
|---|---|---|
| `id` | INT PK | Primary key |
| `slug` | VARCHAR UNIQUE | Identifier halaman (misal: "home", "contact", "about") |
| `judul` | VARCHAR | Judul halaman |
| `konten` | TEXT | Konten HTML/Markdown |
| `created_at`, `updated_at` | TIMESTAMP | Metadata |

**Model:** `Page` (app/Models/Page.php)

**Fungsi:** Super Admin bisa edit konten Home, Contact, About tanpa ubah kode

---

## DIAGRAM RELASI LENGKAP

```
┌─────────────────────────────────────────────────────────────┐
│                      jurusans (7)                           │
│  id, nama, slug, deskripsi, nomor_wa, created_at            │
└─────────────┬───────────────────────────┬───────────────────┘
              │                           │
       ┌──────▼──────┐            ┌───────▼────────┐
       │  produks    │            │ admin_jurusans │
       │ (banyak)    │            │  (1-2 per)     │
       │ jurusan_id  │────FK      │ jurusan_id  FK │
       │ deskripsi   │            │ role: enum     │
       │ harga       │            │ (super/admin)  │
       │ status      │            └────────────────┘
       └──────┬──────┘
              │
       ┌──────▼────────────────┐
       │  produk_gambars       │
       │  produk_id  FK        │
       │  path_gambar          │
       │  urutan               │
       └───────────────────────┘

┌──────────────────────────────────────────────────────────────┐
│                       leads (banyak)                         │
│  user_id FK ──┬─────▶ users (customer)                       │
│  produk_id FK ├─────▶ produks                                │
│  jurusan_id FK├─────▶ jurusans                               │
│  status       │                                              │
│  catatan_admin│                                              │
└───────────────┴──────────────────────────────────────────────┘

┌──────────────────────┐
│      pages           │
│  slug, judul, konten │
└──────────────────────┘
```

---

## ISOLASI DATA PER JURUSAN (Global Scope)

**Tabel yang pakai `JurusanScope`:**
- `Produk::class`
- `Lead::class`

**Logika:**
```php
// Ketika admin jurusan login (role = 'admin_jurusan')
$produk = Produk::all(); // Otomatis WHERE jurusan_id = {admin's jurusan_id}

// Ketika Super Admin login (role = 'super_admin')
$produk = Produk::all(); // TANPA filter, lihat semua produk semua jurusan
```

---

## KEY TAKEAWAYS

✓ **7 tabel core** — Jurusan, Produk, ProdukGambar, User, AdminJurusan, Lead, Pages
✓ **Dual Guard System** — `web` (customer) + `admin` (staff)
✓ **Auto-isolation** — Global Scope mencegah admin jurusan lihat data jurusan lain
✓ **Lead Tracking** — Otomatis catat setiap klik "Hubungi Admin" (junction: user + produk + jurusan)
✓ **No Cascade Delete** — Foreign key pakai `onDelete('restrict')` agar data konsisten (kecuali ProdukGambar)
