<!DOCTYPE html>
<html>
    <head>
        <title>{{ $title }}</title>
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-theme.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        @yield('style')
    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1><a href="/">VirusMaester</a></h1>
            </div>
        </div>
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
