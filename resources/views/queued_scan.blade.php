@include('master')

@section('style')
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
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">Scan Results</div>
                <div class="panel-body">
                    <p>{{ $message }}</p>
                    <a href="{{ url("$type/$scan_id/") }}" class="btn btn-primary pull-right">View Results</a>
                </div>
            </div>
        </div>
    </div>
@endsection