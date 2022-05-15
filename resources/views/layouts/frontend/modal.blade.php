<style>
    .modal-body input {
        width: 100%;
    }
</style>

<!-- start modal -->
<div class="modal fade" id="myModalSignIn" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content text-center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4 class="modal-title">تسجيل الدخول</h4>
                <!-- Start PageTile -->
                @php
                    $pageTitles = \App\Models\PageTitle::whereStatus(1)
                        ->wherePage('تسجيل الدخول')
                        ->get();
                @endphp
                @if ($pageTitles->count() > 0)
                    @foreach ($pageTitles as $pageTitle)
                        <p>{{ $pageTitle->title }}</p>
                    @endforeach
                @endif
                <!-- End PageTile -->


                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="row text-center">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
                            <input id="email" type="text" class="login-input pr-3" @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" placeholder="البريد الالكتروني" required
                                autocomplete="email" autofocus aria-describedby="emailHelp">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
                            <input id="password" type="password"
                                class="login-input pr-3 @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password" placeholder="كلمة المرور">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
                            <button type="submit" class="login-button">
                                {{ __('تسجيل الدخول') }}
                            </button>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            @if (Route::has('password.request'))
                                <p class="forget-pass">
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('نسيت كلمة المرور؟') }}
                                    </a>
                                </p>
                            @endif
                        </div>

                        {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                            <p class="dont-have-account">ليس لديك حساب؟<a href="#" class="nav-link" class="btn btn-info btn-lg" data-toggle="modal"
                                data-target="#myModalSignUp">انشاء حساب جديد</a>
                            </p>
                        </div> --}}
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<!-- end modal -->


<!-- start modal -->
<div class="modal fade" id="myModalSignUp" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content text-center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4 class="modal-title">انشاء حساب</h4>
                <!-- Start PageTile -->
                @php
                    $pageTitles = \App\Models\PageTitle::whereStatus(1)
                        ->wherePage('انشاء حساب')
                        ->get();
                @endphp
                @if ($pageTitles->count() > 0)
                    @foreach ($pageTitles as $pageTitle)
                        <p>{{ $pageTitle->title }}</p>
                    @endforeach
                @endif
                <!-- End PageTile -->

                <form method="POST" action="{{ route('register') }}"  enctype="multipart/form-data">
                    @csrf
                    <div class="row mt-2 text-center py-4 ">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1">
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


                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1">
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

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1">
                            <input id="username" type="text"
                                class="login-input pr-3 @error('username') is-invalid @enderror" name="username"
                                required placeholder="اسم المستخدم">
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1">
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

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1">
                            <input id="email" type="email"
                                class="login-input pr-3 @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" placeholder="البريد الالكتروني">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1">
                            <input id="password" type="password"
                                class="login-input pr-3 @error('password') is-invalid @enderror" name="password"
                                required autocomplete="new-password" placeholder="كلمة المرور">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1">
                            <input id="password-confirm" type="password" class="login-input pr-3"
                                name="password_confirmation" required autocomplete="new-password"
                                placeholder="تأكيد كلمة المرور">
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1">
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
        </div>

    </div>
</div>
<!-- end modal -->
