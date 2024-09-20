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
                        <form class="form-valide" action="{{route('storePrivateBooking')}}" method="post"
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
                                        <label class="col-lg-4 col-form-label" for="val-username">Amenities
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <select id="multiple-select"
                                                    class="type multi-select-placeholder disabling-options @error('amenities_ids') is-invalid @enderror"
                                                    name="amenities_ids[]" required multiple>
                                                @if($data['amenities'])
                                                    @foreach($data['amenities'] as $amenity)
                                                        <option value="{{$amenity->id}}">{{$amenity->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('amenities_ids')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Ambulance Type
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <select id="single-select"
                                                    class="ambulance_type disabling-options @error('ambulance_type_id') is-invalid @enderror"
                                                    name="ambulance_type_id" required>
                                                <option value="">Select Ambulance Type</option>
                                                @if($data['dataTypes'])
                                                    @foreach($data['dataTypes'] as $dataType)
                                                    <?php $amenityArray = array();
                                                    if($dataType['amenities']){
                                                        foreach($dataType['amenities'] as $amenity){
                                                            $amenityArray[] = $amenity->name;
                                                        }
                                                    }
                                                    $amenities = ($amenityArray) ? implode(', ', $amenityArray) : '';
                                                    ?>
                                                        <option value="{{$dataType['id']}}">{{$dataType['name']}} - ({{$amenities}})</option>
                                                    @endforeach
                                                    @endif
                                            </select>
                                            @error('ambulance_type_id')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Source Address
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <textarea type="text"
                                                      id="address"
                                                      class="form-control @error('address_line1') is-invalid @enderror"
                                                      name="address_line1"
                                                      placeholder="Enter Source Address" required
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
                                    <input type="hidden"
                                        class="form-control @error('pincode') is-invalid @enderror"
                                        value="{{ old('pincode') }}" id="pin_code" name="pincode"
                                        placeholder="Enter pincode" readonly>
                                    <input type="hidden"
                                            class="form-control @error('country') is-invalid @enderror"
                                            value="{{ old('country') }}" id="country" name="country"
                                            placeholder="Enter Country" required readonly>
                                    <input type="hidden"
                                            class="form-control @error('state') is-invalid @enderror"
                                            value="{{ old('state') }}" id="state_name" name="state"
                                            placeholder="Enter State" required readonly>
                                    <input type="hidden"
                                            class="form-control @error('city') is-invalid @enderror"
                                            value="{{ old('city') }}" id="city_name" name="city"
                                            placeholder="Enter City" required readonly>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Source Latitude
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('source_latitude') is-invalid @enderror"
                                                   value="{{ old('source_latitude') }}" id="latitude" name="source_latitude"
                                                   placeholder="Enter Source Latitude" required readonly>
                                            @error('source_latitude')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Source Longitude
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('source_longitude') is-invalid @enderror"
                                                   value="{{ old('source_longitude') }}" id="longitude" name="source_longitude"
                                                   placeholder="Enter Source Longitude" required readonly>
                                            @error('source_longitude')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Destination Address
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <textarea type="text"
                                                      id="destination_address"
                                                      class="form-control @error('destination_address_line1') is-invalid @enderror"
                                                      name="destination_address_line1"
                                                      placeholder="Enter Destination Address" required
                                                      autocomplete="off"></textarea>
                                            @error('destination_address_line1')
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
                                            <div id="destination-map"></div>
                                            <div id="destination-infowindow-content">
                                                <img src="" width="16"
                                                     height="16"
                                                     id="destination-place-icon">
                                                <span id="destination-place-name"
                                                      class="title"></span><br>
                                                <span id="destination-place-address"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden"
                                           class="form-control @error('destination_pincode') is-invalid @enderror"
                                           value="{{ old('destination_pincode') }}" id="destination_pin_code" name="destination_pincode"
                                           placeholder="Enter pincode" readonly>
                                    <input type="hidden"
                                            class="form-control @error('destination_country') is-invalid @enderror"
                                            value="{{ old('destination_country') }}" id="destination_country" name="destination_country"
                                            placeholder="Enter Country" required readonly>
                                    <input type="hidden"
                                            class="form-control @error('destination_state') is-invalid @enderror"
                                            value="{{ old('destination_state') }}" id="destination_state_name" name="destination_state"
                                            placeholder="Enter State" required readonly>
                                    <input type="hidden"
                                            class="form-control @error('destination_city') is-invalid @enderror"
                                            value="{{ old('destination_city') }}" id="destination_city_name" name="destination_city"
                                            placeholder="Enter City" required readonly>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Destination Latitude
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('destination_latitude') is-invalid @enderror"
                                                   value="{{ old('destination_latitude') }}" id="destination_latitude" name="destination_latitude"
                                                   placeholder="Enter Destination Latitude" required readonly>
                                            @error('destination_latitude')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Destination Longitude
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('destination_longitude') is-invalid @enderror"
                                                   value="{{ old('destination_longitude') }}" id="destination_longitude" name="destination_longitude"
                                                   placeholder="Enter Destination Longitude" required readonly>
                                            @error('destination_longitude')
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
                                            <button type="submit" id="saveData" class="btn btn-primary">Create</button>
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


    <!-- <script src="{{asset('assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script> -->
    <script src="{{asset('assets/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins-init/select2-init.js')}}"></script>

<script>
    // $(document).ready(function () {

    //     $(".type").change(function () {
    //         var amenitiesID = $(this).val();
    //         console.log(amenitiesID);
    //         var items = '';
    //         $(".ambulance_type").html(
    //             '<option>Select Ambulance Type</option>' + ''+ items
    //         );
    //         $.ajax({
    //             url: '{{route('ajax_ambulance_type_by_amenities')}}',
    //             dataType: 'json',
    //             data: {amenities: amenitiesID},
    //             success: function (result) {
    //                 console.log(result);
    //                 result.forEach(function (data) {
    //                     items = items + '<option value="' + data.id + '">' + data.name + "</option>";

    //                 });
    //                 $(".ambulance_type").html(
    //                     '<option>Select Ambulance Type</option>' + ''+ items
    //                 );
    //             }
    //         });
    //     });

    // });
</script>
@endsection

