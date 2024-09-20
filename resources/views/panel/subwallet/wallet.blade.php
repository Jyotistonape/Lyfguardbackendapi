@extends('layouts.panel')

@section('headscript')
@endsection

@section('content')

<div class="row">
    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
        <div class="widget-stat card bg-primary">
            <div class="card-body p-4">
                <div class="media">
                    <span class="me-3"><i class="la la-dollar"></i></span>
                    <div class="media-body text-white">
                        <p class="mb-1">Wallet Balance</p>
                        <h3 class="text-white">{{$data['walletBalance']}} ₹.</h3>
                        <div class="progress mb-2 bg-secondary">
                            <div class="progress-bar progress-animated bg-light" style="width: 30%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
@endsection

