<!DOCTYPE html>
<html>
    <head>
        <title>Scan Results</title>
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-theme.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <style>
            .frame {
                margin-top: 50px;
                border: 1px solid #ddd;
                border-radius: 4px;
                padding: 10px;
            }

            .table-clean {
                width: 50%;
                margin: 10px;
            }

            .table-clean tbody td {
                padding: 5px 0;
            }

            .alert {
                margin-bottom: 0;
                padding: 10px 15px;
            }

            .results {
                padding-top: 25px;
            }
            
            i.danger, div.danger {
                color: #a94442;
            }

            i.success, div.success {
                color: #3c763d;
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
            <div class="frame">
                @if($defected == false)
                    <div class="alert alert-success">
                        <i class="glyphicon glyphicon-ok-sign"></i>
                        <b>Probably harmless!</b> There are strong indicators suggesting that this file is safe to use.
                    </div>
                @else
                    <div class="alert alert-danger">
                        <i class="glyphicon glyphicon-remove-sign"></i>
                        <b>Harmful file!</b> There are strong indicators suggesting that this file is not safe to use.
                    </div>
                @endif
                <table class="table-clean">
                    <tr>
                        <td>Detection ratio:</td>
                        <td>{{ $ratio }}</td>
                    </tr>
                    <tr>
                        <td>Analysis date:</td>
                        <td>{{ $date }}</td>
                    </tr>
                </table>
            </div>

            <div class="results">
                <table class="table table-striped">
                    @if($type == 'file')
                        <thead>
                            <tr>
                                <td>Antivirus</td>
                                <td>Result</td>
                                <td>Update</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($scans as $scanner => $results)
                                <tr>
                                    <td>{{ $scanner }}</td>
                                    <td>
                                        @if($results['detected'])
                                            <i class="glyphicon glyphicon-remove-sign danger"></i>
                                        @else
                                            <i class="glyphicon glyphicon-ok-sign success"></i>
                                        @endif
                                    </td>
                                    <td>{{ $results['update'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    @else
                        <thead>
                            <tr>
                                <td>Url Scanner</td>
                                <td>Result</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($scans as $scanner => $results)
                                <tr>
                                    <td>{{ $scanner }}</td>
                                    <td>
                                        @if($results['detected'])
                                            <div class="danger"><i class="glyphicon glyphicon-remove-sign"></i> Malicious site</div>
                                        @else
                                            <div class="success"><i class="glyphicon glyphicon-ok-sign"></i> Clean site</div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif
                </table>
            </div>
        </div>
    </body>
</html>
