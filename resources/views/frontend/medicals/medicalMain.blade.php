@extends('layouts.frontend_app')

@section('title', 'خدمات طبية')

@section('content')

    <div class="contain-sec py-4">

        @include('frontend.adv')


        <!--begin::Content-->
        <div class="row mt-3">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="container-medical-services">
                    <img src="{{ asset('frontend/images/Mask Group 911.png') }}" alt="" class="image">
                    <div class="middle">
                        <div class="text"><a href="{{ route('frontend.medicals', ['medicalType' => 'Doctor']) }}"
                                style="color: white;">الطب</a></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="container-medical-services">
                    <img src="{{ asset('frontend/images/Mask Group 9.png') }}" alt="" class="image">
                    <div class="middle">
                        <div class="text"><a href="{{ route('frontend.medicals', ['medicalType' => 'Nurse']) }}"
                                style="color: white;">التمريض</a></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="container-medical-services">
                    <img src="{{ asset('frontend/images/Mask Group 91.png') }}" alt="" class="image">
                    <div class="middle">
                        <div class="text"><a
                                href="{{ route('frontend.medicals', ['medicalType' => 'Medicine']) }}"
                                style="color: white;">الصيدلة</a></div>
                    </div>
                </div>
            </div>

        </div>
        <!--end::Content-->
    </div>
@endsection
