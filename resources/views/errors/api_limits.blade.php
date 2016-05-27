@extends('master')

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
            <div class="panel panel-danger">
                <div class="panel-heading">API Limit</div>
                <div class="panel-body">
                    <p><b>API limit reached.</b> Please try later.</p>
                </div>
            </div>
        </div>
    </div>
@endsection