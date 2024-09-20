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
                        <form class="form-valide" action="{{route('storeBalanceToBWallet')}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xl-10">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Branch
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-8">
                                                <select class="dropdown-groups disabling-options branch @error('branch') is-invalid @enderror"
                                                        name="branch" required>
                                                    <option value="">Select Branch</option>
                                                    @if($data['branches'])
                                                        @foreach($data['branches'] as $branch)
                                                            <option value="{{$branch->id}}">{{$branch->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('branch')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Amount
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="number"
                                                   class="form-control @error('amount') is-invalid @enderror"
                                                   value="{{ old('amount') }}" id="val-amount" name="amount"
                                                   placeholder="Enter Amount">
                                            @error('amount')
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
                                            <a class="btn btn btn-success" href="{{ route('getWallet') }}">Cancel</a>
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

