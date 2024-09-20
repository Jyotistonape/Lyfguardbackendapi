

<!--**********************************
    Sidebar start
***********************************-->
<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Admin</li>
            <br/>
            <li><a class="ai-icon" href="{{route('dashboard')}}" aria-expanded="false">
                    <svg id="icon-pages" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-internet"></i>
                    <span class="nav-text">Master Data</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('listListingType')}}">Listing Types</a></li>
                    <li><a href="{{route('listHospitalType')}}">Hospital Types</a></li>
                    <li><a href="#">First Aid Categories</a></li>
                </ul>

            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-layer-1"></i>
                    <span class="nav-text">Listing</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('listListing', 1)}}">Police</a></li>
                    <li><a href="{{route('listListing', 2)}}">Fire</a></li>
                    <li><a href="{{route('listListing', 3)}}">Blood Bank</a></li>
                </ul>

            </li>
            <li><a class="ai-icon" href="{{route('listHospital')}}" aria-expanded="false">
                    <i class="flaticon-381-diamond"></i>
                    <span class="nav-text">Hospital</span>
                </a>
            </li>
        </ul>
    </div>


</div>
<!--**********************************
    Sidebar end
***********************************-->