@extends('layouts.frontend_app')

@section('title', 'تعديل بيانات الحساب الشخصي')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>




    <div class="contain-sec py-4">
        <div class="container-jobs py-4 ">
            <form method="POST" action="{{ route('frontend.updateProfile', ['user_id' => auth()->user()->id]) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="upload-image1">
                    <div class="upload-profile-pic py-4">
                        <img class="profile-pic" src="{{ asset(auth()->user()->user_image) }}" />
                        <div class="p-image">
                            <i class="fa fa-camera upload-button"></i>
                            <input class="file-upload" type="file" name="user_image" accept="image/*" />
                        </div>
                    </div>
                </div>

                <div class="personal-info py-2 text-center">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            <input type="text" name="first_name" value="{{ auth()->user()->first_name }}"
                                placeholder="الاسم الاول"
                                class="user-info pr-3 @error('first_name') is-invalid @enderror" />
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            <input type="text" name="last_name" value="{{ auth()->user()->last_name }}"
                                placeholder="الاسم الاخير"
                                class="user-info pr-3 @error('last_name') is-invalid @enderror" />
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            <input type="text" name="username" value="{{ auth()->user()->username }}"
                                placeholder="اسم المستخدم" class="user-info pr-3 @error('username') is-invalid @enderror" />
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            <input type="text" name="mobile" value="{{ auth()->user()->mobile }}"
                                placeholder="رقم الهاتف" class="user-info pr-3 @error('mobile') is-invalid @enderror" />
                            @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            <input type="email" name="email" value="{{ auth()->user()->email }}"
                                placeholder="البريد الالكتروني"
                                class="user-info pr-3 @error('email') is-invalid @enderror" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            <input type="password" name="password" placeholder="كلمة المرور"
                                class="user-info pr-3 @error('password') is-invalid @enderror" />
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            <input id="password-confirm" name="password_confirmation" type="password"
                                placeholder="تأكيد كلمة المرور"
                                class="user-info pr-3 @error('password_confirmation') is-invalid @enderror" />
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="save-btn">حفظ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- start upload image -->
    <script>
        $(document).ready(function() {
            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('.profile-pic').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }


            $(".file-upload").on('change', function() {
                readURL(this);
            });

            $(".upload-button").on('click', function() {
                $(".file-upload").click();
            });
        });
    </script>
    <!-- end upload image -->
































    {{-- <div class="contain-sec py-4">
        <div class="container-jobs py-4 ">
            <div class="upload-image1">
                <form>
                    <div class="upload-profile-pic py-4">
                        <img class="profile-pic" src="{{ asset(auth()->user()->user_image) }}" />
                        <div class="p-image">
                            <i class="fa fa-camera upload-button"></i>
                            <input class="file-upload" type="file" accept="image/*" />
                        </div>
                    </div>
                </form>
            </div>

            <div class="personal-info py-2 text-center">
                <form method="POST" action="{{ route('frontend.updateProfile', ['user_id' => auth()->user()->id]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            <input type="text" name="first_name" value="{{ auth()->user()->first_name }}"
                                placeholder="الاسم الاول"
                                class="user-info pr-3 @error('first_name') is-invalid @enderror" />
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            <input type="text" name="last_name" value="{{ auth()->user()->last_name }}"
                                placeholder="الاسم الاخير"
                                class="user-info pr-3 @error('last_name') is-invalid @enderror" />
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            <input type="text" name="username" name="first_name" value="{{ auth()->user()->username }}"
                                placeholder="اسم المستخدم" class="user-info pr-3 @error('username') is-invalid @enderror" />
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            <input type="email" name="email" value="{{ auth()->user()->email }}"
                                placeholder="البريد الالكتروني"
                                class="user-info pr-3 @error('email') is-invalid @enderror" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            <input type="password" name="password" placeholder="كلمة المرور"
                                class="user-info pr-3 @error('password') is-invalid @enderror" />
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            <input id="password-confirm" name="password_confirmation" type="password"
                                placeholder="تأكيد كلمة المرور"
                                class="user-info pr-3 @error('password_confirmation') is-invalid @enderror" />
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="save-btn">حفظ</button>
                    </div>
            </div>
        </div>
    </div>

    <!-- start upload image -->
    <script>
        $(document).ready(function() {
            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('.profile-pic').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }


            $(".file-upload").on('change', function() {
                readURL(this);
            });

            $(".upload-button").on('click', function() {
                $(".file-upload").click();
            });
        });
    </script>
    <!-- end upload image --> --}}
@endsection
