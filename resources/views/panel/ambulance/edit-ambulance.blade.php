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
                        <form class="form-valide" action="{{route('updateAmbulance', $data['ambulance']->id)}}" method="post"  enctype="multipart/form-data">
                            @csrf
                            @method('put')
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
                                                        <option value="{{$type->id}}" {{$data['ambulance']->type_id == $type->id  ? 'selected' : ''}}>{{$type->name}}</option>
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
                                        <label class="col-lg-4 col-form-label" for="val-username">Vehicle Number
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('vehicle_number') is-invalid @enderror"
                                                   value="{{ $data['ambulance']->vehicle_number }}" name="vehicle_number"
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
                                                   value="{{ $data['ambulance']->insurance_date }}" id="insurance_date" name="insurance_date"
                                                   placeholder="Enter Insurance Date" required>
                                            @error('insurance_date')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Documents
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="file"
                                                   class="form-control @error('documents') is-invalid @enderror"
                                                   value="{{ old('documents') }}" id="documents" name="documents[]" multiple>
                                            @error('documents')
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
                                            <a class="btn btn btn-success" href="{{ route('listAmbulance') }}">Cancel</a>
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
@endsection

