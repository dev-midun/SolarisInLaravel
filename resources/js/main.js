"use strict";

import './layouts/main';
import LayoutMenu from './layouts/layout-menu';
import CustomSwitcher from './layouts/custom-switcher';
import './layouts/custom';
import './layouts/fullscreen';

(() => {
    new LayoutMenu();
    new CustomSwitcher();

    window.addEventListener('scroll', stickyFn);
    var navbar = document.getElementById("sidebar");
    var navbar1 = document.getElementById("header");

    function stickyFn() {
        if (window.scrollY >= 75) {
            navbar.classList.add("sticky-pin")
            navbar1.classList.add("sticky-pin")
        } else {
            navbar.classList.remove("sticky-pin");
            navbar1.classList.remove("sticky-pin");
        }
    }
    window.addEventListener('scroll', stickyFn);
    window.addEventListener('DOMContentLoaded', stickyFn);

    var myElement = document.getElementById('sidebar-scroll');
    new SimpleBar(myElement, { autoHide: true });
})();