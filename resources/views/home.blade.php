@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
                        <button onclick="initMap()" class="btn btn-primary">Google map</button>
                        <div id="map" style="height: 400px; width: 100%; margin-top: 20px;">hello world</div>
                        <div id="msg"></div>
                        <div id="demo"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
