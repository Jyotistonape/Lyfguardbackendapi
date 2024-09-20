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
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('frontend/assets/images/favicon.svg')}}"/>

    <link rel="stylesheet" href="{{asset('frontend/assets/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="https://cdn.lineicons.com/3.0/LineIcons.css"/>
    <link rel="stylesheet" href="{{asset('frontend/assets/css/animate.css')}}"/>
    <link rel="stylesheet" href="{{asset('frontend/assets/css/tiny-slider.css')}}"/>
    <link rel="stylesheet" href="{{asset('frontend/assets/css/glightbox.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('frontend/assets/css/main.css')}}"/>

</head>
<body>


<div class="preloader">
    <div class="preloader-inner">
        <div class="preloader-icon">
            <span></span>
            <span></span>
        </div>
    </div>
</div>


<header class="header navbar-area">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="nav-inner">

                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand" href="{{route('home')}}">
                            <img src="{{asset('frontend/assets/images/logo/white-logo.svg')}}" alt="Logo">
                        </a>
                        <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                            <ul id="nav" class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a href="#home" class="page-scroll active" aria-label="Toggle navigation">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#features" class="page-scroll" aria-label="Toggle navigation">Features</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#overview" class="page-scroll" aria-label="Toggle navigation">Overview</a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a href="#pricing" class="page-scroll" aria-label="Toggle navigation">Pricing</a>
                                </li> -->
                                <li class="nav-item">
                                    <a href="#team" class="page-scroll" aria-label="Toggle navigation">Team</a>
                                </li>
                                <li class="nav-item">
                                    <a class="page-scroll dd-menu collapsed" href="#blog" data-bs-toggle="collapse"
                                       data-bs-target="#submenu-1-4" aria-controls="navbarSupportedContent"
                                       aria-expanded="false" aria-label="Toggle navigation">Blog</a>
                                    <ul class="sub-menu collapse" id="submenu-1-4">
                                        <li class="nav-item"><a href="#">Blog Grid Sidebar</a>
                                        </li>
                                        <li class="nav-item"><a href="#">Blog Single</a></li>
                                        <li class="nav-item"><a href="#">Blog Single
                                                Sibebar</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" aria-label="Toggle navigation">Contact</a>
                                </li>
                            </ul>
                        </div>
                        <div class="button add-list-button">
                            <a href="#" class="btn">Join Us</a>
                        </div>
                    </nav>

                </div>
            </div>
        </div>
    </div>
</header>


@if(!isset($home) && isset($data['pageName']))
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-md-12 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">{{$data['pageName']}}</h1>
                    </div>
                    <ul class="breadcrumb-nav">
                        <li><a href="{{route('home')}}">Home</a></li>
                        <li>{{$data['pageName']}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif

@yield('content')

<footer class="footer">

    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">

                    <div class="single-footer f-about">
                        <div class="logo">
                            <a href="{{route('home')}}">
                                <img src="{{asset('frontend/assets/images/logo/white-logo.svg')}}" alt="#">
                            </a>
                        </div>
                        <p>Making the world a better place through constructing elegant hierarchies.</p>
                        <ul class="social">
                            <li><a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="lni lni-instagram"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="lni lni-linkedin-original"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="lni lni-youtube"></i></a></li>
                            <!-- <li><a href="javascript:void(0)"><i class="lni lni-pinterest"></i></a></li> -->
                        </ul>
                        <!-- <p class="copyright-text">Designed and Developed by <a href="https://uideck.com/" rel="nofollow"
                                                                               target="_blank">UIdeck</a>
                        </p> -->

                        <p class="copyright-text"> COPYRIGHTS RESERVER </p>
                    </div>

                </div>
                <div class="col-lg-8 col-md-8 col-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">

                            <div class="single-footer f-link">
                                <h3>Services</h3>
                                <ul>
                                    <li><a href="javascript:void(0)">Emergency Ambulance</a></li>
                                    <li><a href="javascript:void(0)">Private Ambulance</a></li>
                                    <li><a href="javascript:void(0)">Marturey</a></li>
                                    <li><a href="javascript:void(0)">First AID</a></li>
                                    <!-- <li><a href="javascript:void(0)">Promotion</a></li> -->
                                </ul>
                            </div>

                        </div>
                        <!-- <div class="col-lg-3 col-md-6 col-12">

                            <div class="single-footer f-link">
                                <h3>Support</h3>
                                <ul>
                                    <li><a href="javascript:void(0)">Pricing</a></li>
                                    <li><a href="javascript:void(0)">Documentation</a></li>
                                    <li><a href="javascript:void(0)">Guides</a></li>
                                    <li><a href="javascript:void(0)">API Status</a></li>
                                    <li><a href="javascript:void(0)">Live Support</a></li>
                                </ul>
                            </div>

                        </div> -->
                        <div class="col-lg-3 col-md-6 col-12">

                            <div class="single-footer f-link">
                                <h3>Company</h3>
                                <ul>
                                    <li><a href="javascript:void(0)">About Us</a></li>
                                    <li><a href="javascript:void(0)">Jobs</a></li>
                                    <li><a href="javascript:void(0)">Join us(Partner with Us)</a></li>
                                    <!-- <li><a href="javascript:void(0)">Press</a></li> -->
                                    <li><a href="javascript:void(0)">Contact Us</a></li>
                                </ul>
                            </div>

                        </div>
                        <div class="col-lg-3 col-md-6 col-12">

                            <div class="single-footer f-link">
                                <h3>Legal</h3>
                                <ul>
                                    <li><a href="{{route('termsConditions')}}">Terms & Conditions</a></li>
                                    <li><a href="{{route('privacyPolicy')}}">Privacy Policy</a></li>
                                    <!-- <li><a href="javascript:void(0)">Catering Services</a></li>
                                    <li><a href="javascript:void(0)">Customer Relations</a></li>
                                    <li><a href="javascript:void(0)">Innovation</a></li> -->
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="footer-newsletter">
        <div class="container">
            <div class="inner-content">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-5 col-12">
                        <div class="title">
                            <h3>Subscribe to our newsletter</h3>
                            <p>The latest news, articles, and resources, sent to your inbox weekly.</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-7 col-12">
                        <div class="form">
                            <form action="#" method="get" target="_blank" class="newsletter-form">
                                <input name="EMAIL" placeholder="Your email address" type="email">
                                <div class="button">
                                    <button class="btn">Subscribe<span class="dir-part"></span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>


<a href="#" class="scroll-top">
    <i class="lni lni-chevron-up"></i>
</a>


<script src="{{asset('frontend/assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/wow.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/tiny-slider.js')}}"></script>
<script src="{{asset('frontend/assets/js/glightbox.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/count-up.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/main.js')}}"></script>
<script type="text/javascript">
    //======== tiny slider
    tns({
        container: '.client-logo-carousel',
        autoplay: true,
        autoplayButtonOutput: false,
        mouseDrag: true,
        gutter: 15,
        nav: false,
        controls: false,
        responsive: {
            0: {
                items: 1,
            },
            540: {
                items: 2,
            },
            768: {
                items: 3,
            },
            992: {
                items: 4,
            }
        }
    });

    //========= testimonial
    tns({
        container: '.testimonial-slider',
        items: 3,
        slideBy: 'page',
        autoplay: false,
        mouseDrag: true,
        gutter: 0,
        nav: true,
        controls: false,
        controlsText: ['<i class="lni lni-arrow-left"></i>', '<i class="lni lni-arrow-right"></i>'],
        responsive: {
            0: {
                items: 1,
            },
            540: {
                items: 1,
            },
            768: {
                items: 1,
            },
            992: {
                items: 1,
            },
            1170: {
                items: 1,
            }
        }
    });

    //====== counter up
    var cu = new counterUp({
        start: 0,
        duration: 2000,
        intvalues: true,
        interval: 100,
        append: " ",
    });
    cu.start();
</script>
<script>(function () {
        var js = "window['__CF$cv$params']={r:'84652e720955561b',t:'MTcwNTM5NTc2Ni44MzcwMDA='};_cpo=document.createElement('script');_cpo.nonce='',_cpo.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js',document.getElementsByTagName('head')[0].appendChild(_cpo);";
        var _0xh = document.createElement('iframe');
        _0xh.height = 1;
        _0xh.width = 1;
        _0xh.style.position = 'absolute';
        _0xh.style.top = 0;
        _0xh.style.left = 0;
        _0xh.style.border = 'none';
        _0xh.style.visibility = 'hidden';
        document.body.appendChild(_0xh);

        function handler() {
            var _0xi = _0xh.contentDocument || _0xh.contentWindow.document;
            if (_0xi) {
                var _0xj = _0xi.createElement('script');
                _0xj.innerHTML = js;
                _0xi.getElementsByTagName('head')[0].appendChild(_0xj);
            }
        }

        if (document.readyState !== 'loading') {
            handler();
        } else if (window.addEventListener) {
            document.addEventListener('DOMContentLoaded', handler);
        } else {
            var prev = document.onreadystatechange || function () {
            };
            document.onreadystatechange = function (e) {
                prev(e);
                if (document.readyState !== 'loading') {
                    document.onreadystatechange = prev;
                    handler();
                }
            };
        }
    })();</script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317"
        integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA=="
        data-cf-beacon='{"rayId":"84652e720955561b","version":"2023.10.0","r":1,"token":"9a6015d415bb4773a0bff22543062d3b","b":1}'
        crossorigin="anonymous"></script>


@yield('script')

</body>
</html>
