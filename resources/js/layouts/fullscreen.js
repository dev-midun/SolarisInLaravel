"use strict";

(function () {
    const elem = document.documentElement;
    function openFullscreen() {
        console.log('test...')
        if (!document.fullscreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
            requestFullscreen();
        } else {
            exitFullscreen();
        }
    }

    function requestFullscreen() {
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) {
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
        }
    }

    function exitFullscreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }

    document.querySelector('#header-fullscreen').addEventListener('click', openFullscreen)
})()