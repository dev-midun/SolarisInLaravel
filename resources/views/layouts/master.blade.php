<!DOCTYPE html>
<html 
    lang="en" 
    dir="ltr" 
    data-nav-layout="vertical" 
    data-theme-mode="light" 
    data-header-styles="light" 
    data-menu-styles="light" 
    data-toggled="close">

    <head>
        <title>Solaris</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="author" content="Solaris" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta name="description" content="The future of customer relationships rises. Simple, straightforward, CRM is easy as 1-2-3" />
        <meta name="keywords" content="admin dashboard, template admin, admin template, dashboard">

        <link rel="icon" href="{{ Vite::asset('resources/assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">

        @vite([
            'resources/css/app.scss',
            'resources/js/app.js'
        ])

        @stack('styles')

        <script>
            window.BASE_URL = {{ Js::from(url('/')) }};
            window.MAX_FILE_SIZE = {{ Js::from(env('MAX_FILE_SIZE', 10)) }};
        </script>
        @stack('head-scripts')
    </head>
    <body>
        @yield('layout-content')
        
        @stack('scripts')
    </body>
</html>