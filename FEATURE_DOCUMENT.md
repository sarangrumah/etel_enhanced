# Dokumentasi Fitur Aplikasi Web e-Perizinan

## 1. Pendahuluan

Dokumen ini menyajikan gambaran teknis dan fungsional yang komprehensif mengenai aplikasi web e-Perizinan. Aplikasi ini dirancang untuk mengelola seluruh siklus perizinan usaha, mulai dari pendaftaran pengguna, pengajuan permohonan, evaluasi multi-tahap oleh tim internal, hingga penerbitan surat keputusan (SK) akhir. Aplikasi ini dilengkapi dengan berbagai fitur keamanan, pencatatan aktivitas pengguna, dan kapabilitas administrasi yang luas untuk memastikan proses berjalan efisien, transparan, dan aman.

---

## 2. Modul-Modul Inti Aplikasi

Aplikasi ini dibangun di atas sembilan modul inti yang saling terintegrasi.

### 2.1. Otentikasi & Manajemen Pengguna

Modul ini bertanggung jawab atas identitas pengguna, kontrol akses, dan administrasi akun.

- **Pendaftaran Pengguna:** Menyediakan alur registrasi terpisah untuk pengguna perorangan (melalui `layouts/frontend/registerpj.blade.php`) dan badan usaha/perusahaan (melalui `layouts/frontend/registerpt.blade.php`). Proses ini dikelola oleh `Auth\RegisterController`.
- **Kontrol Akses Berbasis Peran (RBAC):** Sistem ini menerapkan mekanisme keamanan yang ketat menggunakan _middleware_ `jabatancheck`. Fitur ini memastikan bahwa setiap pengguna hanya dapat mengakses fungsionalitas yang sesuai dengan perannya (misalnya, `Admin`, `Direktur`, `Koordinator`, `Evaluator`). Model `Jabatan` digunakan untuk mendefinisikan peran-peran ini.
- **Manajemen Pengguna oleh Admin:** Administrator memiliki dasbor khusus (`Admin\UsersController`) untuk menambah, mengubah, dan menonaktifkan akun pengguna, serta mengatur peran mereka.

### 2.2. Integrasi OSS (Online Single Submission)

Modul ini berfungsi sebagai jembatan komunikasi antara aplikasi dengan sistem OSS nasional.

- **Sinkronisasi NIB:** Aplikasi dapat menerima dan memproses data NIB (Nomor Induk Berusaha) secara otomatis melalui _endpoint_ API yang dikelola oleh `Api\Ossapi::receiveNIB`. Data ini disimpan dan dikelola menggunakan model `Nib` dan `DetailNIB`.
- **Konektivitas API:** Seluruh komunikasi dengan sistem OSS, termasuk proses Single Sign-On (SSO) melalui `Api\Ossapi::SSO`, diatur oleh controller API khusus untuk memastikan integrasi yang andal.

### 2.3. Proses e-Perizinan

Ini adalah modul utama yang mengelola keseluruhan alur kerja permohonan perizinan.

- **Alur Kerja Persetujuan Multi-Tahap:** Setiap permohonan akan melalui proses evaluasi berjenjang yang melibatkan berbagai peran:
    1.  **Evaluator:** Melakukan verifikasi awal terhadap syarat dan data (`Admin\EvaluatorController`).
    2.  **Subkoordinator:** Meninjau hasil evaluasi dan memberikan rekomendasi (`Admin\SubkoordinatorController`).
    3.  **Koordinator:** Melakukan validasi akhir dan disposisi (`Admin\KoordinatorController`).
    4.  **Direktur:** Memberikan persetujuan atau penolakan final (`Admin\DirekturController`).
- **Penerbitan SK Otomatis:** Setelah permohonan disetujui oleh Direktur, sistem secara otomatis akan menghasilkan dokumen Surat Keputusan (SK) resmi dalam format PDF. Fungsionalitas ini dikelola oleh `Admin\SkController` dengan fungsi seperti `generatepdf` dan `cetakSKUlo`.
- **Koreksi & Riwayat Permohonan:** Jika ditemukan kekurangan, permohonan dapat dikembalikan kepada pemohon untuk diperbaiki (`Admin\KoreksiPersyaratanController`). Seluruh riwayat dan perubahan status permohonan dicatat secara detail oleh `Admin\HistoryPerizinanController` dan model `Admin\Izinlog` untuk memastikan transparansi dan akuntabilitas.

### 2.4. Penomoran

Modul ini didedikasikan untuk mengelola alokasi, pencabutan, dan administrasi nomor atau kode akses khusus untuk layanan telekomunikasi.

- **Permohonan & Alokasi:** Pengguna dapat mengajukan permohonan nomor baru melalui `PermohonanPenomoranController`. Proses verifikasi dan alokasi dilakukan oleh tim internal.
- **Manajemen Kode Akses:** Sistem mengelola berbagai jenis kode akses (`JenisKodeAkses`, `MstKodeAkses`) beserta status dan riwayat penggunaannya (`TrxKodeAkses`).
- **Pencabutan & Histori:** Aplikasi mendukung proses pencabutan nomor yang dikelola oleh `Admin\PencabutanPenomoranController` dan mencatat semua aktivitas dalam `Admin\Penomoranlog`.

### 2.5. ULO (Uji Laik Operasi)

Modul khusus untuk mengelola alur kerja Uji Laik Operasi secara menyeluruh.

- **Sistem Penjadwalan:** Administrator dapat mengatur dan melihat jadwal ULO melalui antarmuka kalender interaktif yang dikelola oleh `Admin\ScheduleController` dan model `Admin\ULOSchedule`.
- **Alur Kerja Evaluasi:** Proses ULO melibatkan alur disposisi dan evaluasi yang mirip dengan perizinan, dari pengajuan oleh pelaku usaha hingga penetapan hasil oleh `Direktur`.
- **Notifikasi Otomatis:** Sistem mengirimkan pemberitahuan email otomatis kepada pengguna dan evaluator pada setiap tahapan penting dalam proses ULO.

### 2.6. Manajemen Survei & Umpan Balik

Sistem yang fleksibel untuk membuat, mendistribusikan, dan menganalisis hasil survei kepuasan pelanggan.

- **Pembuat Survei Dinamis:** Administrator dapat merancang survei kustom dengan berbagai tipe pertanyaan menggunakan `Admin\SurveyController` dan `Admin\QuestionController`.
- **Pengumpulan & Analisis Respons:** Jawaban dari responden disimpan dalam model `Responder` dan `ResponderQuestion`. Hasil survei dapat dianalisis melalui dasbor khusus.

### 2.7. Helpdesk & Dukungan

Modul ini menyediakan sistem tiket terintegrasi untuk layanan dukungan pengguna.

- **Manajemen Tiket:** Pengguna dapat membuat tiket laporan atau pertanyaan, yang kemudian akan dikelola dan ditindaklanjuti oleh tim helpdesk melalui `Admin\HelpdeskController`.

### 2.8. Pelaporan & Manajemen Data

Menyediakan fungsionalitas untuk analisis data, rekapitulasi, dan ekspor.

- **Laporan & Rekapitulasi:** `Admin\RekapController` menyediakan berbagai laporan, seperti rekapitulasi permohonan, alokasi penomoran, dan data pelaku usaha.
- **Ekspor ke Excel:** Data-data kunci, seperti hasil survei dan rekap perizinan, dapat diekspor ke dalam format Excel (`.xlsx`) menggunakan `Admin\ExcelController`.
- **Dasbor Big Data:** `Admin\BigdataController` menyajikan visualisasi data dan wawasan tingkat tinggi dari berbagai modul.

### 2.9. Admin & Data Master

Modul ini adalah pusat kendali untuk data dan konfigurasi master aplikasi.

- **Manajemen FAQ:** Administrator dapat mengelola konten untuk halaman Frequently Asked Questions (FAQ) melalui `Admin\FaqsController`.
- **Manajemen Hari Libur:** `Admin\MasterHolidayController` digunakan untuk mengelola daftar hari libur nasional, yang secara otomatis diperhitungkan dalam estimasi waktu layanan (SLA).

---

## 4. Alur Kerja Utama (Diagram Mermaid)

### 4.1. Alur Proses Persetujuan Uji Laik Operasi (ULO)

```mermaid
sequenceDiagram
    participant PelakuUsaha
    participant Admin
    participant Koordinator
    participant Subkoordinator
    participant Evaluator
    participant Direktur

    PelakuUsaha->>+Admin: Mengajukan Permohonan ULO
    Admin-->>-PelakuUsaha: Permohonan Diterima

    Admin->>+Koordinator: Mendisposisikan Permohonan
    Koordinator->>+Subkoordinator: Mendelegasikan untuk Peninjauan
    Subkoordinator->>+Evaluator: Menugaskan untuk Evaluasi Teknis
    
    Evaluator-->>-Subkoordinator: Mengirim Hasil Evaluasi
    Subkoordinator-->>-Koordinator: Meneruskan Hasil & Rekomendasi
    Koordinator-->>-Direktur: Mengirim Rekomendasi Final
    
    Direktur->>Direktur: Meninjau & Menetapkan Hasil (Setuju/Tolak)
    Direktur-->>-Admin: Mengirim Dokumen SK Hasil ULO
    
    Admin-->>PelakuUsaha: Memberitahukan Hasil & Mengirim SK
```

---

## 5. Fitur-Fitur Keamanan

Aplikasi ini menerapkan beberapa lapisan keamanan untuk melindungi data dan menjaga integritas sistem.

- **Kontrol Akses Berbasis Peran (RBAC):** _Middleware_ `jabatancheck` secara ketat membatasi akses ke setiap _route_ dan fungsionalitas berdasarkan peran pengguna, mencegah akses yang tidak sah.
- **Pencatatan Aktivitas Pengguna (Activity Logging):** `Admin\UserActivityController` dan model `UserActivity` mencatat semua tindakan signifikan yang dilakukan oleh pengguna, menciptakan jejak audit yang lengkap untuk keamanan dan akuntabilitas.
- **Pembatasan Percobaan Login (Login Throttling):** _Middleware_ `throttle:tryattempts` melindungi sistem dari serangan _brute-force_ dengan membatasi jumlah percobaan login yang gagal dari satu alamat IP.
- **Validasi Input:** Seluruh data yang dikirim oleh pengguna divalidasi secara ketat di sisi server untuk mencegah kerentanan umum seperti _Cross-Site Scripting_ (XSS) dan _SQL Injection_. Aturan validasi kustom seperti `ValidPdf` digunakan untuk memastikan file yang diunggah aman.
- **Penyimpanan Kata Sandi yang Aman:** Kata sandi pengguna dienkripsi menggunakan algoritma _hashing_ bawaan Laravel, memastikan bahwa kata sandi tidak pernah disimpan dalam bentuk teks biasa.
