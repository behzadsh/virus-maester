@extends('master')

@section('style')
    <style>
        .frame {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
        }

        .table-clean {
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
@endsection

@section('content')
    <div class="frame">
        @if($defected == false)
            <div class="alert alert-success">
                <i class="glyphicon glyphicon-ok-sign"></i>
                <b>Probably harmless!</b> There are strong indicators suggesting that this url is safe to use.
            </div>
        @else
            <div class="alert alert-danger">
                <i class="glyphicon glyphicon-remove-sign"></i>
                <b>Harmful url!</b> There are strong indicators suggesting that this url is not safe to use.
            </div>
        @endif
        <table class="table-clean">
            <tr>
                <td>Url:</td>
                <td style="padding-left: 20px">{{ $url }}</td>
            </tr>
            <tr>
                <td>Detection ratio:</td>
                <td style="padding-left: 20px">{{ $ratio }}</td>
            </tr>
            <tr>
                <td>Analysis date:</td>
                <td style="padding-left: 20px">{{ $date }}</td>
            </tr>
        </table>
    </div>

    <div class="results">
        <table class="table table-striped">
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
                                <div class="danger"><i class="glyphicon glyphicon-remove-sign"></i> {{ $results['result'] }}</div>
                            @else
                                <div class="success"><i class="glyphicon glyphicon-ok-sign"></i> {{ $results['result'] }}</div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

