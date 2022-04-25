@extends('layouts.frontend_app')

@section('title', 'انواع السيارات')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"
        rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

    <style>
        .start-containt-search {
            margin-top: 0%;
        }

    </style>
    <div class="contain-sec py-4">

        @include('frontend.adv')

        <div class="row start-containt-search py-2">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <form action="{{ route('frontend.carTypeSearch', ['carCategory' => $carCategory]) }}" method="Post">
                    @csrf
                    <input type="hidden" name="carCategory" value="{{ $carCategory }}">
                    <select name="car_type_id" class="search-select" required>
                        <option value="" selected hidden>النوع</option>
                        @forelse (\App\Models\CarType::whereStatus('1')->get(['id', 'name']) as $carType)
                            <option value="{{ $carType->id }}"
                                {{ old('car_type_id') == $carType->id ? 'selected' : null }} required>
                                {{ $carType->name }}
                            </option>
                        @empty
                        @endforelse
                    </select>

                    <input type="text" name="year" id="datepicker" placeholder="الموديل" style="width: 34% !important">
                    <script>
                        $("#datepicker").datepicker({
                            format: "yyyy",
                            viewMode: "years",
                            minViewMode: "years",
                            autoclose: true
                        });
                    </script>

                    <button type="submit" class="search-btn"> بحث</button>
                </form>
            </div>
        </div>

        <!--begin::Content-->
        @forelse ($carTypes as $carType)
            <div class="buildings-ads py-2 ">
                <div class="ads-building ">
                    <div class="row ">
                        <div class="col-4">
                            <a href="{{ route('frontend.cars', ['carType' => $carType, 'carCategory' => $carCategory]) }}">
                                @if ($carType->cover)
                                    <img class="rounded" src="{{ asset($carType->cover) }}" width="90" height="60"
                                        alt="{{ $carType->name }}">
                                @else
                                    <img class="rounded" src="{{ asset('assets/no_image.png') }}" width="60"
                                        height="90" alt="{{ $carType->name }}">
                                @endif
                            </a>
                        </div>
                        <div class="col-8">
                            <div class="col-10">
                                <div id="outer">
                                    <div class="button_slide slide_left show-details-btn" style="width: 95%;">
                                        <a href="{{ route('frontend.cars', ['carType' => $carType, 'carCategory' => $carCategory]) }}"
                                            style="font-size: 12px;">
                                            {{ $carType->name }}
                                        </a>
                                    </div>
                                    <p class="advertisment-num">( {{ $carType->products_count }} ) اعلان</p>
                                    {{-- <p style="font-size: 12px;">{{ $carType->country->name .' - '. $carType->state->name .' - '. $carType->city->name }}</p> --}}
                                </div>
                            </div>
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
@section('script')
    <script src="{{ asset('frontend/js/index.js') }}"></script>
@endsection
