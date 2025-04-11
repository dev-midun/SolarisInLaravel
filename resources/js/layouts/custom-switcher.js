"use strict";

import LayoutMenu from "./layout-menu";

let mainContent;
export default class CustomSwitcher {
    constructor() {
        this.init()
    }

    init() {
        mainContent = document.querySelector('.main-content');
        CustomSwitcher.localStorageBackup2();
        CustomSwitcher.switcherClick();
        CustomSwitcher.checkOptions();
        setTimeout(() => {
            CustomSwitcher.checkOptions();
        }, 1000);
    }

    static switcherClick() {
        let ltrBtn, rtlBtn, verticalBtn, horiBtn, lightBtn, darkBtn, boxedBtn, fullwidthBtn, scrollHeaderBtn, scrollMenuBtn, fixedHeaderBtn, fixedMenuBtn, lightHeaderBtn, darkHeaderBtn, colorHeaderBtn, gradientHeaderBtn, lightMenuBtn, darkMenuBtn, colorMenuBtn, gradientMenuBtn, transparentMenuBtn, transparentHeaderBtn, regular, classic, modern, defaultBtn, closedBtn, iconTextBtn, detachedBtn, overlayBtn, doubleBtn, menuClickBtn, menuHoverBtn, iconClickBtn, iconHoverBtn, primaryDefaultColor1Btn, primaryDefaultColor2Btn, primaryDefaultColor3Btn, primaryDefaultColor4Btn, primaryDefaultColor5Btn, bgDefaultColor1Btn, bgDefaultColor2Btn, bgDefaultColor3Btn, bgDefaultColor4Btn, bgDefaultColor5Btn, bgImage1Btn, bgImage2Btn, bgImage3Btn, bgImage4Btn, bgImage5Btn, ResetAll, resetBtn, loaderEnable, loaderDisable;
        let html = document.querySelector('html');
        lightBtn = document.querySelector('#switcher-light-theme');
        darkBtn = document.querySelector('#switcher-dark-theme');
        ltrBtn = document.querySelector('#switcher-ltr');
        rtlBtn = document.querySelector('#switcher-rtl');
        verticalBtn = document.querySelector('#switcher-vertical');
        horiBtn = document.querySelector('#switcher-horizontal');
        boxedBtn = document.querySelector('#switcher-boxed');
        fullwidthBtn = document.querySelector('#switcher-full-width');
        fixedMenuBtn = document.querySelector('#switcher-menu-fixed');
        scrollMenuBtn = document.querySelector('#switcher-menu-scroll');
        fixedHeaderBtn = document.querySelector('#switcher-header-fixed');
        scrollHeaderBtn = document.querySelector('#switcher-header-scroll');
        lightHeaderBtn = document.querySelector('#switcher-header-light');
        darkHeaderBtn = document.querySelector('#switcher-header-dark');
        colorHeaderBtn = document.querySelector('#switcher-header-primary');
        gradientHeaderBtn = document.querySelector('#switcher-header-gradient');
        transparentHeaderBtn = document.querySelector('#switcher-header-transparent');
        lightMenuBtn = document.querySelector('#switcher-menu-light');
        darkMenuBtn = document.querySelector('#switcher-menu-dark');
        colorMenuBtn = document.querySelector('#switcher-menu-primary');
        gradientMenuBtn = document.querySelector('#switcher-menu-gradient');
        transparentMenuBtn = document.querySelector('#switcher-menu-transparent');
        regular = document.querySelector('#switcher-regular');
        classic = document.querySelector('#switcher-classic');
        modern = document.querySelector('#switcher-modern');
        defaultBtn = document.querySelector('#switcher-default-menu');
        menuClickBtn = document.querySelector('#switcher-menu-click');
        menuHoverBtn = document.querySelector('#switcher-menu-hover');
        iconClickBtn = document.querySelector('#switcher-icon-click');
        iconHoverBtn = document.querySelector('#switcher-icon-hover');
        closedBtn = document.querySelector('#switcher-closed-menu');
        iconTextBtn = document.querySelector('#switcher-icontext-menu');
        overlayBtn = document.querySelector('#switcher-icon-overlay');
        doubleBtn = document.querySelector('#switcher-double-menu');
        detachedBtn = document.querySelector('#switcher-detached');
        resetBtn = document.querySelector('#resetbtn');
        primaryDefaultColor1Btn = document.querySelector('#switcher-primary');
        primaryDefaultColor2Btn = document.querySelector('#switcher-primary1');
        primaryDefaultColor3Btn = document.querySelector('#switcher-primary2');
        primaryDefaultColor4Btn = document.querySelector('#switcher-primary3');
        primaryDefaultColor5Btn = document.querySelector('#switcher-primary4');
        bgDefaultColor1Btn = document.querySelector('#switcher-background');
        bgDefaultColor2Btn = document.querySelector('#switcher-background1');
        bgDefaultColor3Btn = document.querySelector('#switcher-background2');
        bgDefaultColor4Btn = document.querySelector('#switcher-background3');
        bgDefaultColor5Btn = document.querySelector('#switcher-background4');
        bgImage1Btn = document.querySelector('#switcher-bg-img');
        bgImage2Btn = document.querySelector('#switcher-bg-img1');
        bgImage3Btn = document.querySelector('#switcher-bg-img2');
        bgImage4Btn = document.querySelector('#switcher-bg-img3');
        bgImage5Btn = document.querySelector('#switcher-bg-img4');
        ResetAll = document.querySelector('#reset-all');
        // loaderEnable = document.querySelector('#switcher-loader-enable');
        // loaderDisable = document.querySelector('#switcher-loader-disable');
    
        // primary theme
        let primaryColor1Var = primaryDefaultColor1Btn.addEventListener('click', () => {
            localStorage.setItem("primaryRGB", "64, 100, 221");
            html.style.setProperty('--primary-rgb', `64, 100, 221`);
        })
        let primaryColor2Var = primaryDefaultColor2Btn.addEventListener('click', () => {
            localStorage.setItem("primaryRGB", "207, 117, 225");
            html.style.setProperty('--primary-rgb', `207, 117, 225`);
        })
        let primaryColor3Var = primaryDefaultColor3Btn.addEventListener('click', () => {
            localStorage.setItem("primaryRGB", "199, 89, 106");
            html.style.setProperty('--primary-rgb', `199, 89, 106`);
        })
        let primaryColor4Var = primaryDefaultColor4Btn.addEventListener('click', () => {
            localStorage.setItem("primaryRGB", "1, 159, 162");
            html.style.setProperty('--primary-rgb', `1, 159, 162`);
        })
        let primaryColor5Var = primaryDefaultColor5Btn.addEventListener('click', () => {
            localStorage.setItem("primaryRGB", "139, 149, 4");
            html.style.setProperty('--primary-rgb', `139, 149, 4`);
        })
    
        // Background theme
        let backgroundColor1Var = bgDefaultColor1Btn.addEventListener('click', () => {
            localStorage.setItem('bodyBgRGB', "34, 49, 153");
            localStorage.setItem('bodylightRGB', "48, 63, 167");
            html.setAttribute('data-theme-mode', 'dark');
            html.setAttribute('data-menu-styles', 'dark');
            html.setAttribute('data-header-styles', 'dark');
            document.querySelector('html').style.setProperty('--body-bg-rgb', localStorage.bodyBgRGB);
            document.querySelector('html').style.setProperty('--body-bg-rgb2', localStorage.bodylightRGB);
            document.querySelector('html').style.setProperty('--light-rgb', "48, 63, 167");
            document.querySelector('html').style.setProperty('--form-control-bg', "rgb(48, 63, 167)");
            document.querySelector('html').style.setProperty('--input-border', "rgba(255,255,255,0.1)");
            document.querySelector('html').style.setProperty('--gray-3', "rgba(255,255,255,0.1)");
            document.querySelector('#switcher-dark-theme').checked = true;
            document.querySelector('#switcher-menu-dark').checked = true;
            document.querySelector('#switcher-header-dark').checked = true;
            localStorage.setItem("zenoMenu", "dark");
            localStorage.setItem("zenoHeader", "dark");
        })
        let backgroundColor2Var = bgDefaultColor2Btn.addEventListener('click', () => {
            localStorage.setItem('bodyBgRGB', "147, 52, 150");
            localStorage.setItem('bodylightRGB', "161, 66, 164");
            html.setAttribute('data-theme-mode', 'dark');
            html.setAttribute('data-menu-styles', 'dark');
            html.setAttribute('data-header-styles', 'dark');
            document.querySelector('html').style.setProperty('--body-bg-rgb', localStorage.bodyBgRGB);
            document.querySelector('html').style.setProperty('--body-bg-rgb2', localStorage.bodylightRGB);
            document.querySelector('html').style.setProperty('--light-rgb', "161, 66, 164");
            document.querySelector('html').style.setProperty('--form-control-bg', "rgb(161, 66, 164)");
            document.querySelector('html').style.setProperty('--input-border', "rgba(255,255,255,0.1)");
            document.querySelector('html').style.setProperty('--gray-3', "rgba(255,255,255,0.1)");
            document.querySelector('#switcher-dark-theme').checked = true;
            document.querySelector('#switcher-menu-dark').checked = true;
            document.querySelector('#switcher-header-dark').checked = true;
            localStorage.setItem("zenoMenu", "dark");
            localStorage.setItem("zenoHeader", "dark");
        })
        let backgroundColor3Var = bgDefaultColor3Btn.addEventListener('click', () => {
            localStorage.setItem('bodyBgRGB', "135, 44, 47");
            localStorage.setItem('bodylightRGB', "149, 58, 61");
            html.setAttribute('data-theme-mode', 'dark');
            html.setAttribute('data-menu-styles', 'dark');
            html.setAttribute('data-header-styles', 'dark');
            document.querySelector('html').style.setProperty('--body-bg-rgb', localStorage.bodyBgRGB);
            document.querySelector('html').style.setProperty('--body-bg-rgb2', localStorage.bodylightRGB);
            document.querySelector('html').style.setProperty('--light-rgb', "149, 58, 61");
            document.querySelector('html').style.setProperty('--form-control-bg', "rgb(149, 58, 61)");
            document.querySelector('html').style.setProperty('--input-border', "rgba(255,255,255,0.1)");
            document.querySelector('html').style.setProperty('--gray-3', "rgba(255,255,255,0.1)");
            document.querySelector('#switcher-dark-theme').checked = true;
            document.querySelector('#switcher-menu-dark').checked = true;
            document.querySelector('#switcher-header-dark').checked = true;
            localStorage.setItem("zenoMenu", "dark");
            localStorage.setItem("zenoHeader", "dark");
        })
        let backgroundColor4Var = bgDefaultColor4Btn.addEventListener('click', () => {
            localStorage.setItem('bodyBgRGB', "3, 81, 60");
            localStorage.setItem('bodylightRGB', "8, 99, 75");
            html.setAttribute('data-theme-mode', 'dark');
            html.setAttribute('data-menu-styles', 'dark');
            html.setAttribute('data-header-styles', 'dark');
            document.querySelector('html').style.setProperty('--body-bg-rgb', localStorage.bodyBgRGB);
            document.querySelector('html').style.setProperty('--body-bg-rgb2', localStorage.bodylightRGB);
            document.querySelector('html').style.setProperty('--light-rgb', "8, 99, 75");
            document.querySelector('html').style.setProperty('--form-control-bg', "rgb(8, 99, 75)");
            document.querySelector('html').style.setProperty('--input-border', "rgba(255,255,255,0.1)");
            document.querySelector('html').style.setProperty('--gray-3', "rgba(255,255,255,0.1)");
            document.querySelector('#switcher-dark-theme').checked = true;
            document.querySelector('#switcher-menu-dark').checked = true;
            document.querySelector('#switcher-header-dark').checked = true;
            localStorage.setItem("zenoMenu", "dark");
            localStorage.setItem("zenoHeader", "dark");
        })
        let backgroundColor5Var = bgDefaultColor5Btn.addEventListener('click', () => {
            localStorage.setItem('bodyBgRGB', "73, 78, 1");
            localStorage.setItem('bodylightRGB', "84, 89, 4");
            html.setAttribute('data-theme-mode', 'dark');
            html.setAttribute('data-menu-styles', 'dark');
            html.setAttribute('data-header-styles', 'dark');
            document.querySelector('html').style.setProperty('--body-bg-rgb', localStorage.bodyBgRGB);
            document.querySelector('html').style.setProperty('--body-bg-rgb2', localStorage.bodylightRGB);
            document.querySelector('html').style.setProperty('--light-rgb', "84, 89, 4");
            document.querySelector('html').style.setProperty('--form-control-bg', "rgb(84, 89, 4)");
            document.querySelector('html').style.setProperty('--input-border', "rgba(255,255,255,0.1)");
            document.querySelector('html').style.setProperty('--gray-3', "rgba(255,255,255,0.1)");
            document.querySelector('#switcher-dark-theme').checked = true;
            document.querySelector('#switcher-menu-dark').checked = true;
            document.querySelector('#switcher-header-dark').checked = true;
            localStorage.setItem("zenoMenu", "dark");
            localStorage.setItem("zenoHeader", "dark");
        })
    
        // Bg image
        let bgImg1Var = bgImage1Btn.addEventListener('click', () => {
            html.setAttribute('data-bg-img', 'bgimg1')
            localStorage.setItem("bgimg", "bgimg1")
        })
        let bgImg2Var = bgImage2Btn.addEventListener('click', () => {
            html.setAttribute('data-bg-img', 'bgimg2')
            localStorage.setItem("bgimg", "bgimg2")
        })
        let bgImg3Var = bgImage3Btn.addEventListener('click', () => {
            html.setAttribute('data-bg-img', 'bgimg3')
            localStorage.setItem("bgimg", "bgimg3")
        })
        let bgImg4Var = bgImage4Btn.addEventListener('click', () => {
            html.setAttribute('data-bg-img', 'bgimg4')
            localStorage.setItem("bgimg", "bgimg4")
        })
        let bgImg5Var = bgImage5Btn.addEventListener('click', () => {
            html.setAttribute('data-bg-img', 'bgimg5')
            localStorage.setItem("bgimg", "bgimg5")
        })
    
        /* Light Layout Start */
        let lightThemeVar = lightBtn.addEventListener('click', () => {
            CustomSwitcher.lightFn();
            localStorage.setItem("zenoHeader", 'light');
            localStorage.removeItem("bodylightRGB")
            localStorage.removeItem("bodyBgRGB")
            localStorage.removeItem("zenoMenu")
            if (html.getAttribute('data-nav-layout') === 'horizontal') {
                html.setAttribute('data-header-styles', 'light');
            }
        })
        /* Light Layout End */
    
        /* Dark Layout Start */
        let darkThemeVar = darkBtn.addEventListener('click', () => {
            CustomSwitcher.darkFn();
            localStorage.setItem("zenoMenu", 'dark');
            localStorage.setItem("zenoHeader", 'transparent');
            if (html.getAttribute('data-nav-layout') === 'horizontal') {
                html.setAttribute('data-header-styles', 'dark');
            }
        });
        /* Dark Layout End */
    
        /* Light Menu Start */
        let lightMenuVar = lightMenuBtn.addEventListener('click', () => {
            html.setAttribute('data-menu-styles', 'light');
            localStorage.setItem("zenoMenu", 'light');
        });
        /* Light Menu End */
    
        /* Color Menu Start */
        let colorMenuVar = colorMenuBtn.addEventListener('click', () => {
            html.setAttribute('data-menu-styles', 'color');
            localStorage.setItem("zenoMenu", 'color');
        });
        /* Color Menu End */
    
        /* Dark Menu Start */
        let darkMenuVar = darkMenuBtn.addEventListener('click', () => {
            html.setAttribute('data-menu-styles', 'dark');
            localStorage.setItem("zenoMenu", 'dark');
        });
        /* Dark Menu End */
    
        /* Gradient Menu Start */
        let gradientMenuVar = gradientMenuBtn.addEventListener('click', () => {
            html.setAttribute('data-menu-styles', 'gradient');
            localStorage.setItem("zenoMenu", 'gradient');
        });
        /* Gradient Menu End */
    
        /* Transparent Menu Start */
        let transparentMenuVar = transparentMenuBtn.addEventListener('click', () => {
            html.setAttribute('data-menu-styles', 'transparent');
            localStorage.setItem("zenoMenu", 'transparent');
        });
        /* Transparent Menu End */
    
        /* Light Header Start */
        let lightHeaderVar = lightHeaderBtn.addEventListener('click', () => {
            html.setAttribute('data-header-styles', 'light');
            localStorage.setItem("zenoHeader", 'light');
        });
        /* Light Header End */
    
        /* Color Header Start */
        let colorHeaderVar = colorHeaderBtn.addEventListener('click', () => {
            html.setAttribute('data-header-styles', 'color');
            localStorage.setItem("zenoHeader", 'color');
        });
        /* Color Header End */
    
        /* Dark Header Start */
        let darkHeaderVar = darkHeaderBtn.addEventListener('click', () => {
            html.setAttribute('data-header-styles', 'dark');
            localStorage.setItem("zenoHeader", 'dark');
        });
        /* Dark Header End */
    
        /* Gradient Header Start */
        let gradientHeaderVar = gradientHeaderBtn.addEventListener('click', () => {
            html.setAttribute('data-header-styles', 'gradient');
            localStorage.setItem("zenoHeader", 'gradient');
        });
        /* Gradient Header End */
    
        /* Transparent Header Start */
        let transparentHeaderVar = transparentHeaderBtn.addEventListener('click', () => {
            html.setAttribute('data-header-styles', 'transparent');
            localStorage.setItem("zenoHeader", 'transparent');
        });
        /* Transparent Header End */
    
        /* Full Width Layout Start */
        let fullwidthVar = fullwidthBtn.addEventListener('click', () => {
            html.setAttribute('data-width', 'fullwidth');
            localStorage.setItem("zenofullwidth", true);
            localStorage.removeItem("zenoboxed");
        });
        /* Full Width Layout End */
    
        /* Boxed Layout Start */
        let boxedVar = boxedBtn.addEventListener('click', () => {
            html.setAttribute('data-width', 'boxed');
            localStorage.setItem("zenoboxed", true);
            localStorage.removeItem("zenofullwidth");
            LayoutMenu.checkHoriMenu()
        });
        /* Boxed Layout End */
    
        /* Regular page style Start */
        let shadowVar = regular.addEventListener('click', () => {
            html.setAttribute('data-page-style', 'regular');
            localStorage.setItem("zenoregular", true);
            localStorage.removeItem("zenoclassic");
            localStorage.removeItem("zenomodern");
        });
        /* Regular page style End */
    
        /* Classic page style Start */
        let noShadowVar = classic.addEventListener('click', () => {
            html.setAttribute('data-page-style', 'classic');
            localStorage.setItem("zenoclassic", true);
            localStorage.removeItem("zenoregular");
            localStorage.removeItem("zenomodern");
        });
        /* Classic page style End */
    
        /* modern page style Start */
        let modernVar = modern.addEventListener('click', () => {
            html.setAttribute('data-page-style', 'modern');
            localStorage.setItem("zenomodern", true);
            localStorage.removeItem("zenoregular");
            localStorage.removeItem("zenoclassic");
        });
        /* modern page style End */
    
        /* Header-Position Styles Start */
        let fixedHeaderVar = fixedHeaderBtn.addEventListener('click', () => {
            html.setAttribute('data-header-position', 'fixed');
            localStorage.setItem("zenoheaderfixed", true);
            localStorage.removeItem("zenoheaderscrollable");
        });
    
        let scrollHeaderVar = scrollHeaderBtn.addEventListener('click', () => {
            html.setAttribute('data-header-position', 'scrollable');
            localStorage.setItem("zenoheaderscrollable", true);
            localStorage.removeItem("zenoheaderfixed");
        });
        /* Header-Position Styles End */
    
        /* Menu-Position Styles Start */
        let fixedMenuVar = fixedMenuBtn.addEventListener('click', () => {
            html.setAttribute('data-menu-position', 'fixed');
            localStorage.setItem("zenomenufixed", true);
            localStorage.removeItem("zenomenuscrollable");
        });
    
        let scrollMenuVar = scrollMenuBtn.addEventListener('click', () => {
            html.setAttribute('data-menu-position', 'scrollable');
            localStorage.setItem("zenomenuscrollable", true);
            localStorage.removeItem("zenomenufixed");
        });
        /* Menu-Position Styles End */
    
        /* Default Sidemenu Start */
        let defaultVar = defaultBtn.addEventListener('click', () => {
            html.setAttribute('data-vertical-style', 'default');
            html.setAttribute('data-nav-layout', 'vertical');
            localStorage.removeItem('zenonavstyles');
            LayoutMenu.toggleSidemenu();
            localStorage.removeItem("zenoverticalstyles");
            document.querySelectorAll(".main-menu>li.open").forEach((ele) => {
                if (!ele.classList.contains('active')) {
                    ele.classList.remove('open')
                    ele.querySelector('ul').style.display = 'none'
                }
            })
        });
        /* Default Sidemenu End */
    
        /* Closed Sidemenu Start */
        let closedVar = closedBtn.addEventListener('click', () => {
            LayoutMenu.closedSidemenuFn();
            localStorage.setItem("zenoverticalstyles", 'closed');
            document.querySelectorAll(".main-menu>li.open").forEach((ele) => {
                if (!ele.classList.contains('active')) {
                    ele.classList.remove('open')
                    ele.querySelector('ul').style.display = 'none'
                }
            })
        });
        /* Closed Sidemenu End */
    
        /* Hover Submenu Start */
        let detachedVar = detachedBtn.addEventListener('click', () => {
            LayoutMenu.detachedFn();
            localStorage.setItem("zenoverticalstyles", 'detached');
        });
        /* Hover Submenu End */
    
        /* Icon Text Sidemenu Start */
        let iconTextVar = iconTextBtn.addEventListener('click', () => {
            LayoutMenu.iconTextFn();
            localStorage.setItem("zenoverticalstyles", 'icontext');
        });
        /* Icon Text Sidemenu End */
    
        /* Icon Overlay Sidemenu Start */
        let overlayVar = overlayBtn.addEventListener('click', () => {
            LayoutMenu.iconOverayFn();
            localStorage.setItem("zenoverticalstyles", 'overlay');
            document.querySelectorAll(".main-menu>li.open").forEach((ele) => {
                if (!ele.classList.contains('active')) {
                    ele.classList.remove('open')
                    ele.querySelector('ul').style.display = 'none'
                }
            })
        });
        /* Icon Overlay Sidemenu End */
    
        /* doublemenu Sidemenu Start */
        let doubleVar = doubleBtn.addEventListener('click', () => {
            LayoutMenu.doubletFn();
            localStorage.removeItem('zenonavstyles');
            localStorage.setItem("zenoverticalstyles", 'doublemenu');
        });
        /* doublemenu Sidemenu End */
    
        /* Menu Click Sidemenu Start */
        let menuClickVar = menuClickBtn.addEventListener('click', () => {
            html.removeAttribute('data-vertical-style');
            LayoutMenu.menuClickFn();
            localStorage.setItem("zenonavstyles", 'menu-click');
            localStorage.removeItem("zenoverticalstyles");
            document.querySelectorAll(".main-menu>li.open").forEach((ele) => {
                if (!ele.classList.contains('active')) {
                    ele.classList.remove('open')
                    ele.querySelector('ul').style.display = 'none'
                }
            })
            if (document.querySelector("html").getAttribute("data-nav-layout") == 'horizontal') {
                document.querySelector(".main-menu").style.marginLeft = "0px"
                document.querySelector(".main-menu").style.marginRight = "0px"
                LayoutMenu.ResizeMenu()
            }
        });
        /* Menu Click Sidemenu End */
    
        /* Menu Hover Sidemenu Start */
        let menuhoverVar = menuHoverBtn.addEventListener('click', () => {
            html.removeAttribute('data-vertical-style');
            LayoutMenu.menuhoverFn();
            localStorage.setItem("zenonavstyles", 'menu-hover');
            localStorage.removeItem("zenoverticalstyles");
    
            if (document.querySelector("html").getAttribute("data-nav-layout") == 'horizontal') {
                document.querySelector(".main-menu").style.marginLeft = "0px"
                document.querySelector(".main-menu").style.marginRight = "0px"
                LayoutMenu.ResizeMenu()
            }
        });
        /* Menu Hover Sidemenu End */
    
        /* icon Click Sidemenu Start */
        let iconClickVar = iconClickBtn.addEventListener('click', () => {
            html.removeAttribute('data-vertical-style');
            LayoutMenu.iconClickFn();
            localStorage.setItem("zenonavstyles", 'icon-click');
            localStorage.removeItem("zenoverticalstyles");
    
            if (document.querySelector("html").getAttribute("data-nav-layout") == 'horizontal') {
                document.querySelector(".main-menu").style.marginLeft = "0px"
                document.querySelector(".main-menu").style.marginRight = "0px"
                LayoutMenu.ResizeMenu()
                document.querySelector("#slide-left").classList.add("d-none")
            }
            document.querySelectorAll(".main-menu>li.open").forEach((ele) => {
                if (!ele.classList.contains('active')) {
                    ele.classList.remove('open')
                    ele.querySelector('ul').style.display = 'none'
                }
            })
        });
        /* icon Click Sidemenu End */
    
        /* icon hover Sidemenu Start */
        let iconhoverVar = iconHoverBtn.addEventListener('click', () => {
            html.removeAttribute('data-vertical-style');
            LayoutMenu.iconHoverFn();
            localStorage.setItem("zenonavstyles", 'icon-hover');
            localStorage.removeItem("zenoverticalstyles");
    
            if (document.querySelector("html").getAttribute("data-nav-layout") == 'horizontal') {
                document.querySelector(".main-menu").style.marginLeft = "0px"
                document.querySelector(".main-menu").style.marginRight = "0px"
                LayoutMenu.ResizeMenu()
                document.querySelector("#slide-left").classList.add("d-none")
            }
        });
        /* icon hover Sidemenu End */
    
        /* Sidemenu start*/
        let verticalVar = verticalBtn.addEventListener('click', () => {
            let mainContent = document.querySelector('.main-content');
            // local storage
            localStorage.removeItem("zenolayout");
            localStorage.setItem("zenoverticalstyles", 'default');
            CustomSwitcher.verticalFn();
            LayoutMenu.setNavActive();
            mainContent.removeEventListener('click', LayoutMenu.clearNavDropdown);
    
            //
            document.querySelector(".main-menu").style.marginLeft = "0px"
            document.querySelector(".main-menu").style.marginRight = "0px"
    
            document.querySelectorAll(".slide").forEach((element) => {
                if (
                    element.classList.contains("open") &&
                    !element.classList.contains("active")
                ) {
                    element.querySelector("ul").style.display = "none";
                }
            });
        });
        /* Sidemenu end */
    
        /* horizontal start*/
        let horiVar = horiBtn.addEventListener('click', () => {
            let mainContent = document.querySelector('.main-content');
            html.removeAttribute('data-vertical-style');
            //    local storage
            localStorage.setItem("zenolayout", 'horizontal');
            localStorage.removeItem("zenoverticalstyles");
    
            CustomSwitcher.horizontalClickFn();
            LayoutMenu.clearNavDropdown();
            mainContent.addEventListener('click', LayoutMenu.clearNavDropdown);
        });
        /* horizontal end*/
    
        /* rtl start */
        // let rtlVar = rtlBtn.addEventListener('click', () => {
        //     localStorage.setItem("zenortl", true);
        //     localStorage.removeItem("zenoltr");
        //     rtlFn();
        //     if (document.querySelector(".noUi-target")) {
        //         console.log("working");
        //         document.querySelectorAll(".noUi-origin").forEach((e) => {
        //             e.classList.add("transform-none");
        //         });
        //     }
        // });
        /* rtl end */
    
        /* ltr start */
        // let ltrVar = ltrBtn.addEventListener('click', () => {
        //     //    local storage
        //     localStorage.setItem("zenoltr", true);
        //     localStorage.removeItem("zenortl");
        //     ltrFn();
        //     if (document.querySelector(".noUi-target")) {
        //         document.querySelectorAll(".noUi-origin").forEach((e) => {
        //             e.classList.remove("transform-none");
        //         });
        //     }
        // });
        /* ltr end */
    
        // reset all start
        let resetVar = ResetAll.addEventListener('click', () => {
            CustomSwitcher.ResetAllFn();
            LayoutMenu.setNavActive();
            document.querySelector("html").setAttribute("data-menu-styles", "light");
            document.querySelector("html").setAttribute("data-width", "fullwidth");
            document.querySelector('#switcher-menu-light').checked = true;
            document.querySelectorAll(".slide").forEach((element) => {
                if (
                    element.classList.contains("open") &&
                    !element.classList.contains("active")
                ) {
                    element.querySelector("ul").style.display = "none";
                }
            });
            if (document.querySelector(".noUi-target")) {
                console.log("working");
                document.querySelectorAll(".noUi-origin").forEach((e) => {
                    e.classList.add("transform-none");
                });
            }
        })
        // reset all end
    
        /* loader start */
        // loaderEnable.onclick = () => {
        //     document.querySelector("html").setAttribute("loader", "enable");
        //     localStorage.setItem("loaderEnable", "true")
        // }
    
        // loaderDisable.onclick = () => {
        //     document.querySelector("html").setAttribute("loader", "disable");
        //     localStorage.setItem("loaderEnable", "false")
        // }
        /* loader end */
    }
    
    static lightFn() {
        let html = document.querySelector('html');
        html.setAttribute('data-theme-mode', 'light');
        html.setAttribute('data-header-styles', 'light');
        html.setAttribute('data-menu-styles', 'light');
        if (!localStorage.getItem('primaryRGB')) {
            html.setAttribute('style', '')
        }
        document.querySelector('#switcher-light-theme').checked = true;
        document.querySelector('#switcher-menu-light').checked = true;
        document.querySelector('#switcher-header-light').checked = true;
        localStorage.removeItem("zenodarktheme");
        localStorage.removeItem("zenobgColor");
        localStorage.removeItem("zenoheaderbg");
        localStorage.removeItem("zenobgwhite");
        localStorage.removeItem("zenomenubg");
        localStorage.removeItem("zenomenubg");
        CustomSwitcher.checkOptions();
        html.style.removeProperty('--body-bg-rgb');
        html.style.removeProperty('--body-bg-rgb2');
        html.style.removeProperty("--light-rgb");
        html.style.removeProperty("--form-control-bg");
        html.style.removeProperty("--gray-3");
        html.style.removeProperty("--input-border");
    
        document.querySelector("#switcher-background4").checked = false
        document.querySelector("#switcher-background3").checked = false
        document.querySelector("#switcher-background2").checked = false
        document.querySelector("#switcher-background1").checked = false
        document.querySelector("#switcher-background").checked = false
        document.querySelector('#switcher-menu-light').checked = true;
        document.querySelector('#switcher-header-light').checked = true;
    
    }
    
    static darkFn() {
        let html = document.querySelector('html');
        html.setAttribute('data-theme-mode', 'dark');
        html.setAttribute('data-header-styles', 'dark');
        html.setAttribute('data-menu-styles', 'dark');
        if (!localStorage.getItem('primaryRGB')) {
            html.setAttribute('style', '')
        }
        document.querySelector('#switcher-menu-dark').checked = true;
        document.querySelector('#switcher-header-dark').checked = true;
        document.querySelector('html').style.removeProperty('--body-bg-rgb');
        document.querySelector('html').style.removeProperty('--body-bg-rgb2');
        document.querySelector('html').style.removeProperty('--light-rgb');
        document.querySelector('html').style.removeProperty('--form-control-bg');
        document.querySelector('html').style.removeProperty('--gray-3');
        document.querySelector('html').style.removeProperty('--input-border');
        localStorage.setItem("zenodarktheme", true);
        localStorage.removeItem("zenolighttheme");
        localStorage.removeItem("bodyBgRGB");
        localStorage.removeItem("zenobgColor");
        localStorage.removeItem("zenoheaderbg");
        localStorage.removeItem("zenobgwhite");
        localStorage.removeItem("zenomenubg");
        CustomSwitcher.checkOptions();
    
        document.querySelector("#switcher-background4").checked = false
        document.querySelector("#switcher-background3").checked = false
        document.querySelector("#switcher-background2").checked = false
        document.querySelector("#switcher-background1").checked = false
        document.querySelector("#switcher-background").checked = false
        document.querySelector('#switcher-menu-dark').checked = true;
        document.querySelector('#switcher-header-dark').checked = true;
    }
    
    static verticalFn() {
        let html = document.querySelector('html');
        html.setAttribute('data-nav-layout', 'vertical');
        html.setAttribute('data-vertical-style', 'overlay');
        html.removeAttribute('data-nav-style');
        localStorage.removeItem('zenonavstyles');
        html.removeAttribute('data-toggled');
        document.querySelector('#switcher-vertical').checked = true;
        document.querySelector('#switcher-menu-click').checked = false;
        document.querySelector('#switcher-menu-hover').checked = false;
        document.querySelector('#switcher-icon-click').checked = false;
        document.querySelector('#switcher-icon-hover').checked = false;
        CustomSwitcher.checkOptions();
    }
    
    static horizontalClickFn() {
        document.querySelector('#switcher-horizontal').checked = true;
        document.querySelector('#switcher-menu-click').checked = true;
        let html = document.querySelector('html');
        html.setAttribute('data-nav-layout', 'horizontal');
        html.removeAttribute('data-vertical-style');
        if (!html.getAttribute('data-nav-style')) {
            html.setAttribute('data-nav-style', 'menu-click');
        }
        if (!localStorage.zenoMenu && !localStorage.bodylightRGB) {
            html.setAttribute("data-menu-styles", "light")
            document.querySelector('#switcher-menu-light').checked = true;
            CustomSwitcher.checkOptions();
        }
        CustomSwitcher.checkOptions();
        LayoutMenu.checkHoriMenu();
    }
    
    static ResetAllFn() {
        let html = document.querySelector('html');
        if (localStorage.getItem("zenolayout") == "horizontal") {
            document.querySelector(".main-menu").style.display = "block"
        }
        CustomSwitcher.checkOptions();
    
        // clearing localstorage
        localStorage.clear();
    
        // reseting to light
        CustomSwitcher.lightFn();
    
        //To reset the light-rgb
        document.querySelector('html').removeAttribute("style")
    
        // clearing attibutes
        // removing header, menu, pageStyle & boxed
        html.removeAttribute('data-nav-style');
        html.removeAttribute('data-menu-position');
        html.removeAttribute('data-header-position');
        html.removeAttribute('data-page-style');
    
        // removing theme styles
        html.removeAttribute('data-bg-img');
    
        // clear primary & bg color
        html.style.removeProperty(`--primary-rgb`);
        html.style.removeProperty(`--body-bg-rgb`);
    
        // reseting to ltr
        // ltrFn();
    
        // reseting to vertical
        CustomSwitcher.verticalFn();
        mainContent.removeEventListener('click', LayoutMenu.clearNavDropdown);
    
        // reseting page style
        document.querySelector('#switcher-classic').checked = false;
        document.querySelector('#switcher-modern').checked = false;
        document.querySelector('#switcher-regular').checked = true;
    
        // reseting layout width styles
        document.querySelector('#switcher-full-width').checked = true;
        document.querySelector('#switcher-boxed').checked = false;
    
        // reseting menu position styles
        document.querySelector('#switcher-menu-fixed').checked = true;
        document.querySelector('#switcher-menu-scroll').checked = false;
    
        // reseting header position styles
        document.querySelector('#switcher-header-fixed').checked = true;
        document.querySelector('#switcher-header-scroll').checked = false;
    
        // reseting sidemenu layout styles
        document.querySelector('#switcher-default-menu').checked = true;
        document.querySelector('#switcher-closed-menu').checked = false;
        document.querySelector('#switcher-icontext-menu').checked = false;
        document.querySelector('#switcher-icon-overlay').checked = false;
        document.querySelector('#switcher-detached').checked = false;
        document.querySelector('#switcher-double-menu').checked = false;
    
        // resetting theme primary
        document.querySelector("#switcher-primary").checked = false
        document.querySelector("#switcher-primary1").checked = false
        document.querySelector("#switcher-primary2").checked = false
        document.querySelector("#switcher-primary3").checked = false
        document.querySelector("#switcher-primary4").checked = false
    
        // resetting theme background
        document.querySelector("#switcher-background").checked = false
        document.querySelector("#switcher-background1").checked = false
        document.querySelector("#switcher-background2").checked = false
        document.querySelector("#switcher-background3").checked = false
        document.querySelector("#switcher-background4").checked = false
    
        // to reset horizontal menu scroll
        document.querySelector(".main-menu").style.marginLeft = "0px"
        document.querySelector(".main-menu").style.marginRight = "0px"
        
        let element = document.querySelector(".slide.has-sub.open.active")
        setTimeout(() => {
            if (element && document.querySelector(".child3 .side-menu__item.active")) {
                element.closest('ul.slide-menu').style.display = "block"
                element.closest('ul.slide-menu').closest('li.slide.has-sub').classList.add('open')
                element.closest('ul.slide-menu').closest('li.slide.has-sub').querySelector('.side-menu__item').classList.add('active')
                element.closest('ul.slide-menu').closest('li.slide.has-sub').querySelector('.child2 .has-sub.active').classList.add("open")
            }
        }, 100);
    }
    
    static checkOptions() {
    
        // dark
        if (localStorage.getItem('zenodarktheme')) {
            document.querySelector('#switcher-dark-theme').checked = true;
        }
    
        // horizontal
        if (localStorage.getItem('zenolayout') === "horizontal") {
            document.querySelector('#switcher-horizontal').checked = true;
            document.querySelector('#switcher-menu-click').checked = true;
        }
        else {
            document.querySelector('#switcher-vertical').checked = true;
        }
    
        //RTL
        // if (localStorage.getItem('zenortl')) {
        //     document.querySelector('#switcher-rtl').checked = true;
        // }
        // else {
        //     document.querySelector('#switcher-ltr').checked = true;
        // }
    
        // light header
        if (localStorage.getItem('zenoHeader') === "light") {
            document.querySelector('#switcher-header-light').checked = true;
        }
    
        // color header
        if (localStorage.getItem('zenoHeader') === "color") {
            document.querySelector('#switcher-header-primary').checked = true;
        }
    
        // gradient header
        if (localStorage.getItem('zenoHeader') === "gradient") {
            document.querySelector('#switcher-header-gradient').checked = true;
        }
    
        // dark header
        if (localStorage.getItem('zenoHeader') === "dark") {
            document.querySelector('#switcher-header-dark').checked = true;
        }
        // transparent header
        if (localStorage.getItem('zenoHeader') === "transparent") {
            document.querySelector('#switcher-header-transparent').checked = true;
        }
    
        // light menu
        if (localStorage.getItem('zenoMenu') === 'light') {
            document.querySelector('#switcher-menu-light').checked = true;
        }
    
        // color menu
        if (localStorage.getItem('zenoMenu') === 'color') {
            document.querySelector('#switcher-menu-primary').checked = true;
        }
    
        // gradient menu
        if (localStorage.getItem('zenoMenu') === 'gradient') {
            document.querySelector('#switcher-menu-gradient').checked = true;
        }
    
        // dark menu
        if (localStorage.getItem('zenoMenu') === 'dark') {
            document.querySelector('#switcher-menu-dark').checked = true;
        }
        // transparent menu
        if (localStorage.getItem('zenoMenu') === 'transparent') {
            document.querySelector('#switcher-menu-transparent').checked = true;
        }
    
        //full width
        if (localStorage.getItem('zenofullwidth')) {
            document.querySelector('#switcher-full-width').checked = true;
        }
    
        //boxed
        if (localStorage.getItem('zenoboxed')) {
            document.querySelector('#switcher-boxed').checked = true;
        }
    
        //scrollable
        if (localStorage.getItem('zenoheaderscrollable')) {
            document.querySelector('#switcher-header-scroll').checked = true;
        }
        if (localStorage.getItem('zenomenuscrollable')) {
            document.querySelector('#switcher-menu-scroll').checked = true;
        }
    
        //fixed
        if (localStorage.getItem('zenoheaderfixed')) {
            document.querySelector('#switcher-header-fixed').checked = true;
        }
        if (localStorage.getItem('zenomenufixed')) {
            document.querySelector('#switcher-menu-fixed').checked = true;
        }
    
        //classic
        if (localStorage.getItem('zenoclassic')) {
            document.querySelector('#switcher-classic').checked = true;
        }
    
        //modern
        if (localStorage.getItem('zenomodern')) {
            document.querySelector('#switcher-modern').checked = true;
        }
    
        // sidemenu layout style
        if (localStorage.zenoverticalstyles) {
            let verticalStyles = localStorage.getItem('zenoverticalstyles');
            switch (verticalStyles) {
                case 'default':
                    document.querySelector('#switcher-default-menu').checked = true;
                    break;
                case 'closed':
                    document.querySelector('#switcher-closed-menu').checked = true;
                    break;
                case 'icontext':
                    document.querySelector('#switcher-icontext-menu').checked = true;
                    break;
                case 'overlay':
                    document.querySelector('#switcher-icon-overlay').checked = true;
                    break;
                case 'detached':
                    document.querySelector('#switcher-detached').checked = true;
                    break;
                case 'doublemenu':
                    document.querySelector('#switcher-double-menu').checked = true;
                    break;
                default:
                    document.querySelector('#switcher-default-menu').checked = true;
                    break;
            }
        }
        // navigation menu style
        if (localStorage.zenonavstyles) {
            let navStyles = localStorage.getItem('zenonavstyles');
            switch (navStyles) {
                case 'menu-click':
                    document.querySelector('#switcher-menu-click').checked = true;
                    break;
                case 'menu-hover':
                    document.querySelector('#switcher-menu-hover').checked = true;
                    break;
                case 'icon-click':
                    document.querySelector('#switcher-icon-click').checked = true;
                    break;
                case 'icon-hover':
                    document.querySelector('#switcher-icon-hover').checked = true;
                    break;
            }
        }
    
        // loader
        // if (localStorage.loaderEnable != "true") {
        //     document.querySelector("#switcher-loader-disable").checked = true
        // }
    }
    
    static localStorageBackup2() {
        if (localStorage.bodyBgRGB || localStorage.bodylightRGB) {
            document.querySelector('#switcher-dark-theme').checked = true;
            document.querySelector('#switcher-menu-dark').checked = true;
            document.querySelector('#switcher-header-dark').checked = true;
        }
    
        if (localStorage.bodyBgRGB && localStorage.bodylightRGB) {
            if (localStorage.bodyBgRGB == "34, 49, 153") {
                document.querySelector("#switcher-background").checked = true
            }
            if (localStorage.bodyBgRGB == "147, 52, 150") {
                document.querySelector("#switcher-background1").checked = true
            }
            if (localStorage.bodyBgRGB == "135, 44, 47") {
                document.querySelector("#switcher-background2").checked = true
            }
            if (localStorage.bodyBgRGB == "3, 81, 60") {
                document.querySelector("#switcher-background3").checked = true
            }
            if (localStorage.bodyBgRGB == "73, 78, 1") {
                document.querySelector("#switcher-background4").checked = true
            }
        }
    
        if (localStorage.primaryRGB) {
            if (localStorage.primaryRGB == "64, 100, 221") {
                document.querySelector("#switcher-primary").checked = true
            }
            if (localStorage.primaryRGB == "207, 117, 225") {
                document.querySelector("#switcher-primary1").checked = true
            }
            if (localStorage.primaryRGB == "199, 89, 106") {
                document.querySelector("#switcher-primary2").checked = true
            }
            if (localStorage.primaryRGB == "1, 159, 162") {
                document.querySelector("#switcher-primary3").checked = true
            }
            if (localStorage.primaryRGB == "139, 149, 4") {
                document.querySelector("#switcher-primary4").checked = true
            }
        }
    
        // if (localStorage.loaderEnable == "true") {
        //     document.querySelector("#switcher-loader-enable").checked = true
        // }
    }
}