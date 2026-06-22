# Audit Konsistensi Admin Dashboard ↔ Frontend Publik

> **Tanggal audit:** 2026-06-22  
> **Stack:** Laravel 11 · Blade · Tailwind · Alpine.js · MySQL  
> **Scope:** semua modul — Artikel, Kategori, Aspirasi, Audit Highlight, AI Feature, Budget Item

---

## Ringkasan Eksekutif

Ditemukan **17 masalah** tersebar di 4 modul utama:

| Severity | Jumlah | Keterangan |
|---|---|---|
| 🔴 KRITIS | 4 | Data hilang / view crash di produksi |
| 🟠 PENTING | 7 | Field sia-sia atau fungsionalitas tidak tersambung |
| 🟡 MINOR | 6 | Inkonsistensi UX / field tak terkelola |

---

## Tabel Konsistensi Per Field

### Modul: ARTIKEL (`articles`)

| Field | Admin (edit?) | Frontend (tampil?) | Model `$fillable` | Migration | Status |
|---|---|---|---|---|---|
| `title` | ✅ required | ✅ di semua komponen | ✅ | ✅ | ✅ Konsisten |
| `slug` | ✅ (create: ada input tapi **DIABAIKAN** store) | ✅ dipakai di URL route | ✅ | ✅ | ⚠️ Input create tidak tersimpan |
| `deck` | ✅ textarea | ✅ di article, feature-story | ✅ | ✅ | ✅ Konsisten |
| `body` | ✅ required | ✅ di article.blade.php | ✅ | ✅ | ✅ Konsisten |
| `category_id` | ✅ select required | ✅ `$article->category->name` tampil | ✅ | ✅ | ✅ Konsisten |
| `author` | ✅ input teks | ✅ fallback byline | ✅ | ✅ | ✅ Konsisten |
| `author_name` | ✅ input teks DI FORM | ✅ byline prioritas pertama | ✅ | ✅ (migrasi terpisah) | 🔴 **Tidak disimpan** — store() & update() tidak validasi field ini |
| `image` (upload) | ✅ file upload | ✅ (`asset()`) | ✅ (`image_path`) | ✅ (`image_path`) | ⚠️ Edit pakai `Storage::url()`, frontend pakai `asset()` — beda path |
| `image_caption` | ❌ **tidak ada input** | ✅ `$article->image_caption` ditampilkan jika ada | ✅ | ✅ | 🔴 **Tidak pernah bisa terisi** — tidak ada form input di admin |
| `read_minutes` | ✅ number input | ✅ di `$article->meta` | ✅ | ✅ | ✅ Konsisten |
| `is_featured` | ✅ checkbox | ❌ **query tidak pakai filter ini** | ✅ | ✅ | 🟠 Flag ada tapi tidak mempengaruhi tampilan frontend |
| `is_trending` | ✅ checkbox | ❌ **trending-card tidak dirender di home** | ✅ | ✅ | 🟠 Flag ada, komponen ada, tapi home.blade.php tidak memakainya |
| `published_at` | ✅ via select status | ✅ `scopePublished()` memfilter frontend | ✅ | ✅ | ✅ Konsisten |
| `views` | ❌ tidak bisa diedit (auto) | ❌ tidak ditampilkan ke publik | ✅ | ✅ (migrasi terpisah) | 🟡 Field ada, tidak tampil di frontend — oke untuk analytics internal |

---

### Modul: KATEGORI (`categories`)

| Field | Admin (edit?) | Frontend (tampil?) | Model `$fillable` | Migration | Status |
|---|---|---|---|---|---|
| `name` | ✅ required | ✅ di category-card, article header | ✅ | ✅ | ✅ Konsisten |
| `slug` | ❌ auto-generate | ✅ dipakai di route | ✅ | ✅ | ✅ Konsisten (by design) |
| `description` | ✅ textarea | ❌ **tidak ditampilkan di mana pun** | ✅ | ✅ (migrasi terpisah) | 🟠 Orphan — bisa diedit tapi tidak pernah tampil di frontend |
| `sort_order` | ❌ **tidak ada input** | ✅ dipakai di `scopeActive()` ORDER BY | ✅ | ✅ | 🟠 Tidak bisa diubah via admin UI — urutan kategori tidak terkelola |
| `is_active` | ❌ **tidak ada toggle** | ✅ `scopeActive()` memfilter frontend | ✅ | ✅ | 🟠 Tidak ada cara menonaktifkan kategori via admin |
| *(halaman kategori)* | — | ❌ **view `category.blade.php` TIDAK ADA** | — | — | 🔴 **Klik kategori → crash 500/404** |

---

### Modul: ASPIRASI (`aspirasi`)

| Field | Admin (edit?) | Frontend (tampil?) | Model `$fillable` | Migration | Status |
|---|---|---|---|---|---|
| `title` | ✅ textarea | ✅ aspirasi-box (dipotong ellipsis) | ✅ | ✅ | ✅ Konsisten |
| `location` | ✅ input teks | ❌ **tidak tampil di aspirasi-box** | ✅ | ✅ (NOT nullable!) | ⚠️ Ditampilkan hanya di admin tabel; public form submit nullable tapi kolom NOT NULL |
| `color` | ✅ select (green/yellow/blue/red) | ✅ dot warna di aspirasi-box | ✅ | ✅ (`enum`) | ✅ Konsisten |
| `status` (baru/ditanggapi/selesai) | ✅ select + quick-update | ❌ **tidak tampil di frontend sama sekali** | ✅ | ✅ (migrasi terpisah) | 🟡 Status internal saja — pertimbangkan tampilkan ke publik |
| `moderation_status` | ✅ tab pending/approved/rejected | ✅ `scopeActive()` filter approved | ✅ | ✅ (migrasi terpisah) | ✅ Konsisten |
| `is_active` | ✅ checkbox + toggle | ✅ `scopeActive()` filter is_active | ✅ | ✅ | ✅ Konsisten |
| `rejection_reason` | ✅ modal tolak | ❌ tidak tampil ke publik (by design) | ✅ | ✅ | ✅ Konsisten (arsip internal) |
| `moderated_at` | ❌ auto-set oleh controller | ❌ tidak tampil | ✅ | ✅ | ✅ Konsisten (metadata internal) |
| `moderated_by` | ❌ auto-set | ❌ tidak tampil | ✅ | ✅ (FK ke users) | ✅ Konsisten (audit trail) |
| `similar_count` | ❌ **tidak ada input** | ❌ **tidak ditampilkan** | ✅ | ✅ | 🟡 Orphan total — tidak dipakai di mana pun |
| `submitted_at` | ❌ auto-set | ✅ via `time_ago` accessor | ✅ | ✅ | ✅ Konsisten |

---

### Modul: AUDIT HIGHLIGHT (`audit_highlights`)

| Field | Admin (edit?) | Frontend (tampil?) | Model `$fillable` | Migration | Status |
|---|---|---|---|---|---|
| `label` | ✅ required | ✅ audit-strip | ✅ | ✅ | ✅ Konsisten |
| `value` | ✅ required | ✅ audit-strip | ✅ | ✅ | ✅ Konsisten |
| `order` | ✅ number input | ✅ ORDER BY order di scopeActive | ✅ | ✅ | ✅ Konsisten |
| `is_active` | ✅ checkbox | ✅ `scopeActive()` memfilter | ✅ | ✅ | ✅ Konsisten |

---

### Modul: AI FEATURE (`ai_features`)

| Field | Admin (edit?) | Frontend (tampil?) | Model `$fillable` | Migration | Status |
|---|---|---|---|---|---|
| `title` | ✅ | ✅ ai-feature-card | ✅ | ✅ | ✅ Konsisten |
| `description` | ✅ | ✅ ai-feature-card | ✅ | ✅ | ✅ Konsisten |
| `icon` | ✅ select | ✅ ai-feature-card (x-icon) | ✅ | ✅ | ✅ Konsisten |
| `route_or_url` | ✅ input teks | ✅ via `$feature->link` accessor | ✅ | ✅ | ✅ Konsisten |
| `sort_order` | ✅ number input | ✅ ORDER BY sort_order | ✅ | ✅ | ✅ Konsisten |
| `is_active` | ✅ checkbox | ✅ `scopeActive()` memfilter | ✅ | ✅ | ✅ Konsisten |

---

### Modul: BUDGET ITEM (`budget_items`)

| Field | Admin (edit?) | Frontend (tampil?) | Model `$fillable` | Migration | Status |
|---|---|---|---|---|---|
| `label` | ❌ **tidak ada admin** | ❌ **komponen tidak dipakai di home** | ✅ | ✅ | 🟠 Modul tanpa admin CRUD dan tidak dirender di frontend |
| `icon` | ❌ | ❌ | ✅ | ✅ | 🟠 |
| `amount` | ❌ | ❌ | ✅ | ✅ | 🟠 |
| `sort_order` | ❌ | ❌ | ✅ | ✅ | 🟠 |
| `is_active` | ❌ | ❌ | ✅ | ✅ | 🟠 |

> `budget-banner.blade.php` ada, `BudgetItem` model ada, tapi `home.blade.php` tidak memanggil komponen ini, dan `HomeController` tidak passing `$items`. Seluruh modul tidak aktif.

---

## Daftar Bug & Rekomendasi Perbaikan

### 🔴 PRIORITAS 1 — Kritis (rusak / data hilang)

#### BUG-01: `author_name` tidak pernah tersimpan
- **Lokasi:** [Admin/ArticleController.php](app/Http/Controllers/Admin/ArticleController.php)
- **Masalah:** Form `create` dan `edit` punya `<input name="author_name">`, tapi `store()` dan `update()` tidak menyertakan `'author_name'` dalam array `validate([...])`. Karena `$data = $request->validate(...)`, field ini tidak ada di `$data` → tidak tersimpan → `author_name` selalu null di DB.
- **Dampak:** Byline frontend pakai fallback ke `author` lama. Perubahan nama penulis via input "PENULIS" tidak berpengaruh.
- **Fix:** Tambahkan `'author_name' => ['nullable', 'string', 'max:100'],` di validasi `store()` dan `update()`.

#### BUG-02: `image_caption` tidak ada input di admin
- **Lokasi:** [admin/articles/create.blade.php](resources/views/admin/articles/create.blade.php), [admin/articles/edit.blade.php](resources/views/admin/articles/edit.blade.php)
- **Masalah:** `article.blade.php:57` menampilkan `$article->image_caption` tapi tidak ada `<input name="image_caption">` di form admin manapun.
- **Dampak:** Field ini selalu kosong — keterangan foto tidak pernah bisa diisi.
- **Fix:** Tambahkan input `image_caption` di bawah upload foto di kedua form admin, tambahkan ke validasi controller.

#### BUG-03: View `category.blade.php` tidak ada — halaman kategori crash
- **Lokasi:** [ArticleController.php:19](app/Http/Controllers/ArticleController.php#L19), [components/category-card.blade.php](resources/views/components/category-card.blade.php)
- **Masalah:** `category-card` dan header menu keduanya menautkan ke `route('category.show', $cat)`. Controller sudah ada (`ArticleController::category()`), tapi `resources/views/category.blade.php` **tidak ada**. Klik kategori akan memicu exception `View [category] not found`.
- **Dampak:** Semua link kategori di frontend crash — ini merusak navigasi inti situs.
- **Fix:** Buat `resources/views/category.blade.php` (daftar artikel per kategori dengan pagination).

#### BUG-04: `location` NOT NULL tapi nullable di public form
- **Lokasi:** Migration [2026_06_20_000002_create_aspirasi_table.php](database/migrations/2026_06_20_000002_create_aspirasi_table.php), [AspirasiPublicController.php](app/Http/Controllers/AspirasiPublicController.php)
- **Masalah:** Migration mendefinisikan `$table->string('location')` (NOT NULL), tapi controller `store()` membolehkan `'location' => null`. Jika user tidak mengisi lokasi dan DB dalam strict mode, INSERT akan gagal.
- **Fix:** Ubah migration menjadi `$table->string('location')->nullable()` lalu jalankan migration baru, atau beri default empty string di controller.

---

### 🟠 PRIORITAS 2 — Penting (fungsionalitas tidak bekerja)

#### ISS-05: `is_featured` tidak mempengaruhi tampilan frontend
- **Lokasi:** [HomeController.php](app/Http/Controllers/HomeController.php), [components/feature-story.blade.php](resources/views/components/feature-story.blade.php)
- **Masalah:** Admin punya toggle "Sorotan Utama" (`is_featured`) tapi `HomeController::index()` mengambil `Article::published()->take(4)` tanpa filter. Komponen `feature-story.blade.php` ada tapi tidak dipakai di `home.blade.php`.
- **Fix:** Di `HomeController`, pisahkan query: `$featured = Article::published()->where('is_featured', true)->first()` dan `$latest = Article::published()->where('is_featured', false)->take(4)->get()`. Tambahkan tampilan featured story di `home.blade.php`.

#### ISS-06: `is_trending` tidak mempengaruhi tampilan frontend
- **Lokasi:** [HomeController.php](app/Http/Controllers/HomeController.php), [components/trending-card.blade.php](resources/views/components/trending-card.blade.php)
- **Masalah:** Admin punya toggle "Trending" dan komponen `trending-card.blade.php` sudah ada, tapi `home.blade.php` tidak memiliki seksi trending. Flag `is_trending` tidak pernah dipakai di query manapun.
- **Fix:** Tambahkan query di HomeController `$trending = Article::published()->where('is_trending', true)->take(5)->get()`, lalu render di `home.blade.php` dengan horizontal scroll menggunakan `trending-card`.

#### ISS-07: `BudgetItem` — modul tanpa admin dan tidak dirender di frontend
- **Lokasi:** [app/Models/BudgetItem.php](app/Models/BudgetItem.php), [components/budget-banner.blade.php](resources/views/components/budget-banner.blade.php)
- **Masalah:** Model, migration, dan komponen `budget-banner` sudah ada tapi: (a) tidak ada admin CRUD, (b) `HomeController` tidak passing `$items`, (c) `home.blade.php` tidak memanggil `<x-budget-banner>`.
- **Fix:** Pilih satu: (a) Selesaikan modul — buat admin CRUD Budget Item, tambahkan ke HomeController dan home.blade.php; atau (b) Hapus migrasi, model, dan komponen jika fitur ditunda.

#### ISS-08: Category `sort_order` tidak bisa diubah via admin
- **Lokasi:** [admin/categories/index.blade.php](resources/views/admin/categories/index.blade.php), [Admin/CategoryController.php](app/Http/Controllers/Admin/CategoryController.php)
- **Masalah:** `scopeActive()` mengurutkan berdasarkan `sort_order`, tapi admin form hanya punya `name` dan `description`. Urutan kategori di frontend tidak bisa dikendalikan.
- **Fix:** Tambahkan input `sort_order` (number) di modal form kategori dan validasi di controller.

#### ISS-09: Category `is_active` tidak bisa diubah via admin
- **Lokasi:** [Admin/CategoryController.php](app/Http/Controllers/Admin/CategoryController.php)
- **Masalah:** Frontend hanya menampilkan kategori aktif (`scopeActive()`), tapi tidak ada cara menonaktifkan kategori dari admin.
- **Fix:** Tambahkan checkbox `is_active` di modal kategori atau tombol toggle di tabel.

#### ISS-10: `image_path` — path tidak konsisten antara edit dan frontend
- **Lokasi:** [admin/articles/edit.blade.php:72](resources/views/admin/articles/edit.blade.php#L72), [article.blade.php:50](resources/views/article.blade.php#L50)
- **Masalah:** Edit form: `Storage::url($article->image_path)` → butuh storage symlink. Frontend article: `asset($article->image_path)` → asumsi file di `public/`. Salah satu pasti salah tergantung di mana file disimpan.
- **Fix:** Standardisasi: karena controller menyimpan ke `store('articles', 'public')`, semua tampilan seharusnya pakai `Storage::url($article->image_path)`. Update `article.blade.php`, `news-list-item.blade.php`, `feature-story.blade.php`, dan `trending-card.blade.php`.

#### ISS-11: Category `description` tidak pernah tampil di frontend
- **Lokasi:** [components/category-card.blade.php](resources/views/components/category-card.blade.php), [admin/categories/index.blade.php](resources/views/admin/categories/index.blade.php)
- **Masalah:** Field deskripsi kategori bisa diedit di admin tapi tidak pernah ditampilkan ke publik — baik di category-card maupun di halaman daftar artikel per kategori (yang belum ada, lihat BUG-03).
- **Fix:** Tampilkan deskripsi di halaman `category.blade.php` yang akan dibuat, atau hapus field ini jika memang tidak diperlukan.

---

### 🟡 PRIORITAS 3 — Minor (kebersihan kode / UX)

#### ISS-12: `slug` di form create diabaikan
- **Lokasi:** [Admin/ArticleController.php:42-55](app/Http/Controllers/Admin/ArticleController.php#L42)
- **Masalah:** Form create menampilkan input slug (dengan auto-generate dari judul via Alpine), tapi `store()` tidak validasi `'slug'`. Model akan auto-generate. Form memberikan kesan slug bisa dikustomisasi saat create, padahal tidak.
- **Fix:** Tambahkan `'slug' => ['nullable', 'string', 'max:255']` ke validasi `store()`.

#### ISS-13: Duplikasi field `author` dan `author_name`
- **Lokasi:** Admin create/edit form, `article.blade.php`
- **Masalah:** Ada dua input terpisah: "PENULIS" (`author_name`) dan "Penulis" (`author`) di bagian Kategori & Penulis. Frontend menggunakan `author_name ?: author`. Ini membingungkan admin.
- **Fix:** Setelah BUG-01 diperbaiki, pertimbangkan menghapus field `author` lama dan hanya gunakan `author_name`, atau sebaliknya. Jangan simpan dua field untuk hal yang sama.

#### ISS-14: `similar_count` orphan di aspirasi
- **Lokasi:** [app/Models/Aspirasi.php](app/Models/Aspirasi.php), migration aspirasi
- **Masalah:** Field `similar_count` ada di migration dan $fillable tapi tidak pernah diincrement di controller manapun dan tidak ditampilkan di mana pun.
- **Fix:** Implementasikan logika pengelompokan aspirasi serupa, atau hapus kolom jika fitur ditunda.

#### ISS-15: `location` tidak tampil di aspirasi-box frontend
- **Lokasi:** [components/aspirasi-box.blade.php](resources/views/components/aspirasi-box.blade.php)
- **Masalah:** Lokasi aspirasi bisa diedit di admin dan diisi di public form, tapi tidak pernah ditampilkan di aspirasi-box. Konteks geografis hilang dari tampilan warga.
- **Fix (opsional):** Tambahkan lokasi kecil di bawah judul aspirasi: `<span class="text-[10px] text-muted">{{ $item->location }}</span>`.

#### ISS-16: `status` aspirasi (baru/ditanggapi/selesai) tidak tampil ke publik
- **Lokasi:** [components/aspirasi-box.blade.php](resources/views/components/aspirasi-box.blade.php)
- **Masalah:** Admin bisa update status (baru/ditanggapi/selesai) tapi warga tidak tahu status aspirasinya.
- **Fix (opsional):** Tampilkan badge status di aspirasi-box sebagai indikator transparansi.

#### ISS-17: `ArticleController::show()` tidak increment `views`
- **Lokasi:** [ArticleController.php](app/Http/Controllers/ArticleController.php)
- **Masalah:** Kolom `views` ada di DB dan $fillable tapi `show()` tidak pernah mengincrementnya (`$article->increment('views')`).
- **Fix:** Tambahkan `$article->increment('views');` di `show()` setelah load article.

---

## Ringkasan Statistik

| Modul | Field Total | Konsisten ✅ | Tidak Sinkron ⚠️ | Hilang/Rusak ❌ |
|---|---|---|---|---|
| Artikel | 14 | 8 | 3 | 3 |
| Kategori | 6 | 2 | 3 | 1 |
| Aspirasi | 11 | 6 | 3 | 2 |
| Audit Highlight | 4 | 4 | 0 | 0 |
| AI Feature | 6 | 6 | 0 | 0 |
| Budget Item | 5 | 0 | 0 | 5 |
| **TOTAL** | **46** | **26 (57%)** | **9 (19%)** | **11 (24%)** |

---

## Urutan Perbaikan yang Disarankan

```
Sprint 1 (blocking — perbaiki sekarang):
  BUG-03  Buat category.blade.php            → navigasi inti crash
  BUG-01  Tambah author_name ke validasi     → data hilang diam-diam
  BUG-04  Ubah location nullable di migration → potensi error INSERT
  BUG-02  Tambah input image_caption ke form  → field tidak pernah terisi

Sprint 2 (fungsionalitas yang sudah dibangun tapi tidak terhubung):
  ISS-05  Sambungkan is_featured ke HomeController + home.blade.php
  ISS-06  Sambungkan is_trending ke HomeController + home.blade.php
  ISS-10  Standardisasi Storage::url() di semua komponen artikel
  ISS-12  Tambah slug ke validasi store()

Sprint 3 (admin capability yang hilang):
  ISS-08  Tambah sort_order ke form kategori
  ISS-09  Tambah toggle is_active ke form kategori
  ISS-11  Tampilkan description di halaman kategori

Sprint 4 (fitur tertunda atau cleanup):
  ISS-07  Selesaikan atau hapus modul BudgetItem
  ISS-13  Konsolidasi author vs author_name menjadi satu field
  ISS-14  Implementasi similar_count atau hapus kolom
  ISS-17  Increment views di ArticleController::show()
  ISS-15  (opsional) Tampilkan location di aspirasi-box
  ISS-16  (opsional) Tampilkan status aspirasi ke publik
```
