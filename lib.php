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
 * Theme functions for theme_usi.
 *
 * @package   theme_usi
 * @copyright 2026 Universitas Sains Indonesia
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Susun urutan: variabel kita (pre) -> preset default Boost -> override kita (post).
 * Ini pola standar child theme Boost.
 *
 * @param theme_config $theme
 * @return string SCSS lengkap yang mau di-compile
 */
function theme_usi_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';
    $filename = !empty($theme->settings->preset) ? $theme->settings->preset : 'default.scss';

    // 1. Pre-variables (punya kita).
    $scss .= theme_usi_get_pre_scss($theme);

    // 2. Preset asli dari Boost (default.scss) sebagai basis.
    $presetfile = $CFG->dirroot . '/theme/boost/scss/preset/' . $filename;
    if (file_exists($presetfile)) {
        $scss .= file_get_contents($presetfile);
    } else {
        // Fallback kalau nama preset custom tidak ditemukan di boost.
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    }

    // 3. Override / tambahan kita (post) -> tempat CSS login page kamu.
    $scss .= theme_usi_get_extra_scss($theme);

    return $scss;
}

/**
 * Variabel SCSS yang perlu di-set SEBELUM Boost preset di-compile
 * (mis. override warna dasar $primary, dsb kalau nanti dibutuhkan).
 *
 * @param theme_config $theme
 * @return string
 */
function theme_usi_get_pre_scss($theme) {
    global $CFG;

    $scss = '';
    $prefile = $CFG->dirroot . '/theme/usi/scss/pre.scss';
    if (file_exists($prefile)) {
        $scss .= file_get_contents($prefile);
    }

    // Tambahan dari Site administration > Appearance > Themes > USI (gear icon)
    // tab Advanced > "Raw initial SCSS". Berguna buat quick-fix tanpa git push/pull.
    if (!empty($theme->settings->scsspre)) {
        $scss .= "\n" . $theme->settings->scsspre;
    }

    return $scss;
}

/**
 * SCSS tambahan yang di-compile SETELAH Boost preset.
 * Ini tempat semua custom CSS login page kamu sekarang tinggal.
 *
 * @param theme_config $theme
 * @return string
 */
function theme_usi_get_extra_scss($theme) {
    global $CFG;

    $scss = '';
    $postfile = $CFG->dirroot . '/theme/usi/scss/post.scss';
    if (file_exists($postfile)) {
        $scss .= file_get_contents($postfile);
    }

    // Tambahan dari Site administration > Appearance > Themes > USI (gear icon)
    // tab Advanced > "Raw SCSS". Berguna buat quick-fix tanpa git push/pull.
    if (!empty($theme->settings->scss)) {
        $scss .= "\n" . $theme->settings->scss;
    }

    return $scss;
}
