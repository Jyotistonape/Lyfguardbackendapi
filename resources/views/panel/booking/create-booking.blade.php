@extends('layouts.panel')

@section('headscript')

    @include('layouts.map')
    <link rel="stylesheet" href="{{asset('assets/vendor/select2/css/select2.min.css')}}">
    <link href="{{asset('assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
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
                        <form class="form-valide" action="{{route('storeBooking')}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xl-10">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Phone
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="number"
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   value="{{ old('phone') }}" id="val-website" name="phone"
                                                   placeholder="Enter Phone" required>
                                            @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Emergency Type
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <select id="single-select"
                                                    class="disabling-options type @error('emergency_type') is-invalid @enderror"
                                                    name="emergency_type" required>
                                                <option value="">Select Emergency Type</option>
                                                @if($data['types'])
                                                    @foreach($data['types'] as $type)
                                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('emergency_type')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Address
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <textarea type="text"
                                                      id="address"
                                                      class="form-control @error('address_line1') is-invalid @enderror"
                                                      name="address_line1"
                                                      placeholder="Enter Address" required
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
                                    <?php /*  <div class="form-group row">
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
                                    </div> */?>
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
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Name
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   value="{{ old('name') }}" id="val-username"
                                                   name="name"
                                                   placeholder="Enter Name">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-8 ml-auto">
                                            <button type="submit" class="btn btn-primary">Create</button>
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


    <script src="{{asset('assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('assets/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins-init/select2-init.js')}}"></script>
@endsection

