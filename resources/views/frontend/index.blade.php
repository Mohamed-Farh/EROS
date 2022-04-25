@extends('layouts.frontend_app')

@section('title', 'الرئيسية')

@section('content')

    <style>
        .slider-sec img {
            width: 100%;
            height: 100%;
        }
    </style>
    <div class="contain-sec py-4">

        @include('frontend.adv')
        
        <div class="row card-sec py-2 mr-1 ml-1">
            <div class="col-6 mt-2">
                <div class="card text-center" style="width: 100%">
                    <a href="{{ route('frontend.mainBuildings') }}"><img
                            src="{{ asset('frontend/images/2544087.png') }}" class="card-img-top" alt="..." /></a>
                    <h5 class="card-title text-center">
                        <a href="{{ route('frontend.mainBuildings') }}">عقارات</a>
                    </h5>
                </div>
            </div>
            <div class="col-6 mt-2">
                <div class="card text-center" style="width: 100%">
                    <a href="{{ route('frontend.mainCars') }}"><img src="{{ asset('frontend/images/3774278.png') }}"
                            class="card-img-top" alt="..." /></a>
                    <h5 class="card-title text-center">
                        <a href="{{ route('frontend.mainCars') }}">عربيات</a>
                    </h5>
                </div>
            </div>
            <div class="col-6 mt-2">
                <div class="card text-center" style="width: 100%">
                    <a href="{{ route('frontend.weather') }}"><img src="{{ asset('frontend/images/578116.png') }}"
                            class="card-img-top" alt="..." /></a>
                    <h5 class="card-title text-center">
                        <a href="{{ route('frontend.weather') }}">طقس</a>
                    </h5>
                </div>
            </div>
            <div class="col-6 mt-2">
                <div class="card text-center" style="width: 100%">
                    <a href="{{ route('frontend.medicalMain') }}"><img src="{{ asset('frontend/images/3004458.png') }}"
                            class="card-img-top" alt="..." /></a>
                    <h5 class="card-title text-center">
                        <a href="{{ route('frontend.medicalMain') }}">خدمات طبية</a>
                    </h5>
                </div>
            </div>
            <div class="col-6 mt-2">
                <div class="card text-center" style="width: 100%">
                    <a href="{{ route('frontend.prayer') }}"><img src="{{ asset('frontend/images/3858880.png') }}"
                            class="card-img-top" alt="..." /></a>
                    <h5 class="card-title text-center">
                        <a href="{{ route('frontend.prayer') }}">مواعيد الصلاة</a>
                    </h5>
                </div>
            </div>
            <div class="col-6 mt-2">
                <div class="card text-center" style="width: 100%">
                    <a href="{{ route('frontend.jobMain') }}"><img src="{{ asset('frontend/images/4664514.png') }}"
                            class="card-img-top" alt="..." /></a>
                    <h5 class="card-title text-center">
                        <a href="{{ route('frontend.jobMain') }}">فرص عمل</a>
                    </h5>
                </div>
            </div>
            <div class="col-6 mt-2">
                <div class="card text-center" style="width: 100%">
                    <a href="{{ route('frontend.money') }}"><img src="{{ asset('frontend/images/2953423.png') }}"
                            class="card-img-top" alt="..." /></a>
                    <h5 class="card-title text-center">
                        <a href="{{ route('frontend.money') }}">صرف عملة</a>
                    </h5>
                </div>
            </div>
            <div class="col-6 mt-2">
                <div class="card text-center" style="width: 100%">
                    <a href="{{ route('frontend.productMain') }}"><img
                            src="{{ asset('frontend/images/5895213.png') }}" class="card-img-top" alt="..." /></a>
                    <h5 class="card-title text-center">
                        <a href="{{ route('frontend.productMain') }}">منتجات</a>
                    </h5>
                </div>
            </div>
        </div>
        <!--end::Content-->
    </div>
@endsection
