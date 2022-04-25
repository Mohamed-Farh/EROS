@extends('layouts.frontend_app')

@section('title', 'بحث سيارات')

@section('content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>

    <style>
        .start-containt-search select {
            width: 100%;
        }

        .contain-sec .search-btn {
            width: 100%;
        }

        .start-containt-search {
            margin-top: 0% !important;
        }

    </style>


    <div class="contain-sec py-4">

        @include('frontend.adv')

        <div class="row start-containt-search py-2">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <form action="{{ route('frontend.carSearch') }}" method="Post">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <input type="hidden" name="carCategory" value="{{ $carCategory }}">
                            <input type="hidden" name="carType" value="{{ $carType }}">

                            <select name="country_id" id="country_id" required>
                                <option value="" selected hidden>الدولة</option>
                                @forelse (\App\Models\Country::whereStatus('1')->get(['id', 'name']) as $country)
                                    <option value="{{ $country->id }}"
                                        {{ old('country_id') == $country->id ? 'selected' : null }}>
                                        {{ $country->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="col-6">
                            <select name="state_id" id="state_id" class="form-control">
                            </select>
                        </div>
                        <div class="col-6 mt-3">
                            <select name="city_id" id="city_id" class="form-control">
                            </select>
                        </div>
                        <div class="col-6 mt-3">
                            <button type="submit" class="search-btn"> بحث</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!--begin::Content-->
        @forelse ($carProducts as $carProduct)
            <div class="buildings-ads py-2 ">
                <div class="ads-building ">
                    <div class="row ">
                        <div class="col-4">
                            <a href="{{ route('frontend.carDetails', ['carProduct' => $carProduct]) }}">
                                @if ($carProduct->firstMedia)
                                    <img class="rounded" src="{{ asset($carProduct->firstMedia->file_name) }}"
                                        width="90" height="60" alt="{{ $carProduct->name }}">
                                @else
                                    <img class="rounded" src="{{ asset('assets/no_image.png') }}" width="60"
                                        height="90" alt="{{ $carProduct->name }}">
                                @endif
                            </a>
                        </div>
                        <div class="col-8">
                            <div class="row text-right">
                                <div class="col-10">
                                    <div id="outer">
                                        <div class="button_slide slide_left show-details-btn" style="width: 95%;">
                                            <a href="{{ route('frontend.carDetails', ['carProduct' => $carProduct]) }}"
                                                style="font-size: 12px;">
                                                {{ $carProduct->name }}
                                            </a>
                                        </div>
                                        <p style="color: blue;"><span>{{ $carProduct->carType->name }}</span></p>
                                        <p style="color: red;"><span>{{ $carProduct->price }} $</span></p>
                                        <p style="font-size: 12px;">
                                            {{-- {{ $carProduct->country->name . ' - ' . $carProduct->state->name . ' - ' . $carProduct->city->name }} --}}
                                            @if ($carProduct->country_id != '')
                                                @if ($carProduct->city_id != '' && $carProduct->state_id != '')
                                                    {{ $carProduct->country->name . ' - ' . $carProduct->state->name . ' - ' . $carProduct->city->name }}
                                                @elseif ($carProduct->state_id != '')
                                                    {{ $carProduct->country->name . ' - ' . $carProduct->state->name }}
                                                @else
                                                    {{ $carProduct->country->name }}
                                                @endif
                                            @else
                                                {{ __('كل الدول') }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                @guest
                                    <div class="col-2">
                                        <input type="hidden" class="form-control" id="product_id" value="">
                                        <input type="hidden" class="form-control" id="type">
                                        <button class="likeAndUnlike"><i class="fa fa-heart-o not-liked"></i></button>
                                    </div>
                                @endguest
                                @auth
                                    <div class="col-2">
                                        @php
                                            $isLike = \App\Models\Like::whereUserId(auth()->user()->id)
                                                ->whereProductId($carProduct->id)
                                                ->whereType('CarProduct')
                                                ->first();
                                        @endphp
                                        <form id="SubmitFormCarSearch_{{ $carProduct->id }}">
                                            <input type="hidden" class="form-control" id="product_id{{ $carProduct->id }}"
                                                value="{{ $carProduct->id }}">
                                            <input type="hidden" class="form-control" id="type{{ $carProduct->id }}"
                                                value="CarProduct">
                                            <button type="submit" class="likeAndUnlike"><i
                                                    class="like-button {{ !empty($isLike) ? 'fa fa-heart liked' : 'fa fa-heart-o not-liked' }}"></i></button>
                                        </form>
                                        <script type="text/javascript">
                                            $('#SubmitFormCarSearch_{{ $carProduct->id }}').on('submit', function(e) {
                                                e.preventDefault();
                                                let product_id = $('#product_id{{ $carProduct->id }}').val();
                                                let type = $('#type{{ $carProduct->id }}').val();
                                                $.ajax({
                                                    url: "{{ route('frontend.carLikeAndDislike') }}",
                                                    type: "POST",
                                                    data: {
                                                        "_token": "{{ csrf_token() }}",
                                                        product_id: product_id,
                                                        type: type,
                                                    },
                                                    success: function(response) {
                                                        $('#successMsg').show();
                                                        console.log(response);
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                @endauth
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
