#!/bin/bash
# deploy.sh - jalankan di server SETELAH `git pull` di dalam theme/usi
# supaya Moodle re-compile SCSS/JS dan cache lama dibuang.
#
# Cara pakai:
#   cd /var/www/<domain>/theme/usi
#   git pull
#   sudo bash deploy.sh /var/www/<domain>
#
# Kalau service PHP-FPM/nginx-mu beda nama, sesuaikan bagian restart di bawah.

set -e

MOODLE_ROOT="$1"

if [ -z "$MOODLE_ROOT" ]; then
    echo "Usage: sudo bash deploy.sh /path/to/moodle/root"
    echo "Contoh: sudo bash deploy.sh /var/www/lms2.sains.ac.id"
    exit 1
fi

if [ ! -f "$MOODLE_ROOT/admin/cli/purge_caches.php" ]; then
    echo "Path Moodle root sepertinya salah: $MOODLE_ROOT"
    echo "(admin/cli/purge_caches.php tidak ditemukan di situ)"
    exit 1
fi

echo "==> Fix ownership theme/usi ke www-data (biar konsisten dgn folder lain)"
chown -R www-data:www-data "$MOODLE_ROOT/theme/usi"

echo "==> Purge Moodle caches (SCSS/JS akan di-compile ulang)"
sudo -u www-data php "$MOODLE_ROOT/admin/cli/purge_caches.php"

echo "==> Selesai. Cek halaman login untuk verifikasi perubahan."
