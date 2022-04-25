@extends('layouts.frontend_app')

@section('title', 'Register')

@section('content')


    {{-- <div class="container">
        <div class="first-bawabtouk-sec">

        </div>
        <div class="row log-in-row py-4 mb-4">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3"></div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

                <div class="row mt-4 text-center py-4 ">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">
                        <input type="text" placeholder="الاسم" class="login-input" />
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">
                        <input type="number" placeholder="رقم الموبايل" class="login-input" />
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">
                        <input type="email" placeholder="البريد الالكتروني" class="login-input" />
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">
                        <input type="password" placeholder="كلمة المرور" class="login-input" />
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">
                        <button class="login-button"><a href="index.html">انشاء حساب</a></button>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                        <p class="dont-have-account">بمجرد الدخول فانك توافق على<a href="#">سياسة الخصوصية& شروط
                                والاحكام</a></p>

                    </div>

                </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3"></div>

        </div>
    </div>

    ################################################ --}}
    <div class="first-bawabtouk-sec">
    </div>
    <div class="row log-in-row py-4 mb-4">
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3"></div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <h3 class="h5 text-uppercase text-center">انشاء حساب</h3>
            <form method="POST" action="{{ route('register') }}"  enctype="multipart/form-data">
                @csrf
                <div class="row mt-4 text-center py-4 ">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">
                        <input id="first_name" type="text"
                            class="login-input pr-3 @error('first_name') is-invalid @enderror"
                            name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name"
                            autofocus placeholder="الاسم الاول">
                        @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">
                        <input id="last_name" type="text"
                            class="login-input pr-3 @error('last_name') is-invalid @enderror"
                            name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name"
                            autofocus placeholder="الاسم الاخير">
                        @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">
                        <input id="username" type="text"
                            class="login-input pr-3 @error('username') is-invalid @enderror" name="username"
                            required placeholder="اسم المستخدم">
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">
                        <input id="mobile" type="text"
                            class="login-input pr-3 @error('mobile') is-invalid @enderror" name="mobile"
                            value="{{ old('mobile') }}" required autocomplete="mobile" autofocus
                            placeholder="رقم الموبايل">
                        @error('mobile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">
                        <input id="email" type="email"
                            class="login-input pr-3 @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" placeholder="البريد الالكتروني">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">
                        <input id="password" type="password"
                            class="login-input pr-3 @error('password') is-invalid @enderror" name="password"
                            required autocomplete="new-password" placeholder="كلمة المرور">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">
                        <input id="password-confirm" type="password" class="login-input pr-3"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="تأكيد كلمة المرور">
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">
                        <input id="user_image" type="file"
                            class="login-input pr-3 pt-1 @error('user_image') is-invalid @enderror"
                            name="user_image" required>
                        @error('user_image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">
                        <button type="submit" class="login-button">
                            {{ __('انشاء حساب') }}
                        </button>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                        <p class="dont-have-account"> بمجرد الدخول فانك توافق على<a > سياسة الخصوصية& شروط
                                والاحكام</a></p>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3"></div>
    </div>

@endsection
