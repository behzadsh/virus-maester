<!DOCTYPE html>
<html>
    <head>
        <title>API Limits</title>
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

            .panel-heading {
                font-size: larger;
            }
        </style>
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
                    <div class="panel panel-danger">
                        <div class="panel-heading">API Limit</div>
                        <div class="panel-body">
                            <p><b>API limit reached.</b> Please try later.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
