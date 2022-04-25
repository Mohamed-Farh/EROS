@extends('layouts.frontend_app')

@section('title', $title)

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
                <form action="{{ route('frontend.medicalSearch') }}" method="Post">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <input type="hidden" name="medicalType" value="{{ $medicalType }}">
                            <input type="hidden" name="title" value="{{ $title }}">
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
        @forelse ($medicals as $medical)
            <div class="buildings-ads py-2 ">
                <div class="ads-building ">
                    <div class="row ">
                        <div class="col-12">
                            <div class="row text-right">
                                <div class="col-10">
                                    <div id="outer" class=" p-2">
                                        <div class="button_slide slide_left show-details-btn" style="width: 95%;">
                                            <a href="{{ route('frontend.medicalDetails', ['medical' => $medical->id]) }}"
                                                style="font-size: 12px;">
                                                {{ $medical->name }}
                                            </a>
                                        </div>
                                        <p style="font-size: 12px;">
                                            @if ($medical->country_id != '')
                                                @if ($medical->city_id != '' && $medical->state_id != '')
                                                    {{ $medical->country->name . ' - ' . $medical->state->name . ' - ' . $medical->city->name }}
                                                @elseif ($medical->state_id != '')
                                                    {{ $medical->country->name . ' - ' . $medical->state->name }}
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
                                                ->whereProductId($medical->id)
                                                ->whereType('MedicalProduct')
                                                ->first();
                                        @endphp
                                        <form id="SubmitFormMedical_{{ $medical->id }}">
                                            <input type="hidden" class="form-control" id="product_id{{ $medical->id }}"
                                                value="{{ $medical->id }}">
                                            <input type="hidden" class="form-control" id="type{{ $medical->id }}"
                                                value="MedicalProduct">
                                            <button type="submit" class="likeAndUnlike"><i
                                                    class="like-button {{ !empty($isLike) ? 'fa fa-heart liked' : 'fa fa-heart-o not-liked' }}"></i></button>
                                        </form>
                                        <script type="text/javascript">
                                            $('#SubmitFormMedical_{{ $medical->id }}').on('submit', function(e) {
                                                e.preventDefault();
                                                let product_id = $('#product_id{{ $medical->id }}').val();
                                                let type = $('#type{{ $medical->id }}').val();
                                                $.ajax({
                                                    url: "{{ route('frontend.medicalLikeAndDislike') }}",
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
