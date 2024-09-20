<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LyfGuard') }}</title>
@yield('headscript')

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/favicon.png')}}"/>

    <link href="{{asset('assets/vendor/jqvmap/css/jqvmap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/vendor/chartist/css/chartist.min.css')}}">
    <link href="{{asset('assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">

</head>
<body>

<!--*******************
    Preloader start
********************-->
<div id="preloader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>
<!--*******************
    Preloader end
********************-->


<!--**********************************
    Main wrapper start
***********************************-->
<div id="main-wrapper">

    <!--**********************************
        Nav header start
    ***********************************-->

    <div class="nav-header">
        <a href="{{route('dashboard')}}" class="brand-logo">
{{--            <img class="logo-abbr" src="{{asset('assets/images/lyf-logo.png')}}" alt="">--}}
            @if(auth()->user()->role!=3)
            <img class="logo-compact" src="{{asset('assets/images/lyf-logo.png')}}" alt="">
            <img class="brand-title" src="{{asset('assets/images/lyf-logo.png')}}" alt="">
            @else
            @if(!empty($data['hospital_info']->banner))
            <img class="brand-title" src="{{asset('storage/'. $data['hospital_info']->banner)}}" alt="hospital_brand_title">
            <img class="logo-compact" src="{{asset('storage/'. $data['hospital_info']->banner)}}" alt="hospital_logo_compact">
            @else
            <img class="logo-compact" src="{{asset('assets/images/lyf-logo.png')}}" alt="">
            <img class="brand-title" src="{{asset('assets/images/lyf-logo.png')}}" alt="">
            @endif
            @endif
        </a>

        <div class="nav-control">
            <div class="hamburger">
                <span class="line"></span><span class="line"></span><span class="line"></span>
            </div>
        </div>
    </div>
    <!--**********************************
        Nav header end
    ***********************************-->

    <!--**********************************
        Header start
    ***********************************-->

    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">
                            {{$data['pageName']}}
                        </div>
                    </div>

                    <ul class="navbar-nav header-right">
                        <li class="nav-item dropdown notification_dropdown">
                            <a class="nav-link dz-fullscreen" href="javascript:void(0);">
                                <svg id="icon-full" viewBox="0 0 24 24" width="26" height="26" stroke="currentColor"
                                     stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                     class="css-i6dzq1">
                                    <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path>
                                </svg>
                                <svg id="icon-minimize" width="26" height="26" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-minimize">
                                    <path d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3"></path>
                                </svg>
                            </a>
                        </li>
                        <li class="nav-item dropdown header-profile">
                            <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                                <div class="header-info">
                                    <span>{{auth()->user()->name}}</span>
                                    @if(auth()->user()->role == 1)
                                        <small>SUPERADMIN</small>
                                    @endif
                                </div>
                                @if(auth()->user()->role!=3)
                                <img src="{{asset('storage/'.auth()->user()->image)}}" width="20" alt=""/>
                                @else
                                @if(!empty($data['hospital_info']->logo))
                                <img src="{{asset('storage/'. $data['hospital_info']->logo)}}" width="20" alt=""/>
                                @else
                                <img src="{{asset('storage/'.auth()->user()->image)}}" width="20" alt=""/>
                                @endif
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                {{--<a href="#" class="dropdown-item ai-icon">--}}
                                    {{--<svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary"--}}
                                         {{--width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"--}}
                                         {{--stroke-width="2" stroke-linecap="round" stroke-linejoin="round">--}}
                                        {{--<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>--}}
                                        {{--<circle cx="12" cy="7" r="4"></circle>--}}
                                    {{--</svg>--}}
                                    {{--<span class="ms-2">Profile </span>--}}
                                {{--</a>--}}
                                {{--<a href="#" class="dropdown-item ai-icon">--}}
                                    {{--<svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success"--}}
                                         {{--width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"--}}
                                         {{--stroke-width="2" stroke-linecap="round" stroke-linejoin="round">--}}
                                        {{--<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>--}}
                                        {{--<polyline points="22,6 12,13 2,6"></polyline>--}}
                                    {{--</svg>--}}
                                    {{--<span class="ms-2">Inbox </span>--}}
                                {{--</a>--}}
                                <a href="{{ route('logout') }}" class="dropdown-item ai-icon">
                                    <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger"
                                         width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg>
                                    <span class="ms-2">Logout </span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <!--**********************************
        Header end ti-comment-alt
    ***********************************-->


@switch(auth()->user()->role)
    @case('1')
    @include('layouts.navigation.superadmin')
    @break
    @case('2')
    @include('layouts.navigation.admin')
    @break
    @case('3')
    @include('layouts.navigation.hospital-admin')
    @break
    @case('4')
    @include('layouts.navigation.branch-admin')
    @break
    @case('9')
    @include('layouts.navigation.private-ambulance-admin')
    @break
    @case('12')
    @include('layouts.navigation.customer-support-manager')
    @break
    @default
@endswitch

<!--**********************************
        Content body start
    ***********************************-->
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">

            @if(!isset($home) && isset($data['pageName']))
                <div class="row page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">{{$data['pageName']}} :</a></li>
                    </ol>
                </div>
                @else

                <div class="form-head d-flex mb-3 mb-md-5 align-items-start flex-wrap justify-content-between">
                    <div class="me-auto d-lg-block">
                        <h3 class="text-primary font-w600">Welcome to LyfGuard!</h3>
                    </div>
                </div>

            @endif

            @yield('content')
        </div>
    </div>
    <!--**********************************
        Content body end
    ***********************************-->


    <!--**********************************
        Footer start
    ***********************************-->
    <div class="footer">
        <div class="copyright">
            <p>Copyright © LyfGuard &amp; <script>document.write(new Date().getFullYear())</script></p>
        </div>
    </div>
    <!--**********************************
        Footer end
    ***********************************-->

    <!--**********************************
       Support ticket button start
    ***********************************-->

    <!--**********************************
       Support ticket button end
    ***********************************-->


</div>
<!--**********************************
    Main wrapper end
***********************************-->

<style>

    input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }
</style>


<!--**********************************
    Scripts
***********************************-->
<!-- Required vendors -->
<script src="{{asset('assets/vendor/global/global.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('assets/js/custom.js')}}"></script>
<script src="{{asset('assets/js/deznav-init.js')}}"></script>

<!-- Apex Chart -->
<!-- <script src="{{asset('assets/vendor/apexchart/apexchart.js')}}"></script> -->

<!-- Dashboard 1 -->
<script src="{{asset('assets/js/dashboard/dashboard-1.js')}}"></script>
{{--<script src="{{asset('assets/js/styleSwitcher.js')}}"></script>--}}

<script>
    $('document').ready(function () {
        $('textarea').each(function () {
                $(this).val($(this).val().trim());
            }
        );
    });
</script>
<style>
    td.data-trim {
        max-width: 300px;
    }
    td.data-trim-m {
        max-width: 200px;
    }

    td.data-trim span {
        white-space: initial;
        height: 100px;
        overflow-y: scroll;
        display: inline-block;
        max-width: 100%;
    }

    td.data-trim-m span {
        white-space: initial;
        height: 100px;
        overflow-y: scroll;
        display: inline-block;
        max-width: 100%;
    }

    div#at-expanding-share-button {
        display: none;
    }

    a.DZ-bt-support-now.DZ-theme-btn {
        display: none;
    }

    a.DZ-bt-buy-now.DZ-theme-btn {
        display: none;
    }
</style>

@yield('script')

</body>
</html>
