@extends('layouts.frontend_app')

@section('title', 'الرئيسية')

@section('content')

    <style>
        .modal-header .close {
            padding: 1rem 1rem;
            margin: 0rem -1rem -1rem auto;
            width: 13%;
        }

        .addForm {
            padding: unset!important;
            border: 1px solid #ebebeb;
            border-radius: 8px;
            box-shadow: 0px 0px 10px #dddddd;
            font-size: 0.6rem!important;
        }
    </style>



    <!-- start slider -->
    <div class="slider">
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach ($sliders as $slider)
                    <li data-target="#carouselExampleCaptions" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach ($sliders as $slider)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <img src="{{ asset($slider->image) }}" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>{{ $slider->title }}</h5>
                            <p>{{ $slider->text }}</p>

                            <!-- Button -->
                            @if ( $slider->button_text != '' )
                                @if ( $slider->button_link != '' )
                                    <a href="{{ $slider->button_link }}" target="_blank" class="btn-lg">
                                        <button class="btn btn-info btn-lg" type="button">{{ $slider->button_text }}</button>
                                    </a>
                                @else
                                    <button class="btn btn-info btn-lg" type="button">{{ $slider->button_text }}</button>
                                @endif
                            @endif

                            <!-- video -->
                            @if ( $slider->video != '' )
                                <button onclick="window.location.href='#'" class="btn btn-info btn-lg" data-toggle="modal"
                                    data-target="#myModalVideo{{ $slider->id }}" type="button"><i class="fas fa-play"></i>
                                </button>
                            @endif

                        </div>
                    </div>

                    <!-- start modal -->
                    @if ( $slider->video != '' )
                        <div class="modal fade" id="myModalVideo{{ $slider->id }}" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content text-center">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        {{-- <h4 class="modal-title">مركز Eros</h4>
                                        @foreach ($footers as $footer)
                                            <p>{{ $footer->title}}</p>
                                        @endforeach
                                        <form>
                                            <input type="email" placeholder="البريد الالكتروني" />
                                            <input type="password" placeholder="كلمة السر" />
                                        </form>
                                        <div class="button-sec py-3">
                                            <button onclick="window.location.href='#'">تسجيل الدخول</button>
                                        </div> --}}

                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe id="cartoonVideo{{ $slider->id }}" class="embed-responsive-item" width="560" height="315" src="{{ $slider->video }}" allowfullscreen></iframe>
                                        </div>
                                        <script>
                                            $(function() {
                                                $('#myModal{{ $slider->id }}').on('hide.bs.modal', function(){
                                                    $('#cartoonVideo{{ $slider->id }}').attr('src', $('#cartoonVideo{{ $slider->id }}').attr('src'));
                                                });
                                            });

                                            $('#myModal{{ $slider->id }}').on('hide.bs.modal', function(){
                                                $('#cartoonVideo{{ $slider->id }}').attr('src', $('#cartoonVideo{{ $slider->id }}').attr('src'));
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- end modal -->
                @endforeach
            </div>
        </div>
    </div>
    <!-- end slider -->


    <!-- start about -->
    <div class="about py-4 text-center">
        <div class="container">
            <h5>عن المركز</h5>
            @foreach ($homeAbouts as $homeAbout)
                @if (($loop->index + 1) % 2 != 0)
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-3">
                            <h6 class="text-right" data-aos="flip-right" data-aos-easing="ease-out-cubic" style="color: #f9b519"
                                data-aos-duration="2000">{{ $homeAbout->title }}
                            </h6>
                            <br>
                            <p data-aos="flip-right" data-aos-easing="linear" data-aos-duration="1500">{{ $homeAbout->text }}</p>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-3">
                            <img src="{{ asset($homeAbout->image) }}" data-aos="flip-left" data-aos-easing="linear"
                                data-aos-duration="1500" />
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-3">
                            <img src="{{ asset($homeAbout->image) }}" data-aos="flip-left" data-aos-easing="linear"
                                data-aos-duration="1500" />
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-3">
                            <h6 class="text-right" data-aos="flip-right" data-aos-easing="ease-out-cubic" style="color: #f9b519"
                                data-aos-duration="2000">{{ $homeAbout->title }}
                            </h6>
                            <br>
                            <p data-aos="flip-right" data-aos-easing="linear" data-aos-duration="1500">{{ $homeAbout->text }}</p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <!-- end about -->


    <!-- start services -->
    <div class="services py-4 text-center">
        <div class="container">
            <h5>الخدمات</h5>
            <!-- Start PageTile -->
            @php
                $pageTitles = \App\Models\PageTitle::whereStatus(1)
                    ->wherePage('الرئيسية (الخدمات)')
                    ->get();
            @endphp
            @if ($pageTitles->count() > 0)
                @foreach ($pageTitles as $pageTitle)
                    <p class="text-center" style="color:white; text-align: justify !important;">{{ $pageTitle->title }}</p>
                @endforeach
            @endif
            <!-- End PageTile -->

            <div class="row" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1500">
                @foreach ($categories as $category)
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 mt-3">
                        <div class="image-services">
                            <img src="{{ asset($category->cover) }}" alt="Avatar" class="image"
                                style="width:100%">
                            <a href="/categories/{{ $category->id }}">
                                <div class="middle">
                                    <div class="text">{{ $category->name }}</div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <button onclick="window.location.href='{{ route('frontend.categories') }}'">المزيد</button>
        </div>
    </div>
    <!-- end services -->


    <!-- start booking -->
    <div class="booking py-4 text-right">
        <div class="container">
            <h5 class="text-center">مقتراحاتك</h5>
            <!-- Start PageTile -->
            @php
                $pageTitles = \App\Models\PageTitle::whereStatus(1)
                    ->wherePage('الرئيسية (مقتراحاتك)')
                    ->get();
            @endphp
            @if ($pageTitles->count() > 0)
                @foreach ($pageTitles as $pageTitle)
                    <p class="text-center mb-2" style="color:white; text-align: justify !important;">{{ $pageTitle->title }}</p>
                @endforeach
            @endif
            <!-- End PageTile -->
            <div class="row booking-row m-3" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1500">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-2">
                    <div class="contact-info py-3">
                        <form action="{{ route('frontend.send-contact-message') }}" method="post">
                            @csrf
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control" required placeholder="الاسم">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <input type="text" name="company" value="{{ old('company') }}"
                                class="form-control" placeholder="اسم الشركة (اختياري)">
                            @error('company')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <div class="row">
                                <div class="col-4">
                                    <select name="country_id" placeholder="الدولة" id="contactUs_country_id" class="form-control addForm"
                                        style="font-size: 0.8rem;">
                                        <option value="">الدولة</option>
                                        @forelse (\App\Models\Country::get(['id', 'name']) as $country)
                                            <option value="{{ $country->id }}"
                                                {{ old('country_id') == $country->id ? 'selected' : null }}>{{ $country->name }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('country_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-4">
                                    <select name="state_id" id="contactUs_state_id" class="form-control addForm" style="font-size: 0.8rem;">
                                    </select>
                                    @error('state_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-4">
                                    <select name="city_id" id="contactUs_city_id" class="form-control addForm" style="font-size: 0.8rem;">
                                    </select>
                                    @error('city_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <input type="text" name="mobile" value="{{ old('mobile') }}"
                                class="form-control" required placeholder="رقم الهاتف">
                            @error('mobile')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control" required placeholder="البريد الالكتروني">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <input type="text" name="subject" value="{{ old('subject') }}"
                                class="form-control" placeholder="عنوان الرسالة">
                            @error('subject')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <textarea name="message" rows="3" class="form-control"
                                placeholder="ما هي مقترحاتكم أو ما هو استفساركم ؟" required>{!! old('message') !!}</textarea>
                            @error('message')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="text-center">
                                <button type="submit" name="submit">ارسال</button>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-2">
                    <img src="{{ asset('frontend/images/istockphoto-1064019482-612x612.jpg') }}" />

                </div>

            </div>

        </div>

    </div>
    <!-- end booking -->



@endsection
@section('script')
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
                        $("#contactUs_city_id").append($('<option ' + selectedVal + '></option>').val(text.id).html(text.name));
                    });
                }, "json")
            }

        });
    </script>
@endsection
