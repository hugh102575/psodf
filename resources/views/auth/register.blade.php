@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="text-center mb-3">
                        <span class="my_nav_text"><i class="fas fa-user "></i></span>
                        </div>
                        <div class="form-group row mb-5">
                            <label for="name" class="col-md-4 col-form-label text-md-right">個人姓名<span class="text-danger"> *</span></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        {{--<div class="form-group row mb-5">
                            <label for="email" class="col-md-4 col-form-label text-md-right">個人{{ __('E-Mail Address') }}<span class="text-danger"> *</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="請輸入有效的信箱，如果忘記密碼時會用到">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>--}}
                        <hr class="">


                        <div class="text-center mb-3">
                        <span class="my_nav_text"><i class="fas fa-school "></i></span></div>

                        <div class="form-group row">
                            <label for="school" class="col-md-4 col-form-label text-md-right">安親班名稱<span class="text-danger"> *</span></label>

                            <div class="col-md-6">
                                <input id="school" type="text" class="form-control" name="school" value="{{ old('school') }}" required autocomplete="school">

                                @error('school')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="admin" class="col-md-4 col-form-label text-md-right">安親班聯絡人<span class="text-danger"> *</span></label>

                            <div class="col-md-6">
                                <input id="admin" type="text" class="form-control @error('admin') is-invalid @enderror" name="admin" value="{{ old('admin') }}" required autocomplete="admin" autofocus>

                                @error('admin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">安親班電話<span class="text-danger"> *</span></label>

                            <div class="col-md-6">
                                <input id="phone" class="form-control" type="tel" name="phone" required="required" >
                            </div>
                        </div>

                        <div class="form-group row mb-5">
                            <label for="address" class="col-md-4 col-form-label text-md-right">安親班地址<span class="text-danger"> *</span></label>

                            <div class="col-md-6">
                                <input id="address" class="form-control" type="text" name="address" required="required" >
                            </div>
                        </div>

                        <hr>

                        <div class="text-center mb-3">
                        <span class="my_nav_text"><i class="fas fa-key "></i></span></div>
                        <div class="form-group row">
                            <label for="account" class="col-md-4 col-form-label text-md-right">登入帳號<span class="text-danger"> *</span></label>

                            <div class="col-md-6">
                                <input id="account" type="text" class="form-control @error('account') is-invalid @enderror" name="account" value="{{ old('account') }}" required autocomplete="account" placeholder="將作為登入帳號">

                                @error('account')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">登入{{ __('Password') }}<span class="text-danger"> *</span></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="將作為登入密碼">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-5">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}<span class="text-danger"> *</span></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <hr>
                        <div class="form-group row mb-0">
                            <!--<div class="col-md-6 offset-md-4">-->
                            <div class="col-md-8 mx-auto">
                                <button type="submit" class="form-control btn btn-primary my_nav_color">
                                    {{ __('Register') }}
                                </button>
                            </div>
                            <!--</div>-->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


