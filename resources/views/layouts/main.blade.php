@extends('layouts.master')
@section('layout-content')

@include('layouts.partials.switcher')

<div class="page">
    @include('layouts.partials.header')
    <x-sidebar :menus="\App\Models\Menu::getAll()" />

    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="d-flex align-items-center justify-content-between page-header-breadcrumb flex-wrap gap-2">
                <div>

                    @if (isset($breadcrumbs))
                        <x-breadcrumb :items="$breadcrumbs"/>
                    @else
                        @yield('breadcrumb')
                    @endif

                    <h1 class="page-title fw-medium fs-18 mb-0">
                        @if (isset($title))
                            {{ $title }}
                        @else
                            @yield('page-title')
                        @endif
                    </h1>
                </div>
                <div class="btn-list">
                    @yield('top-buttons')

                    {{-- <button class="btn btn-primary-light btn-wave">
                        <i class="ri-upload-cloud-line align-middle me-1"></i> Export report
                    </button>
                    <button class="btn btn-info-light btn-wave me-0">
                        <i class="bx bx-crown align-middle me-1"></i> Upgrade plan
                    </button> --}}
                </div>
            </div>
            <!-- Page Header Close -->

            <!-- Start::row-1 -->
            @yield('content')
            <!--End::row-1 -->

        </div>
    </div>
    <!-- End::app-content -->
    
    @include('layouts.partials.footer')
    @include('layouts.partials.responsive-search-modal')

</div>

<div class="scrollToTop">
    <span class="arrow"><i class="ti ti-arrow-narrow-up fs-20"></i></span>
</div>
<div id="responsive-overlay"></div>

@endsection

@prepend('scripts')
    @vite([
        'resources/js/main.js'
    ])
@endprepend