@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                {{--<div class="card-header">{{ __('Reset Password') }}</div>--}}
                <div class="card-header">查詢帳號</div>

                <form method="POST" action="{{ route('costom_reset_pwd') }}">
                @csrf
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    
                        <div class="form-group row mb-3">
                            <label for="PID" class="col-md-4 col-form-label text-md-right">平台序號</label>
                            <div class="col-md-6">
                            <input id="PID" type="text" placeholder="請輸入平台序號" class="form-control @error('PID') is-invalid @enderror   " name="PID" value="{{ old('PID') }}" required autocomplete="PID" autofocus>

                            @error('PID')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>


                        <div class="form-group row mb-3">
                            <label for="account" class="col-md-4 col-form-label text-md-right">登入帳號</label>
                            <div class="col-md-6">
                            <input id="account" type="text" placeholder="請輸入登入帳號" class="form-control @error('account') is-invalid @enderror   " name="account" value="{{ old('account') }}" required autocomplete="account" autofocus>

                            @error('account')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>



                        {{--<div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>--}}

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary my_nav_color">
                                    {{--{{ __('Send Password Reset Link') }}--}}
                                    下一步
                                </button>
                            </div>
                        </div>
                </div>
                </form>

                {{--<div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
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

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary my_nav_color">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>--}}
            </div>
        </div>
    </div>
</div>
@endsection
