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
 * Settings for theme_usi.
 *
 * @package   theme_usi
 * @copyright 2026 Universitas Sains Indonesia
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    // Pakai kerangka tab settings yang sama dengan Boost, biar tampilannya konsisten.
    $settings = new theme_boost_admin_settingspage_tabs('themesettingusi', get_string('configtitle', 'theme_usi'));

    // ------------------------------------------------------------------
    // Tab: General
    // ------------------------------------------------------------------
    $page = new admin_settingpage('theme_usi_general', get_string('generalsettings', 'theme_usi'));

    // Preset SCSS (default.scss bawaan Boost untuk sekarang; taruh file preset
    // tambahan di scss/preset/ kalau nanti mau bikin varian warna lain).
    $name = 'theme_usi/preset';
    $title = get_string('preset', 'theme_usi');
    $description = get_string('preset_desc', 'theme_usi');
    $default = 'default.scss';

    $context = context_system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'theme_usi', 'preset', 0, 'itemid, filepath, filename', false);

    $choices = [];
    foreach ($files as $file) {
        $choices[$file->get_filename()] = $file->get_filename();
    }
    $choices['default.scss'] = 'default.scss';

    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Toggle teks welcome custom di halaman login (on/off).
    $name = 'theme_usi/showloginheading';
    $title = get_string('showloginheading', 'theme_usi');
    $description = get_string('showloginheading_desc', 'theme_usi');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Baris 1-3 teks welcome, supaya bisa diubah tanpa edit kode JS.
    $name = 'theme_usi/loginheadingline1';
    $title = get_string('loginheadingline1', 'theme_usi');
    $description = get_string('loginheadingline1_desc', 'theme_usi');
    $default = 'SELAMAT DATANG DI';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_usi/loginheadingline2';
    $title = get_string('loginheadingline2', 'theme_usi');
    $description = get_string('loginheadingline2_desc', 'theme_usi');
    $default = 'LEARNING MANAGEMENT SYSTEM';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_usi/loginheadingline3';
    $title = get_string('loginheadingline3', 'theme_usi');
    $description = get_string('loginheadingline3_desc', 'theme_usi');
    $default = 'MATA KULIAH HYBRID';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);

    // ------------------------------------------------------------------
    // Tab: Advanced
    // ------------------------------------------------------------------
    $page = new admin_settingpage('theme_usi_advanced', get_string('advancedsettings', 'theme_usi'));

    // Raw initial SCSS - dieksekusi SEBELUM preset (mis. override variabel Bootstrap).
    $name = 'theme_usi/scsspre';
    $title = get_string('rawscsspre', 'theme_usi');
    $description = get_string('rawscsspre_desc', 'theme_usi');
    $default = '';
    $setting = new admin_setting_scsscode($name, $title, $description, $default, PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS tambahan - dieksekusi SETELAH scss/post.scss milik plugin.
    // Ini yang paling praktis buat quick-fix styling dari UI tanpa perlu
    // git push + git pull ke server dulu.
    $name = 'theme_usi/scss';
    $title = get_string('rawscss', 'theme_usi');
    $description = get_string('rawscss_desc', 'theme_usi');
    $default = '';
    $setting = new admin_setting_scsscode($name, $title, $description, $default, PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);
}
