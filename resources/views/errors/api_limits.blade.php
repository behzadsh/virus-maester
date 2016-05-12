<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-theme.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <style>
            html, body {
                height: 100%;
                margin: 0;
                padding: 0
            }

            .container-fluid {
                height: 100%;
                display: table;
                width: 100%;
                padding: 0;
            }

            .row-fluid {
                height: 100%;
                display: table-cell;
                vertical-align: middle;
            }

            .centering {
                float: none;
                margin: 0 auto;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="centering text-center">
                    <h3>{{ $message }}</h3>
                    <div class="panel panel-info">

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
