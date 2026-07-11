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
 * Custom login page heading/logo injection for theme_usi.
 * Ini versi AMD dari script yang sebelumnya ditaruh di "Additional HTML".
 * Bedanya: sekarang cuma di-load di halaman login (lihat layout/login.php),
 * jadi tidak jalan global di semua halaman lagi.
 *
 * @module    theme_usi/login
 * @copyright 2026 Universitas Sains Indonesia
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define([], function() {

    /**
     * Bangun markup heading custom USI dan pasang di atas form login,
     * menggantikan logo bawaan Moodle (#loginlogo) kalau ada.
     */
    var injectHeading = function() {
        var loginform = document.querySelector('.loginform');
        if (!loginform) {
            return;
        }

        var nativeLogo = document.getElementById('loginlogo');
        var logoSrc = '';
        if (nativeLogo) {
            var nativeImg = nativeLogo.querySelector('img');
            if (nativeImg) {
                logoSrc = nativeImg.getAttribute('src');
            }
        }

        var customHeading = document.createElement('div');
        customHeading.className = 'login-heading-usi';
        customHeading.innerHTML =
            '<p class="line1">SELAMAT DATANG DI</p>' +
            '<p class="line2">LEARNING MANAGEMENT SYSTEM</p>' +
            '<p class="line3"><span class="highlight">MATA KULIAH HYBRID</span></p>' +
            '<div class="login-logo-usi">' +
                (logoSrc ? '<img class="placeholder-icon" src="' + logoSrc + '" alt="Logo USI">' : '') +
                '<span>UNIVERSITAS<br>SAINS INDONESIA</span>' +
            '</div>';

        if (nativeLogo) {
            nativeLogo.replaceWith(customHeading);
        } else {
            loginform.insertBefore(customHeading, loginform.firstChild);
        }
    };

    return {
        /**
         * Entry point, dipanggil dari layout/login.php lewat $PAGE->requires->js_call_amd().
         */
        init: function() {
            injectHeading();
        }
    };
});
