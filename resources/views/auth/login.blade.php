@extends('layouts.frontend_app')

@section('title', 'تسجيل دخول')

@section('content')


    <div class="first-bawabtouk-sec">
    </div>
    <div class="row log-in-row py-4 mb-4">
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3"></div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-center">

            <h1 class="h2 text-uppercase mb-4">تسجيل دخول</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="row mt-4 text-center py-4 ">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">
                        <input id="email" type="text" class="login-input pr-3" @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" placeholder="البريد الالكتروني" required
                            autocomplete="email" autofocus aria-describedby="emailHelp">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">
                        <input id="password" type="password"
                            class="login-input pr-3 @error('password') is-invalid @enderror" name="password" required
                            autocomplete="current-password" placeholder="كلمة المرور">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">
                        <button type="submit" class="login-button">
                            {{ __('تسجيل الدخول') }}
                        </button>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                        @if (Route::has('password.request'))
                            <p class="forget-pass">
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('نسيت كلمة المرور؟') }}
                                </a>
                            </p>
                        @endif
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                        <p class="dont-have-account">ليس لديك حساب؟<a href="{{ route('register') }}">انشاء حساب جديد</a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
    </div>


@endsection
