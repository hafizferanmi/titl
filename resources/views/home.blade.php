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
                        <div>
                            <div>
                                <span>No of referrals: </span>
                                <span>{{ $noOfReferrals }}</span>
                            </div>
                            <div>
                                <span>Wallet balance: </span>
                                <span>{{ $walletBalance }}</span>
                            </div>
                        </div>
                        <button style="margin-top: 20px" onclick="initMap()" class="btn btn-primary">Google map</button>
                        <div id="map" style="height: 400px; width: 100%; margin-top: 20px;"></div>
                        <div id="msg"></div>
                        <div id="demo"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
