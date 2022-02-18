@extends('layouts.app')

@section('app_css')
<style>
.login,
.image {
    min-height: 100vh
}

.bg-image {
    background-image: url("{{ asset('/img/dexway-classroom-companion-ingles-uk.jpg') }}");
    background-size: cover;
    background-position: center center
}
</style>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row no-gutter">
        <div class="col-md-6 d-none d-md-flex bg-image"></div>
        <div class="col-md-6 bg-light">
            <div class="login d-flex align-items-center py-5">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-7 col-xl-6 mx-auto">
                        @if(session()->has('login_success_msg'))
                            <div class="alert alert-success mb-5" name="alert_msg">
                                {{ session()->get('login_success_msg') }}
                            </div>
                        @endif
                        @if(session()->has('login_error_msg'))
                            <div class="alert alert-danger mb-5" name="alert_msg">
                                {{ session()->get('login_error_msg') }}
                            </div>
                        @endif
                            <div class="mb-5">
                            <h3 class="text-primary">{{ config('app.name', 'Laravel') }}</h3>
                            </div>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                {{--<div class="form-group mb-3">

                                    <input id="email" type="email" placeholder="{{ __('E-Mail Address') }}" class="form-control @error('email') is-invalid @enderror  rounded-pill border-0 shadow-sm px-4" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>--}}

                                <div class="form-group mb-3">

                                <input id="PID" type="text" placeholder="平台序號" class="form-control @error('PID') is-invalid @enderror  rounded-pill border-0 shadow-sm px-4" name="PID" value="{{ old('PID') }}" required autocomplete="PID" autofocus>

                                @error('PID')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>


                                <div class="form-group mb-3">

                                    <input id="account" type="text" placeholder="帳號" class="form-control @error('account') is-invalid @enderror  rounded-pill border-0 shadow-sm px-4" name="account" value="{{ old('account') }}" required autocomplete="account" autofocus>

                                    @error('account')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">

                                    <input id="password" type="password" placeholder="{{ __('Password') }}" class="form-control @error('password') is-invalid @enderror rounded-pill border-0 shadow-sm px-4" name="password" required autocomplete="current-password"><br>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>



                                <div class="custom-control custom-checkbox mb-3">

                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>

                                </div>



                                 <button type="submit" class="btn btn-primary my_nav_color btn-block text-uppercase mb-5 rounded-pill shadow-sm">
                                    {{ __('Login') }}
                                </button>

                                    <div class="text-center d-flex justify-content-between mt-4">
                                        {{--<p><a href="{{ route('register') }}" class="font-italic text-muted"> <u><small>{{ __('Register') }}</small></u></a></p>--}}
                                        <p><a href="{{ route('register') }}" class="font-italic text-muted"> <u><small>立即註冊！</small></u></a></p>
                                    </div>
                                   @if (Route::has('password.request'))
                                    <div class="form-group mb-3">
                                        <a class="font-italic text-muted" href="{{ route('password.request') }}">
                                            <u><small>{{ __('Forgot Your Password?') }}</small></u>
                                        </a>
                                    </div>
                                    @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary my_nav_color">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>--}}

@endsection

