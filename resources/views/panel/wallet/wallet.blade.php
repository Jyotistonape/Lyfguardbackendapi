@extends('layouts.panel')

@section('headscript')
@endsection

@section('content')

<div class="row">
    <div class="card-header">
        <h4 class="card-title">
            <a href="{{route('addBalanceToBWallet')}}" class="btn btn-primary">Add Balance To Branch Wallet <span class="btn-icon-right"><i class="fa fa-plus-square"></i></span>
        </a>
    </h4>
</div>
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

<div class="row">
    <div class="col-xl-4 col-xxl-6 col-lg-6">
        <div class="card">
            <div class="card-header border-0 pb-0">
                <h4 class="card-title">Added</h4>
            </div>
            <div class="card-body">
                <div id="DZ_W_TimeLine" class="widget-timeline dz-scroll height370 ps ps--active-y">
                    <ul class="timeline">
                        @if($data['walletTransactions'])
                        @foreach($data['walletTransactions'] as $walletTransaction)
                        <li>
                            <div class="timeline-badge success"></div>
                            <a class="timeline-panel text-muted" href="#">
                                <span>{{date('d M Y H:i:s', strtotime($walletTransaction->created_at))}}</span>
                                <h6 class="mb-0"><strong class="text-info">{{$walletTransaction->amount}} ₹.</strong></h6>
                            </a>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                    <div class="ps__rail-x" style="left: 0px; bottom: -183px;">
                    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps__rail-y" style="top: 183px; height: 370px; right: 665px;">
                    <div class="ps__thumb-y" tabindex="0" style="top: 123px; height: 247px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-xxl-6 col-lg-6">
        <div class="card">
            <div class="card-header border-0 pb-0">
                <h4 class="card-title">Transfer </h4>
            </div>
            <div class="card-body">
                <div id="DZ_W_TimeLine" class="widget-timeline dz-scroll height370 ps ps--active-y">
                    <ul class="timeline">
                        @if($data['subwalletTransactions'])
                        @foreach($data['subwalletTransactions'] as $subwalletTransaction)
                        <li>
                            <div class="timeline-badge danger"></div>
                            <a class="timeline-panel text-muted" href="#">
                                <span>{{date('d M Y H:i:s', strtotime($subwalletTransaction->created_at))}}</span>
                                <h6 class="mb-0"><strong class="text-warning">₹. {{$subwalletTransaction->amount}}</strong> Transfer to {{$subwalletTransaction->branchName}}.</h6>
                            </a>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                    <div class="ps__rail-x" style="left: 0px; bottom: -183px;">
                    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps__rail-y" style="top: 183px; height: 370px; right: 665px;">
                    <div class="ps__thumb-y" tabindex="0" style="top: 123px; height: 247px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
@endsection

