@extends('layouts.frontend_app')

@section('title', 'تعديل موقعي')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="contain-sec py-4">
        <div class="container-jobs py-4 ">
            <div class="upload-image1">
                <div class="upload-profile-pic py-4">
                    <img class="profile-pic" src="{{ asset(auth()->user()->user_image) }}" />
                    <div class="p-image">
                    </div>
                </div>
            </div>
            <h4 class="text-center">{{ auth()->user()->full_name }}</h4>
            <form method="POST" action="{{ route('frontend.updateLocation', ['user_id' => auth()->user()->id]) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="personal-info py-2 text-center mt-4">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            <select name="country_id" class="user-info pr-3 @error('country_id') is-invalid @enderror"
                                id="country_id">
                                <option value="">الدولة</option>
                                @forelse (\App\Models\Country::whereStatus(true)->get(['id', 'name']) as $country)
                                    @if ($userAddress && $userAddress->country_id != '')
                                        <option value="{{ $country->id }}"
                                            {{ old('country_id', $userAddress->country_id) == $country->id ? 'selected' : null }}>
                                            {{ $country->name }}
                                        </option>
                                    @else
                                        <option value="{{ $country->id }}"
                                            {{ old('country_id') == $country->id ? 'selected' : null }}>
                                            {{ $country->name }}
                                        </option>
                                    @endif
                                @empty
                                @endforelse
                            </select>
                            @error('country_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            <select name="state_id" id="location_state_id"
                                class="user-info pr-3 @error('state_id') is-invalid @enderror">
                            </select>
                            @error('state_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            <select name="city_id" id="location_city_id"
                                class="user-info pr-3 @error('city_id') is-invalid @enderror">
                            </select>
                            @error('city_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            @if ($userAddress && $userAddress->country_id != '')
                                <textarea name="address" placeholder="العنوان بالتفصيل" rows="3" style="height: auto;"
                                    class="user-info pr-3 @error('address') is-invalid @enderror">{{ old('address', $userAddress->address) }}</textarea>
                            @else
                                <textarea name="address" placeholder="العنوان بالتفصيل" rows="3" style="height: auto;"
                                    class="user-info pr-3 @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                            @endif
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            @if ($userAddress && $userAddress->country_id != '')
                                <input type="text" name="zip_code" value="{{ old('zip_code', $userAddress->zip_code) }}"
                                    placeholder="ZIP Code" class="user-info pr-3 @error('zip_code') is-invalid @enderror" />
                            @else
                                <input type="text" name="zip_code" value="{{ old('zip_code') }}" placeholder="ZIP Code"
                                    class="user-info pr-3 @error('zip_code') is-invalid @enderror" />
                            @endif
                            @error('zip_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                            @if ($userAddress && $userAddress->country_id != '')
                                <input type="text" name="po_box" value="{{ old('po_box', $userAddress->po_box) }}"
                                    placeholder="POST Code" class="user-info pr-3 @error('po_box') is-invalid @enderror" />
                            @else
                                <input type="text" name="po_box" value="{{ old('po_box') }}" placeholder="POST Code"
                                    class="user-info pr-3 @error('po_box') is-invalid @enderror" />
                            @endif
                            @error('po_box')
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

    <script>
        $(function() {
            locationStates();
            locationCities();

            $("#country_id").change(function() {
                locationStates();
                locationCities();
                return false;
            });

            $("#location_state_id").change(function() {
                locationCities();
                return false;
            });

            function locationStates() {
                let countryIdVal = $('#country_id').val() != null ? $('#country_id').val() : '{{ old('country_id', $userAddress->country_id) }}';
                $.get("{{ route('frontend.frontGetState') }}", {
                    country_id: countryIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#location_state_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#location_state_id').append($('<option></option>').val('').html('المحافظة'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id ==
                            '{{ old('state_id', $userAddress->state_id) }}' ? "selected" : "";
                        $("#location_state_id").append($('<option ' + selectedVal + '></option>')
                            .val(text
                                .id).html(text.name));
                    });
                }, "json")

            }

            function locationCities() {
                let stateIdVal = $('#location_state_id').val() != null ? $('#location_state_id').val() :
                    '{{ old('state_id', $userAddress->state_id) }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('frontend.frontGetCity') }}", {
                    state_id: stateIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#location_city_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#location_city_id').append($('<option></option>').val('').html('---'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id ==
                            '{{ old('city_id', $userAddress->city_id) }}' ? "selected" : "";
                        $("#location_city_id").append($('<option ' + selectedVal + '></option>')
                            .val(text.id)
                            .html(text.name));
                    });
                }, "json")
            }

        });
    </script>
































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
