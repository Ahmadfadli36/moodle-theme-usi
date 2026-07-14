# theme_usi

Child theme dari Boost untuk LMS Hybrid Universitas Sains Indonesia.
Berisi kustomisasi halaman login (heading, logo, styling) yang sebelumnya
ditaruh manual di "Raw SCSS" + "Additional HTML" pada tema Boost.

Dirancang untuk dipakai di beberapa environment sekaligus (`lms2`,
`new-lms-usi`, `sip-usi`, atau instance Moodle lain), jadi semua path di
bawah pakai placeholder `<domain>` / `<moodle_root>` — ganti sesuai server
yang kamu pasang.

## Struktur

```
theme_usi/
├── config.php              // definisi tema, parent = boost
├── version.php              // syarat versi minimum Moodle
├── lib.php                  // helper penyusun SCSS (pre + preset boost + post)
├── scss/
│   ├── pre.scss             // override variabel sebelum preset boost
│   └── post.scss            // custom CSS (login page, dashboard, dll)
├── layout/
│   └── login.php            // copy layout login boost + panggil AMD module kita
├── amd/
│   ├── src/login.js         // source AMD (untuk di-compile grunt)
│   └── build/login.min.js   // fallback compiled version
├── lang/en/theme_usi.php
├── deploy.sh                 // helper: fix ownership + purge cache di server
└── pix/                     // taruh logo/asset custom di sini kalau perlu
```

## Syarat versi Moodle

`version.php` isinya `$plugin->requires` — angka minimum versi Moodle yang
kompatibel. Sebelum pasang ke environment baru, cek dulu versi Moodle
server itu di **Site administration > Server > Environment**, dan pastikan
`$plugin->requires` di `version.php` nggak lebih tinggi dari versi Moodle
di server tersebut (kalau beda jauh, sesuaikan angkanya — nomor versi resmi
tiap branch Moodle bisa dicek di repo `moodle/moodle` pada file
`version.php` branch yang sesuai, misal `MOODLE_500_STABLE`).

## Instalasi pertama kali (per server)

1. Upload folder ini ke:
   ```
   <moodle_root>/theme/usi/
   ```
   (path lengkapnya jadi `.../theme/usi/config.php`, dst — nama folder
   HARUS `usi`, sesuai `$THEME->name = 'usi'` di `config.php`)

2. Pastikan folder `theme/` di server itu writable oleh user PHP-FPM
   (biasanya `www-data`), khusus buat proses instalasi via UI. Cek dulu:
   ```bash
   ls -la <moodle_root>/theme
   ```
   Kalau ownernya bukan user PHP-FPM, set dulu:
   ```bash
   sudo chown -R www-data:www-data <moodle_root>/theme
   ```
   (sesuaikan `www-data` kalau pool PHP-FPM di servermu pakai user lain —
   cek dengan `grep -E "^user|^group" /etc/php/*/fpm/pool.d/*.conf`)

3. Login sebagai admin, buka **Site administration > Notifications**
   untuk trigger instalasi plugin baru. Moodle akan mendeteksi `theme_usi`.

4. Set sebagai tema aktif: **Site administration > Appearance > Themes >
   Theme selector**, pilih **USI**.

5. Kalau sebelumnya tema Boost di server itu punya Raw SCSS / Additional
   HTML manual yang isinya tumpang tindih sama plugin ini — **hapus** dulu
   biar nggak dobel/konflik.

6. Purge all caches: **Site administration > Development > Purge caches**.

## Update konten setelah instalasi pertama

Setelah plugin ter-install, **nggak perlu upload ZIP lewat UI lagi** buat
setiap perubahan kecil (ubah CSS, teks, dll). Cukup timpa file yang
relevan di server (lewat SCP/WinSCP atau `git pull`, lihat bagian Git di
bawah), lalu purge cache:
```bash
php <moodle_root>/admin/cli/purge_caches.php
```
ZIP installer di UI cuma perlu dipakai lagi kalau ada perubahan struktural
yang butuh Moodle re-register plugin (jarang terjadi untuk sekadar ubah
styling).

## Soal AMD JS (amd/build/login.min.js)

`amd/build/login.min.js` yang disertakan di sini FUNGSIONAL (bisa langsung
jalan), tapi belum melalui proses minify+sourcemap resmi Moodle. Kalau
kamu develop lebih lanjut dan ubah `amd/src/login.js`, sebaiknya compile
ulang pakai Grunt supaya sourcemap-nya benar (berguna buat debug di
browser):

```bash
cd <moodle_root>
npm install
npx grunt amd --root=theme/usi
```

Kalau nggak ada Node/Grunt di server produksi, develop di lokal dulu lalu
upload hasil `amd/build/` yang sudah di-compile — jangan grunt langsung di
server produksi.

## Kalau nanti mau ubah teks/logo

- **Cara termudah sekarang**: lewat *Site administration > Appearance >
  Themes > USI* (klik ikon gear ⚙️), tab **General** — teks baris 1/2/3
  heading login dan toggle tampil/sembunyikan bisa diubah langsung dari
  situ, nggak perlu edit kode.
- Kalau mau ubah lebih dalam (struktur HTML, dsb), source-nya ada di
  `amd/src/login.js` (dan `amd/build/login.min.js` — update dua-duanya
  kalau belum sempat grunt).
- Kalau mau logo dari file statis sendiri (bukan `#loginlogo` bawaan),
  taruh filenya di `pix/`, lalu ganti `logoSrc` di JS dengan
  `M.cfg.wwwroot + '/theme/usi/pix/nama-file.png'`.

## Settings dari UI (gear icon ⚙️)

Sekarang `theme_usi` punya halaman settings sendiri, sama seperti Boost/
Classic, diakses lewat ikon gear di kartu tema pada halaman *Themes*. Ada
2 tab:

- **General**: pilih preset, toggle tampil/sembunyikan heading custom
  login, dan teks baris 1/2/3 heading tersebut.
- **Advanced**: *Raw initial SCSS* (di-compile sebelum preset — buat
  override variabel Bootstrap) dan *Raw SCSS* (di-compile setelah
  `scss/post.scss` — buat quick-fix styling langsung dari UI tanpa perlu
  `git push`/`git pull` ke server dulu).

Setelah ubah setting apapun di sini, Moodle otomatis purge theme cache
sendiri (lewat `theme_reset_all_caches`), jadi nggak perlu manual purge
lagi untuk perubahan lewat UI ini.

## Setup Git (sekali di awal)

1. **Bikin repo baru di GitHub** (kosong, jangan centang "Add README"):
   `https://github.com/new`, visibility **Private** disarankan (isinya
   konfigurasi internal kampus).

2. **Push folder ini ke repo tersebut** dari komputer kamu (bukan dari
   server):
   ```bash
   cd theme_usi
   git remote add origin <url-repo-kamu>
   git branch -M main
   git add .
   git commit -m "Initial commit: theme_usi child theme"
   git push -u origin main
   ```

3. **Setup SSH deploy key di tiap server** supaya server bisa `git pull`
   dari repo private tanpa password tiap kali:
   ```bash
   # di server, generate key khusus buat ini (bukan key SSH login kamu):
   ssh-keygen -t ed25519 -f ~/.ssh/theme_usi_deploy -N ""
   cat ~/.ssh/theme_usi_deploy.pub
   ```
   Copy output-nya, lalu di GitHub: repo → **Settings > Deploy keys > Add
   deploy key** → paste. Centang **Allow write access** hanya kalau server
   itu juga perlu push balik (biasanya cukup read-only).

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

4. **Clone pertama kali di tiap server** (ganti folder `theme/usi` yang
   lama dengan hasil clone):
   ```bash
   cd <moodle_root>/theme
   mv usi usi.bak   # backup dulu kalau sudah pernah ada
   git clone github-theme-usi:<username>/<nama-repo>.git usi
   chown -R www-data:www-data usi
   ```
   Ulangi langkah 3–4 ini di setiap server (`lms2`, `new-lms-usi`,
   `sip-usi`, dst) — masing-masing dengan `<moodle_root>` sendiri.

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
cd <moodle_root>/theme/usi
git pull
sudo bash deploy.sh <moodle_root>
```
`deploy.sh` otomatis fix ownership ke `www-data` dan purge Moodle caches.

**Kalau mau lebih otomatis lagi** (nggak perlu SSH manual tiap server tiap
update), langkah selanjutnya yang bisa dieksplorasi: GitHub Actions yang
`ssh` ke tiap server dan jalanin `git pull` + `deploy.sh` otomatis begitu
ada push ke `main`.
