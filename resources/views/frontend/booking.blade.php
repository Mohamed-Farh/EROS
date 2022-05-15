@extends('layouts.frontend_app')

@section('title', 'حجز موعد')

@section('content')

<style>
    .form-sec-1 .input-booking {
        width: 100%;
    }
    .addForm {
        font-size: 0.55rem;
    }
</style>
    <!-- start booking  -->
    <div class="booking-sec py-4 text-center">
        <div class="container">
            <h5>حجز موعد</h5><!-- Start PageTile -->
            @php
                $pageTitles = \App\Models\PageTitle::whereStatus(1)
                    ->wherePage('حجز موعد')
                    ->get();
            @endphp
            @if ($pageTitles->count() > 0)
                @foreach ($pageTitles as $pageTitle)
                    <p class="text-center" style="color:white; text-align: justify !important;">{{ $pageTitle->title }}
                    </p>
                @endforeach
            @endif
            <!-- End PageTile -->
            <div class="form-sec-1">
                <form action="{{ route('frontend.booking-booking') }}" method="post">
                    @csrf
                    <input type="text" name="name" value="{{ Auth::guest() ? old('name') : auth()->user()->full_name }}" class="input-booking" required
                        placeholder="الاسم">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <input type="text" name="mobile" value="{{ Auth::guest() ? old('mobile') : auth()->user()->mobile }}" class="input-booking" required
                        placeholder="رقم الهاتف">
                    @error('mobile')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <input type="email" name="email" value="{{ Auth::guest() ? old('email') : auth()->user()->email }}" class="input-booking" required
                        placeholder="البريد الالكتروني">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="row">
                        <div class="col-6">
                            <select name="category_id" class="input-booking addForm" style="font-size: 0.6rem;" onchange="console.log($(this).val())">
                                <option value="" selected disabled>{{__('أنواع الخدمات') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6">
                            <select name="product_id" class="input-booking addForm" style="font-size: 0.6rem;">
                                <option value="" selected disabled>{{__('الخدمات') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <input type="date" name="day" class="input-date addForm" style="    width: 100%;" />
                            @error('day')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <input type="time" name="start" class="input-date addForm" style="    width: 100%;" />
                            @error('start')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    @guest
                        <div class="row">
                            <div class="col-4">
                                <select name="country_id" placeholder="الدولة" id="contactUs_country_id"
                                    class="input-booking addForm" style="font-size: 0.55rem;">
                                    <option value="">الدولة</option>
                                    @forelse (\App\Models\Country::get(['id', 'name']) as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country_id') == $country->id ? 'selected' : null }}>
                                            {{ $country->name }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                                @error('country_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-4">
                                <select name="state_id" id="contactUs_state_id" class="input-booking addForm"
                                    style="font-size: 0.55rem;">
                                </select>
                                @error('state_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-4">
                                <select name="city_id" id="contactUs_city_id" class="input-booking addForm"
                                    style="font-size: 0.55rem;">
                                </select>
                                @error('city_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endguest

                    @auth
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                        @php $customer_address = \App\Models\UserAddress::whereUserId(auth()->user()->id)->first(); @endphp
                        <div class="row">
                            <div class="col-4">
                                <select name="country_id" placeholder="الدولة" id="auth_country_id"
                                    class="input-booking addForm" style="font-size: 0.55rem;">
                                    <option value="">الدولة</option>
                                    @forelse (\App\Models\Country::get(['id', 'name']) as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country_id', $customer_address->country_id) == $country->id ? 'selected' : null }}>
                                            {{ $country->name }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                                @error('country_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-4">
                                <select name="state_id" id="auth_state_id" class="input-booking addForm"
                                    style="font-size: 0.55rem;">
                                </select>
                                @error('state_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-4">
                                <select name="city_id" id="auth_city_id" class="input-booking addForm"
                                    style="font-size: 0.55rem;">
                                </select>
                                @error('city_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endauth


                    <input type="text" name="subject" value="{{ old('subject') }}" class="input-booking"
                        placeholder="عنوان الرسالة">
                    @error('subject')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <textarea name="message" rows="5" class="input-booking" style="height:unset!important" placeholder="ما هي مقترحاتكم أو ما هو استفساركم ؟"
                        required>{!! old('message') !!}</textarea>
                    @error('message')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="text-center">
                        <button type="submit" name="submit">ارسال</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end booking -->


@endsection
@section('script')
    @guest
        <script>
            $(function() {
                contactUsStates();
                contactUsCities();

                $("#contactUs_country_id").change(function() {
                    contactUsStates();
                    contactUsCities();
                    return false;
                });

                $("#contactUs_state_id").change(function() {
                    contactUsCities();
                    return false;
                });

                function contactUsStates() {
                    console.log('A');
                    let countryIdVal = $('#contactUs_country_id').val() != null ? $('#contactUs_country_id').val() :
                        '{{ old('country_id') }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                    $.get("{{ route('frontend.frontState') }}", {
                        country_id: countryIdVal
                    }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                        $('option', $('#contactUs_state_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                        $('#contactUs_state_id').append($('<option></option>').val('').html('المحافظة'));
                        $.each(data, function(val, text) {
                            let selectedVal = text.id == '{{ old('state_id') }}' ? "selected" : "";
                            $("#contactUs_state_id").append($('<option ' + selectedVal + '></option>')
                                .val(
                                    text
                                    .id).html(text.name));
                        });
                    }, "json")

                }

                function contactUsCities() {
                    let stateIdVal = $('#contactUs_state_id').val() != null ? $('#contactUs_state_id').val() :
                        '{{ old('state_id') }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                    $.get("{{ route('frontend.frontCity') }}", {
                        state_id: stateIdVal
                    }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                        $('option', $('#contactUs_city_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                        $('#contactUs_city_id').append($('<option></option>').val('').html('المدينة'));
                        $.each(data, function(val, text) {
                            let selectedVal = text.id == '{{ old('city_id') }}' ? "selected" : "";
                            $("#contactUs_city_id").append($('<option ' + selectedVal + '></option>')
                                .val(text.id).html(text.name));
                        });
                    }, "json")
                }

            });
        </script>
    @endguest

    @auth
        <script>
            $(function() {
                populateStates();
                populateCities();

                $("#auth_country_id").change(function() {
                    populateStates();
                    populateCities();
                    return false;
                });

                $("#auth_state_id").change(function() {
                    populateCities();
                    return false;
                });

                function populateStates() {
                    let countryIdVal = $('#auth_country_id').val() != null ? $('#auth_country_id').val() :
                        '{{ old('country_id', $customer_address->country_id) }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                    $.get("{{ route('admin.backend.get_state') }}", {
                        country_id: countryIdVal
                    }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                        $('option', $('#auth_state_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                        $('#auth_state_id').append($('<option></option>').val('').html('---'));
                        $.each(data, function(val, text) {
                            let selectedVal = text.id ==
                                '{{ old('state_id', $customer_address->state_id) }}' ? "selected" : "";
                            $("#auth_state_id").append($('<option ' + selectedVal + '></option>').val(text
                                .id).html(text.name));
                        });
                    }, "json")

                }

                function populateCities() {
                    let stateIdVal = $('#auth_state_id').val() != null ? $('#auth_state_id').val() :
                        '{{ old('state_id', $customer_address->state_id) }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                    $.get("{{ route('admin.backend.get_city') }}", {
                        state_id: stateIdVal
                    }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                        $('option', $('#auth_city_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                        $('#auth_city_id').append($('<option></option>').val('').html('---'));
                        $.each(data, function(val, text) {
                            let selectedVal = text.id ==
                                '{{ old('city_id', $customer_address->city_id) }}' ? "selected" : "";
                            $("#auth_city_id").append($('<option ' + selectedVal + '></option>').val(text.id)
                                .html(text.name));
                        });
                    }, "json")
                }

            });
        </script>

    @endauth

    <script>
        $(document).ready(function() {
            $('select[name="category_id"]').on('change', function() {
                var category_id = $(this).val();
                if (category_id) {
                    $.ajax({
                        url: "{{ URL::to('getProducts') }}/" + category_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="product_id"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="product_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX Load Did Not Work');
                }
            });
        });
    </script>
@endsection
