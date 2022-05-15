@extends('layouts.frontend_app')

@section('title', 'اتصل بنا')

@section('content')

    <!-- start contact -->
    <div class="contact py-4">
        <div class="container mb-3">
            <h5>تواصل معنا</h5>
            <!-- Start PageTile -->
            @php
                $pageTitles = \App\Models\PageTitle::whereStatus(1)
                    ->wherePage('اتصل بنا')
                    ->get();
                $locations = \App\Models\Location::whereStatus(1)
                    ->orderBy('id', 'desc')
                    ->get();
                $workingTimes = \App\Models\WorkingTime::whereStatus(1)->get();
            @endphp
            @if ($pageTitles->count() > 0)
                @foreach ($pageTitles as $pageTitle)
                    <p class="text-center" style="color:white; text-align: justify !important;">{{ $pageTitle->title }}
                    </p>
                @endforeach
            @endif
            <!-- End PageTile -->
            <div class="row" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1500">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mt-2">
                    <div class="contact-info py-3">
                        <form action="{{ route('frontend.send-contact-message') }}" method="post">
                            @csrf
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required
                                placeholder="الاسم">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <input type="text" name="company" value="{{ old('company') }}" class="form-control"
                                placeholder="اسم الشركة (اختياري)">
                            @error('company')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <input type="text" name="mobile" value="{{ old('mobile') }}" class="form-control" required
                                placeholder="رقم الهاتف">
                            @error('mobile')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required
                                placeholder="البريد الالكتروني">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            
                            <div class="row">
                                <div class="col-4">
                                    <select name="country_id" placeholder="الدولة" id="contactUs_country_id"
                                        class="form-control addForm" style="font-size: 0.8rem;">
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
                                    <select name="state_id" id="contactUs_state_id" class="form-control addForm"
                                        style="font-size: 0.8rem;">
                                    </select>
                                    @error('state_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-4">
                                    <select name="city_id" id="contactUs_city_id" class="form-control addForm"
                                        style="font-size: 0.8rem;">
                                    </select>
                                    @error('city_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <input type="text" name="subject" value="{{ old('subject') }}" class="form-control"
                                placeholder="عنوان الرسالة">
                            @error('subject')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <textarea name="message" rows="3" class="form-control" placeholder="ما هي مقترحاتكم أو ما هو استفساركم ؟"
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


                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mt-2">
                    <h4>اوقات العمل</h4>
                    <div class="line-1"></div>
                    @foreach ($workingTimes as $workingTime)
                        <div class="row ">
                            <div class="col-3">
                                <p class="day">{{ $workingTime->day }}</p>
                            </div>
                            <div class="col-9">
                                <p class="time text-left" style="direction: ltr">
                                    {{ date('h:i A', strtotime($workingTime->start)) }}-{{ date('h:i A', strtotime($workingTime->end)) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        <div class="line-1"></div>

        <h5 class="mt-3">العنوان</h5>
        <div class="container text-right">
            @foreach ($locations as $location)
                @if ($location->country_id != '')
                    @if ($location->city_id != '' && $location->state_id != '')
                        <p style="color: white"><i class="fas fa-map-marker-alt"></i>
                            {{ $location->country->name . ' - ' . $location->state->name . ' - ' . $location->city->name }}
                        </p>
                        <p style="color: darkcyan;">{{ $location->description }}</p><br>
                    @elseif ($location->state_id != '')
                        <p style="color: white"><i class="fas fa-map-marker-alt"></i>
                            {{ $location->country->name . ' - ' . $location->state->name }}</p>
                        <p style="color: darkcyan;">{{ $location->description }}</p><br>
                    @else
                        <p style="color: white"><i class="fas fa-map-marker-alt"></i> {{ $location->country->name }}</p>
                        <p style="color: darkcyan;">{{ $location->description }}</p><br>
                    @endif
                @endif
            @endforeach

            @foreach ($locations as $location)
                <div class="map py-2" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1500">
                    <iframe src="{{ $location->location }}" width="100%" height="350" style="border:0;"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            @endforeach
        </div>
    </div>
    <!-- end contact -->


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
                        $("#contactUs_city_id").append($('<option ' + selectedVal + '></option>')
                            .val(text.id).html(text.name));
                    });
                }, "json")
            }

        });
    </script>
@endsection
