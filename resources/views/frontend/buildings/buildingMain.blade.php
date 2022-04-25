@extends('layouts.frontend_app')

@section('title', 'عقارات')

@section('content')





    <div class="contain-sec py-4">
        
        @include('frontend.adv')

        <!--begin::Content-->
        @forelse ($buildingCategories as $buildingCategory)
            <div class="buildings-ads py-1">
                <div class="ads-building ">
                    <div class="row">
                        <div class="col-6">
                            <div class="title-buildings">
                                <p class="title-link"><a
                                        href="{{ route('frontend.buildings', ['buildingCategory' => $buildingCategory]) }}">{{ $buildingCategory->name }}</a>
                                </p>
                                <p class="advertisment-num">( {{ $buildingCategory->products_count }} ) اعلان</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <img class="rounded ml-3" width="90" height="60" src="{{ asset($buildingCategory->cover) }}">
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
