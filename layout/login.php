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
 * A login page layout for theme_usi.
 * Sama persis dengan layout/login.php milik Boost, ditambah satu baris
 * untuk memanggil AMD module theme_usi/login HANYA di halaman ini.
 *
 * @package   theme_usi
 * @copyright 2026 Universitas Sains Indonesia, based on theme_boost by Damyon Wiese (2016)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Panggil JS custom kita, scoped ke halaman login saja (bukan global lagi).
// Nilai-nilai ini diambil dari Site administration > Appearance > Themes >
// USI (gear icon) > tab General, bukan hardcode.
$showloginheading = !empty($PAGE->theme->settings->showloginheading);
$loginheadingline1 = $PAGE->theme->settings->loginheadingline1 ?? '';
$loginheadingline2 = $PAGE->theme->settings->loginheadingline2 ?? '';
$loginheadingline3 = $PAGE->theme->settings->loginheadingline3 ?? '';

$PAGE->requires->js_call_amd('theme_usi/login', 'init', [
    $showloginheading,
    $loginheadingline1,
    $loginheadingline2,
    $loginheadingline3,
]);

$bodyattributes = $OUTPUT->body_attributes();

$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes
];

echo $OUTPUT->render_from_template('theme_boost/login', $templatecontext);
