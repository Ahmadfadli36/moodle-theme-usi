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
 * dan teksnya bisa diatur dari Site administration > Appearance > Themes >
 * USI (gear icon), bukan hardcode di sini.
 *
 * @module    theme_usi/login
 * @copyright 2026 Universitas Sains Indonesia
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define([], function() {

    /**
     * Escape teks sebelum dipasang lewat innerHTML, biar aman dari HTML injection
     * kalau ada karakter aneh di setting admin.
     *
     * @param {String} text
     * @return {String}
     */
    var escapeHtml = function(text) {
        var div = document.createElement('div');
        div.textContent = text == null ? '' : text;
        return div.innerHTML;
    };

    /**
     * Bangun markup heading custom USI dan pasang di atas form login,
     * menggantikan logo bawaan Moodle (#loginlogo) kalau ada.
     *
     * @param {Object} config
     * @param {String} config.line1
     * @param {String} config.line2
     * @param {String} config.line3
     */
    var injectHeading = function(config) {
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
            '<p class="line1">' + escapeHtml(config.line1) + '</p>' +
            '<p class="line2">' + escapeHtml(config.line2) + '</p>' +
            '<p class="line3"><span class="highlight">' + escapeHtml(config.line3) + '</span></p>' +
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
         *
         * @param {Boolean} showHeading dari setting "showloginheading" (checkbox)
         * @param {String} line1 dari setting "loginheadingline1"
         * @param {String} line2 dari setting "loginheadingline2"
         * @param {String} line3 dari setting "loginheadingline3"
         */
        init: function(showHeading, line1, line2, line3) {
            if (!showHeading) {
                return;
            }
            injectHeading({
                line1: line1,
                line2: line2,
                line3: line3
            });
        }
    };
});
