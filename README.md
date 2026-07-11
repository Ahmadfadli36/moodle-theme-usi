# theme_usi

> A lightweight Boost child theme for Moodle, designed to provide a cleaner and more maintainable login experience.

`theme_usi` merupakan child theme dari **Boost** yang digunakan untuk menyimpan seluruh kustomisasi tampilan LMS dalam bentuk plugin Moodle. Dengan pendekatan ini, perubahan tampilan tidak lagi bergantung pada konfigurasi **Raw SCSS** maupun **Additional HTML** di Theme Boost, sehingga proses pemeliharaan, backup, dan deployment menjadi jauh lebih mudah.

---

## ✨ Features

* 🎨 Child theme berbasis Boost
* 🔐 Kustomisasi halaman login
* 💅 Styling menggunakan SCSS
* ⚡ JavaScript menggunakan Moodle AMD Module
* 📦 Mudah dipindahkan ke environment Moodle lain
* 🔧 Struktur kode lebih rapi dan mudah dikembangkan
* 🚀 Siap digunakan sebagai dasar pengembangan theme selanjutnya

---

## 📂 Project Structure

```text
theme_usi/
├── amd/
│   ├── src/
│   └── build/
├── lang/
├── layout/
├── pix/
├── scss/
├── config.php
├── lib.php
└── version.php
```

---

## 🚀 Installation

1. Salin folder plugin ke direktori Moodle:

```text
<moodle_root>/theme/usi
```

2. Login sebagai Administrator.

3. Buka:

```text
Site administration → Notifications
```

Moodle akan mendeteksi plugin baru dan memulai proses instalasi.

4. Setelah instalasi selesai, aktifkan theme melalui:

```text
Site administration → Appearance → Theme selector
```

5. Terakhir, lakukan:

```text
Site administration → Development → Purge all caches
```

---

## 🛠 Development

### SCSS

Seluruh styling berada pada folder:

```text
scss/
```

* `pre.scss` → konfigurasi sebelum Boost preset
* `post.scss` → styling utama theme

---

### Layout

Kustomisasi halaman login berada pada:

```text
layout/login.php
```

---

### JavaScript

Theme menggunakan Moodle AMD Module.

Source:

```text
amd/src/login.js
```

Setelah melakukan perubahan, compile kembali menggunakan Grunt:

```bash
cd <moodle_root>

npm install
npx grunt amd --root=theme/usi
```

File hasil build akan berada pada:

```text
amd/build/
```

---

## 📋 Compatibility

Pastikan nilai:

```php
$plugin->requires
```

pada `version.php` sesuai dengan versi Moodle yang digunakan.

---

## 📌 Notes

* Theme ini merupakan **child theme**, sehingga seluruh komponen utama tetap menggunakan Boost.
* Disarankan menyimpan seluruh kustomisasi melalui plugin ini, bukan melalui konfigurasi Theme Boost, agar perubahan dapat dikelola menggunakan version control (Git).
* Setelah melakukan perubahan pada SCSS atau layout, jangan lupa melakukan **Purge all caches** agar perubahan langsung diterapkan.

---

## 🤝 Contributing

Pengembangan theme sebaiknya mengikuti workflow Git agar setiap perubahan terdokumentasi dengan baik melalui commit dan branch.

---

## 📄 License

Internal use.
