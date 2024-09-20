@extends('layouts.panel')

@section('headscript')
    <link rel="stylesheet" href="{{asset('assets/vendor/select2/css/select2.min.css')}}">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$data['pageName']}}</h4>
                </div>
                <div class="card-body">
                    @include('incl.message')
                    <div class="form-validation">
                        <form class="form-valide" action="{{route('updatePrivateAmbulanceDriver', $data['private_ambulance_driver_info']->id)}}" method="post"  enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-xl-10">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   value="{{ $data['private_ambulance_driver_info']->name }}" id="val-name"
                                                   name="name"
                                                   placeholder="Enter Name" required>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Licence Number
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('licence_number') is-invalid @enderror"
                                                   value="{{ $data['private_ambulance_driver_info']->licence_number }}" id="val-website" name="licence_number"
                                                   placeholder="Enter Licence Number" required>
                                            @error('licence_number')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Blood Group
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('blood_group') is-invalid @enderror"
                                                   value="{{ $data['private_ambulance_driver_info']->blood_group }}" id="val-blood_group" name="blood_group"
                                                   placeholder="Enter Blood Group" required>
                                            @error('blood_group')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <?php /* 
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Address Line1
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <textarea type="text"
                                                      id="address"
                                                      class="form-control @error('address_line1') is-invalid @enderror"
                                                      name="address_line1"
                                                      placeholder="Enter Address Line1" required
                                                      autocomplete="off"></textarea>
                                            @error('address_line1')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">
                                        </label>
                                        <div class="col-lg-8">
                                            <div id="map"></div>
                                            <div id="infowindow-content">
                                                <img src="" width="16"
                                                     height="16"
                                                     id="place-icon">
                                                <span id="place-name"
                                                      class="title"></span><br>
                                                <span id="place-address"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden"
                                           class="form-control @error('pincode') is-invalid @enderror"
                                           value="{{ old('pincode') }}" id="pin_code" name="pincode"
                                           placeholder="Enter pincode" readonly>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Address Line2
                                        </label>
                                        <div class="col-lg-8">
                                            <textarea type="text"
                                                   class="form-control @error('address_line2') is-invalid @enderror"
                                                   id="val-username" name="address_line2"
                                                      placeholder="Enter Address Line2">{{old('address_line2')}}</textarea>
                                            @error('address_line2')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div> 
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Country
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('country') is-invalid @enderror"
                                                   value="{{ old('country') }}" id="country" name="country"
                                                   placeholder="Enter Country" required readonly>
                                            @error('country')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">State
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('state') is-invalid @enderror"
                                                   value="{{ old('state') }}" id="state_name" name="state"
                                                   placeholder="Enter State" required readonly>
                                            @error('state')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">City
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('city') is-invalid @enderror"
                                                   value="{{ old('city') }}" id="city_name" name="city"
                                                   placeholder="Enter City" required readonly>
                                            @error('city')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Latitude
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('latitude') is-invalid @enderror"
                                                   value="{{ old('latitude') }}" id="latitude" name="latitude"
                                                   placeholder="Enter Latitude" required readonly>
                                            @error('latitude')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Longitude
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('longitude') is-invalid @enderror"
                                                   value="{{ old('longitude') }}" id="longitude" name="longitude"
                                                   placeholder="Enter Longitude" required readonly>
                                            @error('longitude')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>*/?>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Phone
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="number"
                                                   class="form-control @error('username') is-invalid @enderror"
                                                   value="{{ $data['private_ambulance_driver_info']->phone }}" id="val-phone" name="username"
                                                   placeholder="Enter Phone" required>
                                            @error('username')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-2 ml-auto">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                        <div class="col-lg-2 ml-auto">
                                            <a class="btn btn btn-success" href="{{ route('listPrivateAmbulanceDriver') }}">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <!-- Jquery Validation -->
    <script src="{{asset('assets/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <!-- Form validate init -->
    <script src="{{asset('assets/js/plugins-init/jquery.validate-init.js')}}"></script>


    <script src="{{asset('assets/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins-init/select2-init.js')}}"></script>
@endsection

