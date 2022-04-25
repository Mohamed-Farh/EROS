@extends('layouts.frontend_app')

@section('title', 'سيارات')

@section('content')

    <div class="contain-sec py-4">

        @include('frontend.adv')

        <!--begin::Content-->
        @forelse ($carCategories as $carCategory)
            <div class="buildings-ads py-1">
                <div class="ads-building ">
                    <div class="row">
                        <div class="col-6">
                            <div class="title-buildings">
                                <p class="title-link">
                                    <a
                                        href="{{ route('frontend.carTypes', ['carCategory' => $carCategory]) }}">{{ $carCategory->name }}</a>
                                </p>
                                <p class="advertisment-num">( {{ $carCategory->products_count }} ) اعلان</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('frontend.carTypes', ['carCategory' => $carCategory]) }}">
                                <img class="rounded ml-3" width="90" height="60" src="{{ asset($carCategory->cover) }}">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="buildings-ads py-1">
                <div class="ads-building ">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h6>عفوا لا بوجد بيانات متاحة حاليا</h6>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
        <!--end::Content-->
    </div>
@endsection
