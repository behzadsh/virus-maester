@extends('master')

@section('style')
@endsection

@section('content')
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
@endsection
