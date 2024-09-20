@extends('layouts.panel')

@section('headscript')
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
                        <form class="form-valide" action="{{route('storePrivateAmbulanceType')}}" method="post"  enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xl-10">
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

                                    <?php /*
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Has Amenity
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="col-xl-4 col-xxl-6 col-6">
                                            <div class="form-check custom-checkbox mb-3">
                                                <input type="checkbox" class="form-check-input" name="has_amenity"
                                                       id="customCheckBox1">
                                                <label class="form-check-label" for="customCheckBox1">Has Amenity</label>
                                            </div>
                                            @error('has_amenity')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    */?>

                                    <?php /*
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Image
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="file"
                                                   class="form-control @error('image') is-invalid @enderror"
                                                   value="{{ old('image') }}" id="val-username" name="image"
                                                   placeholder="Enter website" required accept="image/*">
                                            @error('image')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Description
                                        </label>
                                        <div class="col-lg-8">
                                            <textarea type="text"
                                                   class="form-control @error('description') is-invalid @enderror"
                                                   id="val-username" name="description"
                                                      placeholder="Enter Description">{{old('description')}}</textarea>
                                            @error('description')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Price
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('price') is-invalid @enderror"
                                                   value="{{ old('price') }}" id="val-price" name="price"
                                                   placeholder="Enter Price" required>
                                            @error('price')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    */?>
                                    <div class="form-group row">
                                        <div class="col-lg-2 ml-auto">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                        <div class="col-lg-2 ml-auto">
                                            <a class="btn btn btn-success" href="{{ route('listPrivateAmbulanceType') }}">Cancel</a>
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

