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
                    <div class="form-validation">
                        <form class="form-valide" action="{{route('updateListing', $data['listing']->id)}}" method="post"  enctype="multipart/form-data">
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
                                                        <option value="{{$type->id}}" {{($data['listing']->type_id == $type->id) ? 'selected' : ''}}>{{$type->name}}</option>
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
                                                   value="{{ $data['listing']->name }}" id="val-name" name="name"
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
                                                   value="{{ $data['listing']->email }}" id="val-username" name="email"
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
                                                   value="{{ $data['listing']->phone }}" id="val-username" name="phone"
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
                                                   value="{{ $data['listing']->phone2 }}" id="val-username" name="phone2"
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
                                                   value="{{ $data['listing']->phone3 }}" id="val-username" name="phone3"
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
                                            <textarea type="text"
                                                   class="form-control @error('address_line1') is-invalid @enderror"
                                                   id="address" name="address_line1"
                                                      placeholder="Enter Address Line1" required>{{$data['listing']->address_line1}}</textarea>
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
                                           value="{{ $data['listing']->pincode }}" id="pin_code" name="pincode"
                                           placeholder="Enter pincode" readonly>
                                    <?php /*
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Address Line2
                                        </label>
                                        <div class="col-lg-8">
                                            <textarea type="text"
                                                   class="form-control @error('address_line2') is-invalid @enderror"
                                                   id="val-username" name="address_line2"
                                                      placeholder="Enter Address Line2">{{$data['listing']->address_line2}}</textarea>
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
                                                   value="{{ $data['listing']->country }}" id="val-username" name="country"
                                                   placeholder="Enter Country" required>
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
                                                   value="{{ $data['listing']->state }}" id="val-username" name="state"
                                                   placeholder="Enter State" required>
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
                                                   value="{{ $data['listing']->city }}" id="val-username" name="city"
                                                   placeholder="Enter City" required>
                                            @error('city')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <input type="hidden"
                                           class="form-control @error('lat') is-invalid @enderror"
                                           value="{{ $data['listing']->latitude }}" id="val-username" name="lat">
                                    <input type="hidden"
                                           class="form-control @error('long') is-invalid @enderror"
                                           value="{{ $data['listing']->longitude }}" id="val-username" name="long">

                                    {{--
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Lat
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('lat') is-invalid @enderror"
                                                   value="{{ $data['listing']->latitude }}" id="val-username" name="lat"
                                                   placeholder="Enter lat" required>
                                            @error('lat')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Long
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('long') is-invalid @enderror"
                                                   value="{{ $data['listing']->longitude }}" id="val-username" name="long"
                                                   placeholder="Enter long" required>
                                            @error('long')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
--}}
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Website
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text"
                                                   class="form-control @error('website') is-invalid @enderror"
                                                   value="{{ $data['listing']->website }}" id="val-username" name="website"
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
                                                   @if(!empty($data['listing']->image))
                                                   <img src="{{asset('storage/'. $data['listing']->image)}}" width="100px" height="100px">
                                                    @endif
                                            @error('image')
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
                                       <!--  <div class="col-lg-2 ml-auto">
                                            <a class="btn btn btn-success" href="{{ route('listListing',$data['listing']->id) }}">Cancel</a>
                                        </div> -->
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

