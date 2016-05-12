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
                width: 60%;
                padding: 0;
            }

            .container {
                padding-top: 50px;
            }

            .row-fluid {
                height: 100%;
                display: table-cell;
                vertical-align: middle;
            }

            .panel-heading {
                font-size: larger;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">Scan Results</div>
                        <div class="panel-body">
                            <p><b>The requested file queued for scanning.</b> Click the button below to view the results.</p>
                            <a href="{{ url("$type/$scan_id/") }}" class="btn btn-primary pull-right">View Results</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
