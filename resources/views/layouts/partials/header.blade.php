 <!-- app-header -->
 <header class="app-header sticky" id="header">

    <!-- Start::main-header-container -->
    <div class="main-header-container container-fluid">

        <!-- Start::header-content-left -->
        <div class="header-content-left">

            <!-- Start::header-element -->
            <div class="header-element">
                <div class="horizontal-logo">
                    <a href="index.html" class="header-logo">
                        <img src="{{ Vite::asset('resources/assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
                        <img src="{{ Vite::asset('resources/assets/images/brand-logos/toggle-dark.png') }}" alt="logo" class="toggle-dark">
                        <img src="{{ Vite::asset('resources/assets/images/brand-logos/desktop-dark.png') }}" alt="logo" class="desktop-dark">
                        <img src="{{ Vite::asset('resources/assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
                        <img src="{{ Vite::asset('resources/assets/images/brand-logos/toggle-white.png') }}" alt="logo" class="toggle-white">
                        <img src="{{ Vite::asset('resources/assets/images/brand-logos/desktop-white.png') }}" alt="logo" class="desktop-white">
                    </a>
                </div>
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="header-element mx-lg-0 mx-2">
                <a aria-label="Hide Sidebar" class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle" data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            {{-- <div class="header-element header-search d-md-block d-none my-auto auto-complete-search">
                <!-- Start::header-link -->
                <input type="text" class="header-search-bar form-control" id="header-search" placeholder="Search anything here ..." spellcheck=false autocomplete="off" autocapitalize="off">
                <a href="javascript:void(0);" class="header-search-icon border-0">
                    <i class="ri-search-line"></i>
                </a>
                <!-- End::header-link -->
            </div> --}}
            <!-- End::header-element -->

        </div>
        <!-- End::header-content-left -->

        <!-- Start::header-content-right -->
        <ul class="header-content-right">

            <!-- Start::header-element -->
            <li class="header-element d-md-none d-block">
                <a href="javascript:void(0);" class="header-link" data-bs-toggle="modal" data-bs-target="#header-responsive-search">
                    <!-- Start::header-link-icon -->
                    <i class="bi bi-search header-link-icon"></i>
                    <!-- End::header-link-icon -->
                </a>  
            </li>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <li class="header-element country-selector dropdown">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-auto-close="outside" data-bs-toggle="dropdown">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 header-link-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m10.5 21 5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 0 1 6-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 0 1-3.827-5.802" />
                      </svg>
                      
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <ul class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-rounded avatar-xs lh-1 me-2">
                                        <img src="{{ Vite::asset('resources/assets/images/flags/us_flag.jpg') }}" alt="img">
                                    </span>
                                    English
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                            <span class="avatar avatar-rounded avatar-xs lh-1 me-2">
                                <img src="{{ Vite::asset('resources/assets/images/flags/spain_flag.jpg') }}" alt="img" >
                            </span>
                            español
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                            <span class="avatar avatar-rounded avatar-xs lh-1 me-2">
                                <img src="{{ Vite::asset('resources/assets/images/flags/french_flag.jpg') }}" alt="img" >
                            </span>
                            français
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                            <span class="avatar avatar-rounded avatar-xs lh-1 me-2">
                                <img src="{{ Vite::asset('resources/assets/images/flags/uae_flag.jpg') }}" alt="img" >
                            </span>
                            عربي
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                            <span class="avatar avatar-rounded avatar-xs lh-1 me-2">
                                <img src="{{ Vite::asset('resources/assets/images/flags/germany_flag.jpg') }}" alt="img" >
                            </span>
                            Deutsch
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                            <span class="avatar avatar-rounded avatar-xs lh-1 me-2">
                                <img src="{{ Vite::asset('resources/assets/images/flags/china_flag.jpg') }}" alt="img" >
                            </span>
                            中国人
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                            <span class="avatar avatar-rounded avatar-xs lh-1 me-2">
                                <img src="{{ Vite::asset('resources/assets/images/flags/italy_flag.jpg') }}" alt="img" >
                            </span>
                            Italiano
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                            <span class="avatar avatar-rounded avatar-xs lh-1 me-2">
                                <img src="{{ Vite::asset('resources/assets/images/flags/russia_flag.jpg') }}" alt="img" >
                            </span>
                            Русский
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <li class="header-element header-theme-mode">
                <!-- Start::header-link|layout-setting -->
                <a href="javascript:void(0);" class="header-link layout-setting">
                    <span class="light-layout">
                        <!-- Start::header-link-icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 header-link-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                          </svg>
                        <!-- End::header-link-icon -->
                    </span>
                    <span class="dark-layout">
                        <!-- Start::header-link-icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 header-link-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                          </svg>
                        <!-- End::header-link-icon -->
                    </span>
                </a>
                <!-- End::header-link|layout-setting -->
            </li>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            {{-- <li class="header-element cart-dropdown dropdown">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-auto-close="outside" data-bs-toggle="dropdown">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 header-link-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                      </svg>
                    <span class="badge bg-info rounded-pill header-icon-badge" id="cart-icon-badge">5</span>
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <!-- Start::main-header-dropdown -->
                <div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
                    <div class="p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 fs-15 fw-medium">Cart Items<span class="badge bg-info text-fixed-white ms-1 fs-12 rounded-circle" id="cart-data">5</span></p>
                            <div class="d-flex align-items-center gap-2">
                                <span class="fs-12 fw-medium text-muted">Sub Total : </span>
                                <h6 class="mb-0"> $740</h6>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <ul class="list-unstyled mb-0" id="header-cart-items-scroll">
                        <li class="dropdown-item">
                            <div class="d-flex align-items-center cart-dropdown-item gap-3">
                                <div class="lh-1">
                                    <span class="avatar avatar-md avatar-rounded">
                                        <img src="{{ Vite::asset('resources/assets/images/ecommerce/jpg/1.jpg') }}" alt="Elegance Wall Clock">
                                    </span>
                                </div>
                                <div class="flex-fill">
                                    <div class="d-flex align-items-center justify-content-between mb-0">
                                        <div class="mb-0 fw-medium">
                                            <a href="cart.html">Elegance Wall Clock</a>
                                            <div class="d-flex gap-2 text-truncate fs-12 fw-normal text-muted lh-1 mt-1">
                                                <div class="fs-12">Brand : TechBrand</div>
                                                <div class="vr"></div>
                                                <p class="mb-0 header-cart-text text-truncate">Qty : 2 &#x2715; $150 </p>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <a href="javascript:void(0);" class="header-cart-remove dropdown-item-close"><i class="ri-close-line"></i></a>
                                            <h6 class="fw-medium mb-0">$300</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-item">
                            <div class="d-flex align-items-center cart-dropdown-item gap-3">
                                <div class="lh-1">
                                    <span class="avatar avatar-md avatar-rounded">
                                        <img src="{{ Vite::asset('resources/assets/images/ecommerce/jpg/2.jpg') }}" alt="Sports Shoe">
                                    </span>
                                </div>
                                <div class="flex-fill">
                                    <div class="d-flex align-items-center justify-content-between mb-0">
                                        <div class="mb-0 fw-medium">
                                            <a href="cart.html">Sports Shoe</a>
                                            <div class="d-flex gap-2 text-truncate fs-12 fw-normal text-muted lh-1 mt-1">
                                                <div class="fs-12">Brand : WearCo</div>
                                                <div class="vr"></div>
                                                <p class="mb-0 header-cart-text text-truncate">Qty : 3 &#x2715; $50 </p>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <a href="javascript:void(0);" class="header-cart-remove dropdown-item-close"><i class="ri-close-line"></i></a>
                                            <h6 class="fw-medium mb-0">$150</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-item">
                            <div class="d-flex align-items-center cart-dropdown-item gap-3">
                                <div class="lh-1">
                                    <span class="avatar avatar-md avatar-rounded">
                                        <img src="{{ Vite::asset('resources/assets/images/ecommerce/jpg/3.jpg') }}" alt="Medium Back Pack">
                                    </span>
                                </div>
                                <div class="flex-fill">
                                    <div class="d-flex align-items-center justify-content-between mb-0">
                                        <div class="mb-0 fw-medium">
                                            <a href="cart.html">Medium Back Pack</a>
                                            <div class="d-flex gap-2 text-truncate fs-12 fw-normal text-muted lh-1 mt-1">
                                                <div class="fs-12">Brand : DecorArts</div>
                                                <div class="vr"></div>
                                                <p class="mb-0 header-cart-text text-truncate">Qty : 2 &#x2715; $50 </p>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <a href="javascript:void(0);" class="header-cart-remove dropdown-item-close"><i class="ri-close-line"></i></a>
                                            <h6 class="fw-medium mb-0">$100</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-item">
                            <div class="d-flex align-items-center cart-dropdown-item gap-3">
                                <div class="lh-1">
                                    <span class="avatar avatar-md avatar-rounded">
                                        <img src="{{ Vite::asset('resources/assets/images/ecommerce/jpg/4.jpg') }}" alt="BloomCraft Pot">
                                    </span>
                                </div>
                                <div class="flex-fill">
                                    <div class="d-flex align-items-center justify-content-between mb-0">
                                        <div class="mb-0 fw-medium">
                                            <a href="cart.html">BloomCraft Pot</a>
                                            <div class="d-flex gap-2 text-truncate fs-12 fw-normal text-muted lh-1 mt-1">
                                                <div class="fs-12">Brand : FurniWorld</div>
                                                <div class="vr"></div>
                                                <p class="mb-0 header-cart-text text-truncate">Qty : 1 &#x2715; $800 </p>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <a href="javascript:void(0);" class="header-cart-remove dropdown-item-close"><i class="ri-close-line"></i></a>
                                            <h6 class="fw-medium mb-0">$800</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-item">
                            <div class="d-flex align-items-center cart-dropdown-item gap-3">
                                <div class="lh-1">
                                    <span class="avatar avatar-md avatar-rounded">
                                        <img src="{{ Vite::asset('resources/assets/images/ecommerce/jpg/5.jpg') }}" alt="Ceramic Cup">
                                    </span>
                                </div>
                                <div class="flex-fill">
                                    <div class="d-flex align-items-center justify-content-between mb-0">
                                        <div class="mb-0 fw-medium">
                                            <a href="cart.html">Ceramic Cup</a>
                                            <div class="d-flex gap-2 text-truncate fs-12 fw-normal text-muted lh-1 mt-1">
                                                <div class="fs-12">Brand : StylePro</div>
                                                <div class="vr"></div>
                                                <p class="mb-0 header-cart-text text-truncate">Qty : 2 &#x2715; $30 </p>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <a href="javascript:void(0);" class="header-cart-remove dropdown-item-close"><i class="ri-close-line"></i></a>
                                            <h6 class="fw-medium mb-0">$60</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>                    
                    <div class="p-3 empty-header-item border-top d-flex gap-2 align-items-center">
                        <a href="checkout.html" class="btn flex-fill btn-primary btn-wave">Proceed to checkout</a>
                    </div>
                    <div class="p-5 empty-item d-none">
                        <div class="text-center">
                            <span class="avatar avatar-xl avatar-rounded bg-warning-transparent">
                                <i class="ri-shopping-cart-2-line fs-2"></i>
                            </span>
                            <h6 class="fw-medium mb-1 mt-3">Your Cart is Empty</h6>
                            <span class="mb-3 fw-normal fs-13 d-block">Add some items to make me happy :)</span>
                            <a href="products.html" class="btn btn-secondary btn-wave btn-sm m-1" data-abc="true">continue shopping <i class="bi bi-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <!-- End::main-header-dropdown -->
            </li> --}}
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <li class="header-element notifications-dropdown d-xl-block d-none dropdown">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" id="messageDropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 header-link-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                      </svg>
                    <span class="header-icon-pulse bg-secondary rounded pulse pulse-secondary"></span>
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <!-- Start::main-header-dropdown -->
                <div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
                    <div class="p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 fs-15 fw-medium">Notifications</p>
                            <span class="badge bg-secondary text-fixed-white" id="notifiation-data">5 Unread</span>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <ul class="list-unstyled mb-0" id="header-notification-scroll">
                        <li class="dropdown-item">
                            <div class="d-flex align-items-start">
                                <div class="pe-2 lh-1">
                                    <span class="avatar avatar-md avatar-rounded bg-primary">
                                        <img src="{{ Vite::asset('resources/assets/images/faces/1.jpg') }}" alt="user1">
                                    </span>
                                </div>
                                <div class="flex-grow-1 d-flex align-items-start justify-content-between">
                                    <div>
                                        <p class="mb-0 fw-medium"><a href="chat.html">New User Registered</a></p>
                                        <div class="text-muted fw-normal fs-12 header-notification-text text-truncate"><span class="text-primary">John Doe</span> has registered as a new user.</div>
                                        <div class="fw-normal fs-10 text-muted op-8">5 mins ago</div>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0);" class="min-w-fit-content dropdown-item-close1">
                                            <i class="ri-close-line"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-item">
                            <div class="d-flex align-items-start">
                                <div class="pe-2 lh-1">
                                    <span class="avatar avatar-md bg-primary avatar-rounded fs-20">
                                        <i class="ri-money-dollar-circle-line lh-1 fs-16"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 d-flex align-items-start justify-content-between">
                                    <div>
                                        <p class="mb-0 fw-medium"><a href="chat.html">Payment Received</a></p>
                                        <div class="text-muted fw-normal fs-12 header-notification-text text-truncate">You received a payment of $250 from Emily Davis.</div>
                                        <div class="fw-normal fs-10 text-muted op-8">15 mins ago</div>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0);" class="min-w-fit-content dropdown-item-close1">
                                            <i class="ri-close-line"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-item">
                            <div class="d-flex align-items-start">
                                <div class="pe-2 lh-1">
                                    <span class="avatar avatar-md bg-orange avatar-rounded">
                                        <img src="{{ Vite::asset('resources/assets/images/faces/13.jpg') }}" alt="user1">
                                    </span>
                                </div>
                                <div class="flex-grow-1 d-flex align-items-start justify-content-between">
                                    <div>
                                        <p class="mb-0 fw-medium"><a href="chat.html">Task Completed</a></p>
                                        <div class="text-muted fw-normal fs-12 header-notification-text text-truncate"><span class="text-secondary">"Design Homepage"</span> task was marked as complete.</div>
                                        <div class="fw-normal fs-10 text-muted op-8">30 mins ago</div>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0);" class="min-w-fit-content dropdown-item-close1">
                                            <i class="ri-close-line"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-item">
                            <div class="d-flex align-items-start">
                                <div class="pe-2 lh-1">
                                    <span class="avatar avatar-md bg-success avatar-rounded">
                                        <img src="{{ Vite::asset('resources/assets/images/faces/11.jpg') }}" alt="user1">
                                    </span>
                                </div>
                                <div class="flex-grow-1 d-flex align-items-start justify-content-between">
                                    <div>
                                        <p class="mb-0 fw-medium"><a href="chat.html">Server Alert</a></p>
                                        <div class="text-muted fw-normal fs-12 header-notification-text text-truncate">High CPU usage detected on Server 3.</div>
                                        <div class="fw-normal fs-10 text-muted op-8">1 hr ago</div>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0);" class="min-w-fit-content dropdown-item-close1">
                                            <i class="ri-close-line"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-item">
                            <div class="d-flex align-items-start">
                                <div class="pe-2 lh-1">
                                    <span class="avatar avatar-md bg-info avatar-rounded">
                                        <i class="ri-message-2-line lh-1 fs-16"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 d-flex align-items-start justify-content-between">
                                    <div>
                                        <p class="mb-0 fw-medium"><a href="chat.html">New Message</a></p>
                                        <div class="text-muted fw-normal fs-12 header-notification-text text-truncate">You have a new message from Sophia Johnson.</div>
                                        <div class="fw-normal fs-10 text-muted op-8">2 hrs ago</div>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0);" class="min-w-fit-content dropdown-item-close1">
                                            <i class="ri-close-line"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    
                    <div class="p-3 empty-header-item1 border-top">
                        <div class="d-grid">
                            <a href="javascript:void(0);" class="btn btn-primary btn-wave">View All</a>
                        </div>
                    </div>
                    <div class="p-5 empty-item1 d-none">
                        <div class="text-center">
                            <span class="avatar avatar-xl avatar-rounded bg-secondary-transparent">
                                <i class="ri-notification-off-line fs-2"></i>
                            </span>
                            <h6 class="fw-medium mt-3">No New Notifications</h6>
                        </div>
                    </div>
                </div>
                <!-- End::main-header-dropdown -->
            </li>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <li class="header-element header-fullscreen">
                <!-- Start::header-link -->
                <a id="header-fullscreen" href="javascript:void(0);" class="header-link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 full-screen-open header-link-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 full-screen-close header-link-icon d-none" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 9V4.5M9 9H4.5M9 9 3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5 5.25 5.25" />
                      </svg>
                </a>
                <!-- End::header-link -->
            </li>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <li class="header-element dropdown">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <div>
                            <img src="{{ Vite::asset('resources/assets/images/faces/15.jpg') }}" alt="img" class="avatar custom-header-avatar avatar-rounded">
                        </div>
                    </div>
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end" aria-labelledby="mainHeaderProfile">
                    <li>
                        <div class="dropdown-item text-center border-bottom">
                            <span class="fw-medium">
                                Mr.Jack Miller
                            </span>
                            <span class="d-block fs-12 text-muted">Designer</span>
                        </div>
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="profile.html"><i class="ri-user-line lh-1 p-1 rounded-circle bg-primary-transparent text-primary me-2 fs-14"></i>Profile</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="file-manager.html"><i class="ri-folder-4-line lh-1 p-1 rounded-circle bg-primary-transparent text-primary me-2 fs-14"></i>File Manager<span class="badge bg-success text-fixed-white ms-auto fs-9">2</span></a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="mail.html"><i class="ri-mail-line lh-1 p-1 rounded-circle bg-primary-transparent text-primary me-2 fs-14"></i>Mail Inbox</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="mail-settings.html"><i class="ri-settings-5-line lh-1 p-1 rounded-circle bg-primary-transparent text-primary me-2 fs-14"></i>Settings</a></li>
                    <li><a class="dropdown-item d-flex align-items-center" href="sign-in-cover.html"><i class="ri-door-lock-line lh-1 p-1 rounded-circle bg-primary-transparent text-primary me-2 fs-14"></i>Log Out</a></li>
                </ul>
            </li>  
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <li class="header-element">
                <!-- Start::header-link|switcher-icon -->
                <a href="javascript:void(0);" class="header-link switcher-icon" data-bs-toggle="offcanvas" data-bs-target="#switcher-canvas">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 header-link-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                      </svg>
                </a>
                <!-- End::header-link|switcher-icon -->
            </li>
            <!-- End::header-element -->

        </ul>
        <!-- End::header-content-right -->

    </div>
    <!-- End::main-header-container -->

</header>
<!-- /app-header -->