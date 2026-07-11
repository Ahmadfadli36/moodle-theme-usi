# theme_usi

Child theme dari Boost untuk LMS Hybrid Universitas Sains Indonesia.
Berisi kustomisasi halaman login (heading, logo, styling) yang sebelumnya
ditaruh manual di "Raw SCSS" + "Additional HTML" pada tema Boost.

## Struktur

```
theme_usi/
├── config.php              // definisi tema, parent = boost
├── version.php              // sesuaikan $plugin->requires dgn versi Moodle-mu
├── lib.php                  // helper penyusun SCSS (pre + preset boost + post)
├── scss/
│   ├── pre.scss             // override variabel sebelum preset boost (kosong utk sekarang)
│   └── post.scss            // isi CSS login page kamu (dipindah apa adanya)
├── layout/
│   └── login.php            // copy layout login boost + panggil AMD module kita
├── amd/
│   ├── src/login.js         // source AMD (untuk di-compile grunt)
│   └── build/login.min.js   // fallback compiled version (belum di-minify asli)
├── lang/en/theme_usi.php
└── pix/                     // taruh logo/asset custom di sini kalau perlu
```

## Cara pasang di server

1. `version.php` sudah di-set untuk **Moodle 5.0.8+ (Build: 20260624)**
   sesuai server `lms2` kamu. Kalau dipasang di `new-lms-usi` atau `sip-usi`
   dan versi Moodle-nya beda, cek dulu di **Site administration > Server >
   Environment** lalu sesuaikan `$plugin->requires` di `version.php`.

2. Upload folder ini ke:
   ```
   <moodle_root>/theme/usi/
   ```
   (jadi path lengkapnya `.../theme/usi/config.php`, dst — nama folder HARUS `usi`,
   sesuai `$THEME->name = 'usi'` di config.php)

3. Login sebagai admin, buka **Site administration > Notifications**
   untuk trigger instalasi plugin baru. Moodle akan mendeteksi `theme_usi`.

4. Set sebagai tema aktif: **Site administration > Appearance > Themes >
   Theme selector**, pilih **USI**.

5. **Hapus** Raw SCSS dan Additional HTML lama yang sekarang nempel di
   tema Boost (di halaman Boost settings), karena sudah dipindah ke
   plugin ini — biar nggak dobel/konflik.

6. Purge all caches: **Site administration > Development > Purge caches**.

## Deploy ke environment lain (lms2, new-lms-usi, sip-usi)

Karena sekarang ini plugin, tinggal:
```bash
# zip foldernya, atau kalau sudah di git:
git clone <repo-theme-usi> theme/usi
```
lalu ulangi langkah 3–6 di atas di tiap server. Nggak perlu copy-paste
SCSS/HTML manual lagi lewat UI.

## Soal AMD JS (amd/build/login.min.js)

`amd/build/login.min.js` yang disertakan di sini FUNGSIONAL (bisa langsung
jalan), tapi belum melalui proses minify+sourcemap resmi Moodle. Kalau nanti
kamu develop lebih lanjut dan ubah `amd/src/login.js`, sebaiknya compile ulang
pakai Grunt supaya sourcemap-nya benar (berguna buat debug di browser):

```bash
cd <moodle_root>
npm install
npx grunt amd --root=theme/usi
```

Kalau nggak ada Node/Grunt di server produksi, cukup develop di lokal terus
upload hasil `amd/build/` yang sudah di-compile — jangan grunt langsung di server prod.

## Kalau nanti mau ubah teks/logo

- Teks "SELAMAT DATANG DI" / "MATA KULIAH HYBRID" ada di `amd/src/login.js`
  (dan `amd/build/login.min.js` — jangan lupa update dua-duanya kalau belum grunt).
- Kalau mau logo bukan dari `#loginlogo` bawaan tapi file statis kamu sendiri,
  taruh filenya di `pix/`, lalu ganti `logoSrc` di JS dengan
  `M.cfg.wwwroot + '/theme/usi/pix/logo-usi.png'` (atau pakai
  `theme_image_url` render lewat template kalau mau lebih "Moodle way").

## Setup Git (sekali di awal)

1. **Bikin repo baru di GitHub** (kosong, jangan centang "Add README"):
   `https://github.com/new` → nama repo misal `theme-usi` → visibility
   **Private** disarankan (isinya konfigurasi internal kampus).

2. **Push folder ini ke repo tersebut** dari komputer kamu (bukan dari server):
   ```bash
   cd theme_usi
   git remote add origin git@github.com:Ahmadfadli36/theme-usi.git
   git branch -M main
   git add .
   git commit -m "Initial commit: theme_usi child theme"
   git push -u origin main
   ```
   (Sesuaikan URL remote-nya kalau nama repo beda.)

3. **Setup SSH deploy key di tiap server** (`lms2`, `new-lms-usi`, `sip-usi`)
   supaya server bisa `git pull` dari repo private tanpa password tiap kali:
   ```bash
   # di server, generate key khusus buat ini (bukan key SSH login kamu):
   ssh-keygen -t ed25519 -f ~/.ssh/theme_usi_deploy -N ""
   cat ~/.ssh/theme_usi_deploy.pub
   ```
   Copy output-nya, lalu di GitHub: repo → **Settings > Deploy keys > Add
   deploy key** → paste, centang **Allow write access** kalau server itu
   juga mau push balik (biasanya cukup read-only / tidak dicentang).

   Tambahkan config SSH biar `git pull` otomatis pakai key ini:
   ```bash
   cat >> ~/.ssh/config << 'EOF'
   Host github-theme-usi
       HostName github.com
       User git
       IdentityFile ~/.ssh/theme_usi_deploy
       IdentitiesOnly yes
   EOF
   ```

4. **Clone pertama kali di tiap server** (ganti folder `theme/usi` yang lama
   dengan hasil clone):
   ```bash
   cd /var/www/lms2.sains.ac.id/theme
   mv usi usi.bak   # backup dulu kalau sudah pernah ada
   git clone github-theme-usi:Ahmadfadli36/theme-usi.git usi
   chown -R www-data:www-data usi
   ```
   Ulangi di `new-lms-usi` dan `sip-usi` (path `theme/` beda sesuai domain
   masing-masing).

## Workflow update sehari-hari (setelah setup awal)

Di komputer kamu:
```bash
cd theme_usi
# edit file (scss/post.scss, amd/src/login.js, dll)
git add .
git commit -m "Update: deskripsi perubahan"
git push
```

Di tiap server:
```bash
cd /var/www/<domain>/theme/usi
git pull
sudo bash deploy.sh /var/www/<domain>
```
`deploy.sh` otomatis fix ownership ke `www-data` dan purge Moodle caches.
Nggak perlu WinSCP atau upload ZIP lewat UI installer lagi — itu cuma
dipakai sekali di awal buat register plugin ke database Moodle.

**Kalau mau lebih otomatis lagi** (gak perlu SSH manual tiap server tiap
update), langkah selanjutnya yang bisa dieksplorasi: GitHub Actions yang
`ssh` ke tiap server dan jalanin `git pull` + `deploy.sh` otomatis begitu
ada push ke `main`. Bilang aja kalau kamu mau aku bantu setup itu juga.
