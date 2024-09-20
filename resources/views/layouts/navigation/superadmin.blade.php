<!--**********************************
    Sidebar start
***********************************-->
<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">SuperAdmin</li>
            <br/>
            <li><a class="ai-icon" href="{{route('dashboard')}}" aria-expanded="false">
                    <svg id="icon-pages" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="feather feather-grid">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
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
                    <li><a href="{{route('listBranchType')}}">Branch Types</a></li>
                    <li><a href="{{route('listSpeciality')}}">Speciality</a></li>
                    <li><a href="{{route('listService')}}">Services</a></li>
                    <li><a href="{{route('listAmenity')}}">Hospital Amenities</a></li>
                    <li><a href="{{route('listFirstAidCategory')}}">First Aid Categories</a></li>
                    <li><a href="{{route('listAmbulanceType')}}">Ambulance Types</a></li>
                    <li><a href="{{route('listEmergencyType')}}">Emergency Types</a></li>
                    <li><a href="{{route('listPrivateAmbulanceType')}}">Private Ambulance Types</a></li>
                    <li><a href="{{route('listPrivateAmbulanceAmenity')}}">Private Ambulance Amenities</a></li>
                </ul>

            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-layer-1"></i>
                    <span class="nav-text">Listing</span>
                </a>
                <ul aria-expanded="false">
                    @if($menuItems = App\Models\ListingType::orderBy('id','asc')->where('status', 1)->get())
                        @foreach($menuItems as $menuItem)
                            <li><a href="{{route('listListing', $menuItem->id)}}">{{$menuItem->name}}</a></li>
                        @endforeach
                    @endif
                </ul>

            </li>
            <li><a class="ai-icon" href="{{route('listFirstAid')}}" aria-expanded="false">
                    <i class="flaticon-381-settings-2"></i>
                    <span class="nav-text">First Aid</span>
                </a>
            </li>
            <li><a class="ai-icon" href="{{route('listHospital')}}" aria-expanded="false">
                    <i class="flaticon-381-plus"></i>
                    <span class="nav-text">Hospital</span>
                </a>
            </li>
            <li><a class="ai-icon" href="{{route('listBranch')}}" aria-expanded="false">
                    <i class="flaticon-381-settings-2"></i>
                    <span class="nav-text">Branches</span>
                </a>
            </li>
            <li><a class="ai-icon" href="{{route('listPrivateAmbulanceAdmin')}}" aria-expanded="false">
                    <i class="flaticon-381-user"></i>
                    <span class="nav-text">Private Ambulance Admin</span>
                </a>
            </li>
            <li><a class="ai-icon" href="{{route('listUser')}}" aria-expanded="false">
                    <i class="flaticon-381-user"></i>
                    <span class="nav-text">Users</span>
                </a>
            </li>
            <li><a class="ai-icon" href="{{route('listCustomerSupport')}}" aria-expanded="false">
                    <i class="flaticon-381-user"></i>
                    <span class="nav-text">Customer Support Manager</span>
                </a>
            </li>
            <li><a class="ai-icon" href="{{route('addBalanceToWallet')}}" aria-expanded="false">
                    <i class="flaticon-381-plus"></i>
                    <span class="nav-text">Add Balance</span>
                </a>
            </li>
            <!-- <li><a class="ai-icon" href="{{route('addBalanceToWallet')}}" aria-expanded="false">
                    <i class="flaticon-381-plus"></i>
                    <span class="nav-text">Employee Customer Support Profile</span>
                </a>
            </li> -->
        </ul>
    </div>


</div>
<!--**********************************
    Sidebar end
***********************************-->