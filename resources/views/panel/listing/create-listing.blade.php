@extends('layouts.panel')

@section('headscript')
    @include('layouts.map')
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
                    <?php
                    $url = url()->previous();
                    if(strpos($url, 'panel/listing/') !== false){
                    $urlArray = explode('panel/listing/', $url);
                    $typeID = $urlArray[1];
                    }
                    ?>
                    <div class="form-validation">
                        <form class="form-valide" action="{{route('storeListing')}}" method="post"  enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xl-10">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Type
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <select id="single-select"
                                                    class="disabling-options type @error('type') is-invalid @enderror"
                                                    name="type" required>
                                                <option value="">Select Type</option>
                                                @if($data['types'])
                                                    @foreach($data['types'] as $type)
                                                        <option value="{{$type->id}}" {{(!empty($typeID) && $typeID == $type->id) ? 'selected' : ''}}>{{$type->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('type')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   value="{{ old('name') }}" id="val-name" name="name"
                                                   placeholder="Enter Name" required>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Email
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   value="{{ old('email') }}" id="val-username" name="email"
                                                   placeholder="Enter Email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Phone
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="number"
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   value="{{ old('phone') }}" id="val-username" name="phone"
                                                   placeholder="Enter Phone" required>
                                            @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Phone2
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="number"
                                                   class="form-control @error('phone2') is-invalid @enderror"
                                                   value="{{ old('phone2') }}" id="val-username" name="phone2"
                                                   placeholder="Enter Phone2">
                                            @error('phone2')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Phone3
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="number"
                                                   class="form-control @error('phone3') is-invalid @enderror"
                                                   value="{{ old('phone3') }}" id="val-username" name="phone3"
                                                   placeholder="Enter Phone3">
                                            @error('phone3')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Address Line1
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <textarea autocomplete="off"
                                                   id="address"
                                                   class="form-control @error('address_line1') is-invalid @enderror"
                                                   id="val-username" name="address_line1"
                                                      placeholder="Enter Address Line1" required></textarea>
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
                                        <label class="col-lg-4 col-form-label" for="val-username">Website
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('website') is-invalid @enderror"
                                                   value="{{ old('website') }}" id="val-username" name="website"
                                                   placeholder="Enter website">
                                            @error('website')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Image
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="file"
                                                   class="form-control @error('image') is-invalid @enderror"
                                                   value="{{ old('image') }}" id="val-username" name="image"
                                                   placeholder="Enter website" accept="image/*">
                                            @error('image')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-2 ml-auto">
                                            <button type="submit" class="btn btn-primary">Save</button>
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

