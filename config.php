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
 * Theme config for theme_usi, a child theme of Boost.
 *
 * @package   theme_usi
 * @copyright 2026 Universitas Sains Indonesia
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$THEME->name = 'usi';
$THEME->parents = ['boost'];

// Kosongkan, kita generate semua CSS lewat SCSS (pre.scss + boost preset + post.scss).
$THEME->sheets = [];
$THEME->editor_sheets = [];

// Warisi semua fitur dasar dari boost.
$THEME->enable_dock = false;
$THEME->yuicssmodules = [];
$THEME->rendererfactory = 'theme_overridden_renderer_factory';
$THEME->requiredblocks = '';
$THEME->addblockposition = BLOCK_ADDBLOCK_POSITION_FLATNAV;
$THEME->usescourseindex = true;
$THEME->haseditswitch = true;
$THEME->activityheaderconfig = [
    'notitle' => false,
];

// SCSS entry point.
$THEME->scss = function($theme) {
    return theme_usi_get_main_scss_content($theme);
};

// Preset SCSS files yang boleh dipilih di Appearance > Themes > USI.
$THEME->presets = ['default.scss'];
$THEME->prescsscallback = 'theme_usi_get_pre_scss';
$THEME->extrascsscallback = 'theme_usi_get_extra_scss';

// Override layout login supaya bisa panggil JS module cuma di halaman login.
$THEME->layouts = [
    'login' => [
        'file' => 'login.php',
        'regions' => [],
    ],
];
