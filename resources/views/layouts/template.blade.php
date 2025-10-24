<!DOCTYPE html>
<html lang="fa">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" type="image/x-icon" href="{{ asset('asset/img/logo.png') }}">
        <title>ریاضی زوم</title>
        @yield('meta_tags')
        @section('header')
            <link rel="stylesheet" href="{{ asset('admin-panel/css/bootstrap.min.css') }}">
            <script src="{{ asset('admin-panel/js/vendor/jquery-1.11.3.min.js') }}"></script>
            <script src="{{ asset('admin-panel/js/bootstrap.min.js') }}"></script>
            <link rel="stylesheet" href="{{ asset('asset/fonts/font.css') }}" />
            <link rel="stylesheet" href="{{ asset('asset/css/common.css') }}" />
            <link rel="stylesheet" href="{{ asset('asset/css/nav.css') }}" />
            <link rel="stylesheet" href="{{ asset('asset/css/footer.css') }}" />
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