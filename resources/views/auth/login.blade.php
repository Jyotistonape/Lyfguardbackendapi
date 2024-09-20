@extends('layouts.auth')

@section('content')
    <div class="auth-form">
        <h4 class="text-center mb-4">Sign in your account</h4>
        <form  method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label class="mb-1"><strong>Email</strong></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email ID" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="mb-1"><strong>Password</strong></label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password" required autocomplete="current-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="form-row d-flex justify-content-between mt-4 mb-2">
                <div class="form-group">
                    <div class="custom-control custom-checkbox ml-1">
                        <input type="checkbox" class="custom-control-input" id="basic_checkbox_1" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="basic_checkbox_1">Remember me</label>
                    </div>
                </div>
                <div class="form-group">
                    {{--<a href="page-forgot-password.html">Forgot Password?</a>--}}
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
            </div>
        </form>
        <div class="new-account mt-3">
            {{--<p>Don't have an account? <a class="text-primary" href="./page-register.html">Sign up</a></p>--}}
        </div>
    </div>
@endsection
