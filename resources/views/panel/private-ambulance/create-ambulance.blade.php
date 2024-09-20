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
                        <form class="form-valide" action="{{route('storePrivateAmbulance')}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xl-10">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Type
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <select id="single-select amenity"
                                                    class="type disabling-options type @error('type') is-invalid @enderror"
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

                                    <div class="col-xl-12" id="amenities" style="display: none">
                                        <div class="row">
                                            
                                                <div class="form-group row amenityRow">
                                                    <div class="col-xl-5">
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-username">Amenity
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-8">
                        <select class="amenity disabling-options @error('amenity') is-invalid @enderror"
                                                                name="amenity[]" data-id="1">
                                                            <option value="">Select Amenity</option>
                                                            @if($data['amenities'])
                                                                @foreach($data['amenities'] as $amenity)
                                                                    <option value="{{$amenity->id}}"
                                                                            data-price="{{$amenity->price}}">{{$amenity->name.' (Price : '.$amenity->price.')'}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                        @error('amenity')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
            </div>
                                                
                                            
                                            <div class="col-xl-4">
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-username">Price
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-8">
                        <input type="text"
                               class="form-control @error('price') is-invalid @enderror price"
                               value="{{ old('price') }}" id="price" name="price[]"
                               placeholder="Enter Price" required>
                        @error('price')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
            </div>

                                            <div class="col-xl-3 mt-2">
                                                <button type="button" onclick="myfunction()"
                                                        class="btn btn-primary btn-sm">
                                                    <i class="fa fa-plus-square"></i> Add More
                                                </button>
                                            </div>
                                        </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Vehicle Number
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('vehicle_number') is-invalid @enderror"
                                                   value="{{ old('vehicle_number') }}" name="vehicle_number"
                                                   placeholder="Enter Vehicle Number" required>
                                            @error('vehicle_number')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Insurance Date
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   value="{{ old('insurance_date') }}" id="insurance_date"
                                                   name="insurance_date"
                                                   placeholder="Enter Insurance Date" required autocomplete="off">
                                            @error('insurance_date')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Registration Certificate
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="file"
                                                   class="form-control @error('registration_certificate') is-invalid @enderror"
                                                   value="{{ old('registration_certificate') }}" id="registration_certificate" name="registration_certificate" required>
                                            @error('registration_certificate')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">0 KM - 5 KM Per KM Rate (In Rupees)
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="number"
                                                   class="form-control @error('0_5km_rate') is-invalid @enderror"
                                                   value="{{ old('0_5km_rate') }}" name="0_5km_rate"
                                                   placeholder="Enter 0 KM - 5 KM Per KM Rate" required>
                                            @error('0_5km_rate')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">5 KM - 15 KM Per KM Rate (In Rupees)
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="number"
                                                   class="form-control @error('5_15km_rate') is-invalid @enderror"
                                                   value="{{ old('5_15km_rate') }}" name="5_15km_rate"
                                                   placeholder="Enter 5 KM - 15 KM Per KM Rate" required>
                                            @error('5_15km_rate')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">15 KM - 30 KM Per KM Rate (In Rupees)
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="number"
                                                   class="form-control @error('15_30km_rate') is-invalid @enderror"
                                                   value="{{ old('15_30km_rate') }}" name="15_30km_rate"
                                                   placeholder="Enter 15 KM - 30 KM Per KM Rate" required>
                                            @error('15_30km_rate')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">30+ KM Per KM Rate (In Rupees)
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="number"
                                                   class="form-control @error('30_abovekm_rate') is-invalid @enderror"
                                                   value="{{ old('30_abovekm_rate') }}" name="30_abovekm_rate"
                                                   placeholder="Enter 30+ KM Per KM Rate" required>
                                            @error('30_abovekm_rate')
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
                                            <a class="btn btn btn-success" href="{{ route('listPrivateAmbulance') }}">Cancel</a>
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
    <div id="amenityItem" style="display: none">
        <div class="row amenityRow">
            <div class="col-xl-5">
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-username">Amenity
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-8">
                        <select class="amenity form-control @error('amenity') is-invalid @enderror"
                                name="amenity[]" required>
                            <option value="">Select Amenity</option>
                            @if($data['amenities'])
                                @foreach($data['amenities'] as $amenity)
                                    <option value="{{$amenity->id}}"
                                            data-price="{{$amenity->price}}">{{$amenity->name.' (Price : '.$amenity->price.')'}}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('amenity')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-username">Price
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-8">
                        <input type="text"
                               class="form-control @error('price') is-invalid @enderror price"
                               value="{{ old('price') }}" id="price" name="price[]"
                               placeholder="Enter Price" required>
                        @error('price')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-xl-3 mt-2">
                <button type="button" class="btn-close removeAmenity" data-bs-dismiss="alert" aria-label="btn-close">
                </button>
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



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script>
        $().ready(function () {
            $("#insurance_date").datepicker({
                dateFormat: 'yy-mm-dd',
                changeYear: true,
                yearRange: "-15:+100",
//                minDate: "dateToday",
                changeMonth: true
            });
        });
    </script>


    <script>
        $(document).ready(function () {

            $(".type").change(function () {
                var typeID = $(this).val();
                var items = '';
                $.ajax({
                    url: '{{route('ajax_ambulance_type')}}',
                    dataType: 'json',
                    data: {type_id: typeID},
                    success: function (result) {
                        if (result.has_amenity == 1) {
                            $(".amenity").attr('required', true);
                            $("#price").attr('required', true);
                            $("#amenities").show();
                        } else {
                            $(".amenity").attr('required', false);
                            $("#price").attr('required', false);
                            $("#amenities").hide();
                        }
                    }
                });
            });

//             $(document).on("change", ".amenity", function () {
// //            $('.amenity').change(function () {
//                 var amenityPrice = $(this).find('option:selected').data('price');
//                 //console.log(amenityPrice.length);
//                 //$('#price').val(amenityPrice);
//                 $(this).closest('.amenityRow').find('#price').val(amenityPrice);
//                     //alert(amenityPrice);
// //                alert(amenityPrice);
// //                $(this).parent().find('.amenityRow #price').val(amenityPrice);
// //                $(this).closest('.amenityRow #price').val(amenityPrice);
// //                $($(this).parents(".amenityRow")+ "#price").val(price);
//             });
//                .change();
            $(document).on('change', '.amenity', function () {
    var amenityPrice = $(this).find('option:selected').data('price');
   // alert(amenityPrice);
    // Find the closest .amenityRow and then find the .price input within it
    $(this).closest('.amenityRow').find('.price').val(amenityPrice || '');
});
        });
    </script>

    <script>
        function myfunction() {
            var html = $("#amenityItem").html();
            $('#amenities').append(html);
//        }
        }

        $("body").on("click", ".removeAmenity", function () {
            $(this).parents(".amenityRow").remove();
        });
    </script>
@endsection

