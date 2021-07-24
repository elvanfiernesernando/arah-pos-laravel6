@extends('layouts.auth')

@section('title')
<title>ARAH POS - Register</title>
@endsection

@section('content')
<div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">

    <div class="row flex-grow">
        <div class="col-lg-6 d-flex align-items-center justify-content-center">

            <div class="auth-form-transparent text-left p-3">

                <div class="brand-logo">
                    <img src="{{ asset('images/logoarah/logo-arah-pos.svg') }}" alt="logo">
                </div>

                <h4>New here?</h4>
                <h6 class="font-weight-light">Join us today! It takes only few steps</h6>
                <!-- <h4>Almost Done!</h4> -->
                <!-- <h6 class="font-weight-light">Just a few more steps and you'll get in our service</h6> -->
                <form class="pt-3" method="POST" action="{{ route('register') }}">
                    @csrf
                    @if (session('error'))
                    @alert(['type' => 'danger'])
                    {{ session('error') }}
                    @endalert
                    @endif

                    <div class="tab">
                        <div class="form-group has-feedback">
                            <label>Full Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend bg-transparent">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="ti-user text-primary"></i>
                                    </span>
                                </div>
                                <input type="text" id="name" name="name" class="form-control form-control-lg border-left-0" placeholder="Full Name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            </div>
                            <p class="text-danger">{{ $errors->first('name') }}</p>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Email</label>
                            <div class="input-group">
                                <div class="input-group-prepend bg-transparent">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="ti-email text-primary"></i>
                                    </span>
                                </div>
                                <input type="email" id="email" name="email" class="form-control form-control-lg border-left-0" placeholder="Email" value="{{ old('email') }}" required autocomplete="email">
                            </div>
                            <p class="text-danger">{{ $errors->first('email') }}</p>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend bg-transparent">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="ti-lock text-primary"></i>
                                    </span>
                                </div>
                                <input type="password" id="password" name="password" class="form-control form-control-lg border-left-0" placeholder="Password" required autocomplete="new-password">
                            </div>
                            <p class="text-danger">{{ $errors->first('password') }}</p>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Confirm Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend bg-transparent">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="ti-lock text-primary"></i>
                                    </span>
                                </div>
                                <input type="password" id="password-confirm" name="password_confirmation" class="form-control form-control-lg border-left-0" placeholder="Confirm Password">
                            </div>
                        </div>
                    </div>
                    <!-- <div class="tab d-none">
                        <div class="form-group">
                            <label for="">Upload your ID Card / KTP</label>
                            <input type="file" name="idcard_photo" class="form-control">
                            <p class="text-danger">{{ $errors->first('idcard_photo') }}</p>
                        </div>
                        <div class="form-group has-feedback">
                            <label>ID Card / KTP Number</label>
                            <div class="input-group">
                                <div class="input-group-prepend bg-transparent">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="ti-user text-primary"></i>
                                    </span>
                                </div>
                                <input type="text" id="idcard_no" name="idcard_no" class="form-control form-control-lg border-left-0" placeholder="ID Card / KTP Number" value="{{ old('idcard_no') }}" required autocomplete="idcard_no" autofocus>
                            </div>
                            <p class="text-danger">{{ $errors->first('idcard_no') }}</p>
                        </div>
                    </div> -->
                    <div class="mb-4">
                        <div class="form-check">
                            <label class="form-check-label text-muted">
                                <input type="checkbox" class="form-check-input" required>
                                I agree to all Terms &amp; Conditions
                                <i class="input-helper"></i></label>
                        </div>
                    </div>
                    <div class="mt-3">
                        <!-- <button type="submit" class="btn btn-block btn-secondary btn-lg font-weight-medium auth-form-btn">PREVIOUS</button> -->
                        <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN UP</button>
                    </div>
                    <div class="text-center mt-4 font-weight-light">
                        Already have an account? <a href="{{ route('login') }}" class="text-primary">Login</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-6 register-half-bg d-flex flex-row">
            <!-- <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright © 2021 All rights reserved.</p> -->
        </div>
    </div>
</div>
<!-- content-wrapper ends -->

























<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection