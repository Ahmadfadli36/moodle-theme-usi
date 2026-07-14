<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Language strings for theme_usi.
 *
 * @package   theme_usi
 * @copyright 2026 Universitas Sains Indonesia
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'USI';
$string['choosereadme'] = 'Theme USI adalah child theme dari Boost, dikustomisasi untuk LMS Hybrid Universitas Sains Indonesia (halaman login custom, dsb).';
$string['configtitle'] = 'USI';
$string['region-side-pre'] = 'Right';

// Settings tabs.
$string['generalsettings'] = 'General';
$string['advancedsettings'] = 'Advanced';

// General tab.
$string['preset'] = 'Theme preset';
$string['preset_desc'] = 'Pilih preset yang mau dipakai untuk tema ini.';
$string['showloginheading'] = 'Tampilkan heading custom di halaman login';
$string['showloginheading_desc'] = 'Kalau dicentang, heading "Selamat datang..." + logo custom akan ditampilkan menggantikan logo bawaan Moodle di halaman login.';
$string['loginheadingline1'] = 'Teks baris 1 (heading login)';
$string['loginheadingline1_desc'] = 'Contoh: SELAMAT DATANG DI';
$string['loginheadingline2'] = 'Teks baris 2 (heading login)';
$string['loginheadingline2_desc'] = 'Contoh: LEARNING MANAGEMENT SYSTEM';
$string['loginheadingline3'] = 'Teks baris 3 (heading login, dengan highlight)';
$string['loginheadingline3_desc'] = 'Contoh: MATA KULIAH HYBRID';

// Advanced tab.
$string['rawscsspre'] = 'Raw initial SCSS';
$string['rawscsspre_desc'] = 'Kode SCSS ini akan di-compile SEBELUM preset (mis. untuk override variabel Bootstrap seperti $primary). Untuk pengguna tingkat lanjut.';
$string['rawscss'] = 'Raw SCSS';
$string['rawscss_desc'] = 'Kode SCSS tambahan ini akan di-compile SETELAH scss/post.scss milik plugin. Berguna untuk quick-fix styling langsung dari sini tanpa perlu git push/pull ke server.';
