# Panduan Quality Assurance & Testing: nekatefa.com

Dokumen ini berisi panduan komprehensif bagi tim QA untuk menguji aplikasi katalog produk TEFA Katapang.

## 1. Lingkungan Testing
Aplikasi berjalan di atas **Laravel 12** dan **Filament 3**. Pastikan environment lokal sudah dikonfigurasi dengan:
- Database: MySQL
- Autentikasi: Laravel Breeze (Customer) & Filament Auth (Admin)
- Storage: `public` disk untuk gambar produk

## 2. Kredensial Akun Testing
Gunakan akun ini untuk simulasi alur kerja antar-role:

| Role | Email | Password | Akses |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `super@nekatefa.com` | `password` | Manajemen Jurusan, Admin, & Monitoring Lead |
| **Admin RPL** | `admin.rpl@nekatefa.com` | `Rekayasa Perangkat Lunak` | CRUD Produk & Lead khusus RPL |
| **Admin TKJ** | `admin.tkj@nekatefa.com` | `Teknik Komputer dan Jaringan` | CRUD Produk & Lead khusus TKJ |
| **Customer** | `customer@nekatefa.com` | `password` | Akses Katalog & Tombol Hubungi Admin |

---

## 3. Skenario Testing Utama

### A. Skenario Customer (Frontend)
**Tujuan:** Memastikan alur pemilihan produk hingga generate pesan WA berjalan lancar.

1. **Autentikasi:** Login menggunakan akun Customer. Pastikan redirect sukses ke dashboard atau halaman yang sesuai.
2. **Browsing Katalog:**
   - Navigasi ke `/product`.
   - Uji filter berdasarkan jurusan. Pastikan produk yang tampil sesuai dengan jurusan yang dipilih.
   - Uji pencarian (search) berdasarkan keyword nama produk.
3. **Detail Produk:** Klik salah satu produk. Pastikan deskripsi, galeri foto, dan harga (format Rupiah) tampil benar.
4. **Lead Generation:** Klik tombol "Hubungi Admin".
   - **Verifikasi:** User diarahkan ke `wa.me/...` dengan format pesan otomatis.
   - **Data Record:** Cek database tabel `leads` apakah data (user_id, produk_id, jurusan_id) tersimpan dengan status `baru_masuk`.

### B. Skenario Admin Jurusan (Backend `/admin`)
**Tujuan:** Memastikan isolasi data (data hanya bisa dilihat oleh pemiliknya).

1. **Isolasi Data (JurusanScope):**
   - Login sebagai `admin.rpl@nekatefa.com`.
   - Masuk ke menu **Produk**. Pastikan HANYA produk RPL yang muncul.
   - Masuk ke menu **Leads**. Pastikan HANYA lead yang masuk ke jurusan RPL yang muncul.
2. **CRUD Produk:**
   - Tambah produk baru dengan 3 gambar.
   - Edit produk tersebut dan pastikan gambar terupdate di `storage/app/public/produk/`.
   - Hapus produk (Soft/Hard delete tergantung konfigurasi).
3. **Manajemen Lead:**
   - Ubah status lead (misal: `Baru Masuk` -> `Sudah Dihubungi`).
   - Pastikan perubahan status tersimpan di database.

### C. Skenario Super Admin (Backend `/admin`)
**Tujuan:** Memastikan monitoring lintas jurusan berjalan.

1. **Akses Multi-Jurusan:**
   - Login sebagai `super@nekatefa.com`.
   - Masuk ke menu **Leads**. Pastikan bisa melihat lead dari SELURUH jurusan.
2. **Manajemen Akun:**
   - Tambah Admin Jurusan baru.
   - Pastikan admin baru tersebut bisa login dan memiliki scope jurusan yang benar.

---

## 4. Checklist Keamanan (Security Hardening)
- **IDOR Check:** Saat login sebagai Admin RPL, coba ketik URL manual `/admin/produks/{id}/edit` milik jurusan TKJ. Sistem WAJIB mengembalikan error 403 (Forbidden) atau 404.
- **Form Validation:** Pastikan saat input harga produk, admin tidak bisa memasukkan karakter huruf atau nilai negatif.
- **Session Timeout:** Uji apakah session expired sesuai dengan `config/session.php`.

## 5. Pelaporan Bug
Setiap ditemukan bug, harap laporkan dengan format:
1. **Skenario:** (Misal: User A, role B, aksi C)
2. **Hasil Ekspektasi:** (Apa yang seharusnya terjadi)
3. **Hasil Aktual:** (Apa yang sebenarnya terjadi)
4. **Screenshot/Log:** Jika ada error Laravel, lampirkan log dari `storage/logs/laravel.log`.
