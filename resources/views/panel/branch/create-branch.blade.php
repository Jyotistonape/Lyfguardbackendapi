@extends('layouts.panel')

@section('headscript')
    @include('layouts.map')
    <link rel="stylesheet" href="{{asset('assets/vendor/select2/css/select2.min.css')}}">
    <link href="{{asset('assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <style type="text/css">
        #map {
  width: 100px !important;
  height: 100px !important;
}
    </style>
{{--    <script src="{{asset('assets/vendor/global/global.min.js')}}" defer></script>--}}
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
                        <form class="form-valide" action="{{route('storeBranch')}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xl-10">
                                    @if(auth()->user()->role == 1)
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Hospital
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-8">
                                                <select class="dropdown-groups disabling-options hospital @error('hospital') is-invalid @enderror"
                                                        name="hospital" required>
                                                    <option value="">Select Hospital</option>
                                                    @if($data['hospitals'])
                                                        @foreach($data['hospitals'] as $hospital)
                                                            <option value="{{$hospital->id}}">{{$hospital->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('hospital')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Type
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <select id="branch_type single-select"
                                                    class="disabling-options branch_type @error('type') is-invalid @enderror"
                                                    name="type" required>
                                                <option value="">Select Type</option>
                                                @if($data['types'])
                                                    @foreach($data['types'] as $type)
                                                        <option value="{{$type->id}}">{{$type->name}}</option>
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
                                        <label class="col-lg-4 col-form-label" for="val-username">Specialities
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <select
                                                    class="multi-select disabling-options specialities @error('speciality_ids') is-invalid @enderror"
                                                    name="speciality_ids[]" required multiple>
                                            </select>
                                            @error('speciality_ids')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Is Partner
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <select
                                                    class="single-select disabling-options partner @error('is_partner') is-invalid @enderror"
                                                    name="is_partner" required>
                                                <option value="">Please Select</option>
                                                <option value="1">Partner</option>
                                                <option value="2">Listing</option>
                                            </select>
                                            @error('is_partner')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Emergency Types
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <select id="multiple-select"
                                                    class="disabling-options emergency_types @error('emergency_types') is-invalid @enderror"
                                                    name="emergency_types[]" required multiple>
                                                <option value="">Select Emergency Type</option>
                                                @if($data['emergencyTypes'])
                                                    @foreach($data['emergencyTypes'] as $type)
                                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('emergency_types')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Branch Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('branch_name') is-invalid @enderror"
                                                   value="{{ old('branch_name') }}" id="val-username"
                                                   name="branch_name"
                                                   placeholder="Enter Branch Name" required>
                                            @error('branch_name')
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
                                            <input type="url"
                                                   class="form-control @error('website') is-invalid @enderror"
                                                   value="{{ old('website') }}" id="val-website" name="website"
                                                   placeholder="Enter website">
                                            @error('website')
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
                                                   value="{{ old('phone') }}" id="val-phone" name="phone"
                                                   placeholder="Enter Phone" required>
                                            @error('phone')
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
                                                <img src="{{asset('assets/images/mappicicon.png')}}" width="16"
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
                                    </div> */
                                        ?>
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
                                        <label class="col-lg-4 col-form-label" for="val-username">Is Emergency
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="col-xl-4 col-xxl-6 col-6">
                                            <div class="form-check custom-checkbox mb-3">
                                                <input type="checkbox" class="form-check-input" name="is_emergency"
                                                       id="customCheckBox1">
                                                <label class="form-check-label" for="customCheckBox1">Is
                                                    Emergency</label>
                                            </div>
                                            @error('is_emergency')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Branch Admin Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   value="{{ old('name') }}" id="val-name" name="name"
                                                   placeholder="Enter Branch Admin Name" required>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Branch Admin
                                            Email
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="email"
                                                   class="form-control @error('username') is-invalid @enderror"
                                                   value="{{ old('username') }}" id="val-email" name="username"
                                                   placeholder="Enter Branch Admin Email" required>
                                            @error('username')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Branch Admin
                                            Password
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   value="{{ old('password') }}" id="val-password" name="password"
                                                   placeholder="Enter Branch Admin Password" required>
                                            @error('password')
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
                                        <div class="col-lg-2 ml-auto">
                                            <a class="btn btn btn-success" href="{{ route('listBranch') }}">Cancel</a>
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
    <script>
        $(document).ready(function () {
            $(".branch_type").change(function () {
                var typeID = $(this).val();
                // alert(typeID);
                var items = '';
                $(".specialities").html(items
                );
                $.ajax({
                    url: '{{route('ajaxSpeciality')}}',
                    dataType: 'json',
                    data: {branch_type_id: typeID},
                    success: function (result) {
                        // console.log(result);
                        result.forEach(function (data) {
                            items = items + '<option value="' + data.id + '">' + data.name + "</option>";

                        });
                        $(".specialities").html(
                            items
                        );
                    }
                });
            });
        });
    </script>
@endsection

