<div class="row">
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
                                    <p class="mb-1 text-nowrap">Drivers</p>
                                    <h3 class="text-white">{{$data['drivers']}}</h3>
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
                                    <p class="mb-1 text-nowrap">Ambulances</p>
                                    <h3 class="text-white">{{$data['ambulances']}}</h3>
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

