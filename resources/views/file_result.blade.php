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
                <td>SHA256:</td>
                <td style="padding-left: 20px">{{ $sha256 }}</td>
            </tr>
            <tr>
                <td>File name:</td>
                <td style="padding-left: 20px">{{ $filename }}</td>
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
                        <td>{{ date('Y-m-d', strtotime($results['update'])) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection