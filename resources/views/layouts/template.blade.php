<html>
    <head>
        <meta charset="UTF-8">
        @yield('meta_tags')
        @section('header')
            <link rel="stylesheet" href="{{ asset('admin-panel/css/bootstrap.min.css') }}">
            <script src="{{ asset('admin-panel/js/bootstrap.min.js') }}"></script>
            <link rel="stylesheet" href="{{ asset('asset/fonts/font.css') }}" />
            <link rel="stylesheet" href="{{ asset('asset/css/common.css') }}" />
            <link rel="stylesheet" href="{{ asset('asset/css/nav.css') }}" />
        @show
    </head>
    <body>
         @include('layouts.navbar')
        <div class="container content-container">
            @yield('content')
        </div>
        @include('layouts.footer')
    </body>
</html>