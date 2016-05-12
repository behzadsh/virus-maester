<!DOCTYPE html>
<html>
    <head>
        <title>VirusMaester</title>
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-theme.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>VirusMaester</h1>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel with-nav-tabs panel-info">
                        @include('partials.tabs')
                        <div class="panel-body">
                            <div class="tab-content">
                                @include('partials.file')
                                @include('partials.url')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
