

<div class="row">
    <div class="col-xl-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                   
                    <h4 class="card-title" id="notify_check">Notify User  : </h4>
                    <button class="btn btn-primary" id="notifyuser">Edit</button>
                   
                    <input type="hidden" id="redirect_id" value="0">
                   
                </div>
                <div class="card-body hideshowredirect">
                    <div class="basic-form">
                        <form class="form-valide" action="{{route('updateNotifyUser')}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-check form-check-inline">
                                <input class="form-check-input check_notfiy" type="radio" name="notify_to" id="inlineRadio1" value="1" {{(auth()->user()->notify_to == 1) ? 'checked' : ''}} required>
                                <label class="form-check-label" for="inlineRadio1">Driver</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input check_notfiy" type="radio" name="notify_to" id="inlineRadio2" value="2" {{(auth()->user()->notify_to == 2) ? 'checked' : ''}} required>
                                <label class="form-check-label" for="inlineRadio2">Booking Manager</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <button type="submit" class="btn btn-success btn-sm" id="savedata">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-xxl-12">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="app-stat card bg-danger">
                        <div class="card-body  p-4">
                            <div class="media flex-wrap">
											<span class="me-3">
												<i class="flaticon-381-calendar-1"></i>
											</span>
                                <div class="media-body text-white text-end">
                                    <p class="mb-1">Total bookings</p>
                                    <h3 class="text-white">{{$data['bookings']}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="app-stat card bg-primary">
                        <div class="card-body p-4">
                            <div class="media flex-wrap">
											<span class="me-3">
												<i class="flaticon-381-diamond"></i>
											</span>
                                <div class="media-body text-white text-end">
                                    <p class="mb-1">Completed Bookings</p>
                                    <h3 class="text-white">{{$data['completedBookings']}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="app-stat card bg-primary">
                        <div class="card-body p-4">
                            <div class="media flex-wrap">
											<span class="me-3">
												<i class="flaticon-381-diamond"></i>
											</span>
                                <div class="media-body text-white text-end">
                                    <p class="mb-1">On Going Bookings</p>
                                    <h3 class="text-white">{{$data['onGoingBookings']}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="app-stat card bg-primary">
                        <div class="card-body p-4">
                            <div class="media flex-wrap">
											<span class="me-3">
												<i class="flaticon-381-diamond"></i>
											</span>
                                <div class="media-body text-white text-end">
                                    <p class="mb-1">Cancelled Bookings</p>
                                    <h3 class="text-white">{{$data['cancelBookings']}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="app-stat card bg-success">
                        <div class="card-body p-4">
                            <div class="media flex-wrap">
											<span class="me-3">
												<i class="flaticon-381-user-7"></i>
											</span>
                                <div class="media-body text-white text-end">
                                    <p class="mb-1 text-nowrap">Clients</p>
                                    <h3 class="text-white">{{$data['users']}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="app-stat card bg-info">
                        <div class="card-body p-4">
                            <div class="media flex-wrap">
											<span class="me-3">
												<i class="flaticon-381-heart"></i>
											</span>
                                <div class="media-body text-white text-end">
                                    <p class="mb-1 text-nowrap">Downloads</p>
                                    <h3 class="text-white">0</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="app-stat card bg-info">
                        <div class="card-body p-4">
                            <div class="media flex-wrap">
											<span class="me-3">
												<i class="flaticon-381-heart"></i>
											</span>
                                <div class="media-body text-white text-end">
                                    <p class="mb-1 text-nowrap">Avg time taken for completed bookings</p>
                                    <h3 class="text-white">0</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="app-stat card bg-info">
                        <div class="card-body p-4">
                            <div class="media flex-wrap">
											<span class="me-3">
												<i class="flaticon-381-heart"></i>
											</span>
                                <div class="media-body text-white text-end">
                                    <p class="mb-1 text-nowrap">Avg time taken to respond</p>
                                    <h3 class="text-white">0</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="app-stat card bg-info">
                        <div class="card-body p-4">
                            <div class="media flex-wrap">
											<span class="me-3">
												<i class="flaticon-381-heart"></i>
											</span>
                                <div class="media-body text-white text-end">
                                    <p class="mb-1 text-nowrap">Total earnings emergency / non-critical </p>
                                    <h3 class="text-white">0</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="app-stat card bg-info">
                        <div class="card-body p-4">
                            <div class="media flex-wrap">
											<span class="me-3">
												<i class="flaticon-381-heart"></i>
											</span>
                                <div class="media-body text-white text-end">
                                    <p class="mb-1 text-nowrap">Total online payments / offline payments</p>
                                    <h3 class="text-white">0</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="app-stat card bg-info">
                        <div class="card-body p-4">
                            <div class="media flex-wrap">
											<span class="me-3">
												<i class="flaticon-381-heart"></i>
											</span>
                                <div class="media-body text-white text-end">
                                    <p class="mb-1 text-nowrap">Wallet Balance</p>
                                    <h3 class="text-white">{{$data['walletBalance']}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

