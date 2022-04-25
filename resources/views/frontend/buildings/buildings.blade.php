@extends('layouts.frontend_app')

@section('title', 'عقارات')

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
            margin-top: 0%;
        }

    </style>


    <div class="contain-sec py-4">

        @include('frontend.adv')

        <div class="row start-containt-search py-2">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <form action="{{ route('frontend.buildingSearch', ['buildingCategory' => $buildingCategory]) }}"
                    method="Post">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <select name="country_id" id="country_id">
                                <option value="" selected hidden>كل الدول</option>
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
        @forelse ($buildingProducts as $buildingProduct)
            <div class="buildings-ads py-2 ">
                <div class="ads-building ">
                    <div class="row ">
                        <div class="col-4">
                            <a href="{{ route('frontend.buildingDetails', ['buildingProduct' => $buildingProduct]) }}"
                                style="font-size: 12px;">
                                @if ($buildingProduct->firstMedia)
                                    <img class="rounded" src="{{ asset($buildingProduct->firstMedia->file_name) }}"
                                        width="90" height="60" alt="{{ $buildingProduct->name }}">
                                @else
                                    <img class="rounded" src="{{ asset('assets/no_image.png') }}" width="60"
                                        height="90" alt="{{ $buildingProduct->name }}">
                                @endif
                            </a>
                        </div>
                        <div class="col-8">
                            <div class="row text-right">
                                <div class="col-10">
                                    <div id="outer">
                                        <div class="button_slide slide_left show-details-btn" style="width: 95%;">
                                            <a href="{{ route('frontend.buildingDetails', ['buildingProduct' => $buildingProduct]) }}"
                                                style="font-size: 12px;">
                                                {{ $buildingProduct->name }}
                                            </a>
                                        </div>
                                        <p style="color: red;"><span>{{ $buildingProduct->price }} $</span></p>
                                        <p style="font-size: 12px;">
                                            {{-- @if ($buildingProduct->country_id != '')
                                                {{ $buildingProduct->country->name . ' - ' . $buildingProduct->state->name . ' - ' . $buildingProduct->city->name }}
                                            @else
                                                {{__('كل الدول') }}
                                            @endif --}}
                                            @if ($buildingProduct->country_id != '')
                                                @if ($buildingProduct->city_id != '' && $buildingProduct->state_id != '')
                                                    {{ $buildingProduct->country->name .' - ' .$buildingProduct->state->name .' - ' .$buildingProduct->city->name }}
                                                @elseif ($buildingProduct->state_id != '')
                                                    {{ $buildingProduct->country->name . ' - ' . $buildingProduct->state->name }}
                                                @else
                                                    {{ $buildingProduct->country->name }}
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
                                                ->whereProductId($buildingProduct->id)
                                                ->whereType('BuildingProduct')
                                                ->first();
                                        @endphp
                                        <form id="SubmitForm{{ $buildingProduct->id }}">
                                            <input type="hidden" class="form-control"
                                                id="product_id{{ $buildingProduct->id }}"
                                                value="{{ $buildingProduct->id }}">
                                            <input type="hidden" class="form-control" id="type{{ $buildingProduct->id }}"
                                                value="BuildingProduct">
                                            <button type="submit" class="likeAndUnlike"><i
                                                    class="like-button {{ !empty($isLike) ? 'fa fa-heart liked' : 'fa fa-heart-o not-liked' }}"></i></button>
                                        </form>
                                        <script type="text/javascript">
                                            $('#SubmitForm{{ $buildingProduct->id }}').on('submit', function(e) {
                                                e.preventDefault();
                                                let product_id = $('#product_id{{ $buildingProduct->id }}').val();
                                                let type = $('#type{{ $buildingProduct->id }}').val();
                                                $.ajax({
                                                    url: "{{ route('frontend.buildingLikeAndDislike') }}",
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
