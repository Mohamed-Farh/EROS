@extends('layouts.frontend_app')
@php $title = \App\Models\JobCategory::whereId($jobCategory)->first() @endphp
@section('title', $title->name)

@section('content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <style>
        .start-containt-search select {
            width: 100%;
        }

        .contain-sec .search-btn {
            width: 100%;
        }

    </style>

    <div class="contain-sec py-4">

        @include('frontend.adv')

        <div class="row start-containt-search py-2">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <form action="{{ route('frontend.jobSearch') }}" method="Post">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <input type="hidden" name="jobCategory" value="{{ $jobCategory }}">
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
        @forelse ($jobs as $job)
            <div class="buildings-ads py-2 ">
                <div class="ads-building ">
                    <div class="row ">
                        <div class="col-12">
                            <div class="row text-right">
                                <div class="col-10">
                                    <div id="outer" class=" p-2">
                                        <div class="button_slide slide_left show-details-btn" style="width: 95%;">
                                            <a href="{{ route('frontend.jobDetails', ['job' => $job->id]) }}"
                                                style="font-size: 12px;">
                                                {{ $job->name }}
                                            </a>
                                        </div>
                                        <p style="font-size: 12px;">{{ $job->speciality }}</p>
                                        <p style="font-size: 12px;">
                                            @if ($job->country_id != '')
                                                @if ($job->city_id != '' && $job->state_id != '')
                                                    {{ $job->country->name . ' - ' . $job->state->name . ' - ' . $job->city->name }}
                                                @elseif ($job->state_id != '')
                                                    {{ $job->country->name . ' - ' . $job->state->name }}
                                                @else
                                                    {{ $job->country->name }}
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
                                                ->whereProductId($job->id)
                                                ->whereType('JobProduct')
                                                ->first();
                                        @endphp
                                        <form id="SubmitFormJob_{{ $job->id }}">
                                            <input type="hidden" class="form-control" id="product_id{{ $job->id }}"
                                                value="{{ $job->id }}">
                                            <input type="hidden" class="form-control" id="type{{ $job->id }}"
                                                value="JobProduct">
                                            <button type="submit" class="likeAndUnlike"><i
                                                    class="like-button {{ !empty($isLike) ? 'fa fa-heart liked' : 'fa fa-heart-o not-liked' }}"></i></button>
                                        </form>
                                        <script type="text/javascript">
                                            $('#SubmitFormJob_{{ $job->id }}').on('submit', function(e) {
                                                e.preventDefault();
                                                let product_id = $('#product_id{{ $job->id }}').val();
                                                let type = $('#type{{ $job->id }}').val();
                                                $.ajax({
                                                    url: "{{ route('frontend.jobLikeAndDislike') }}",
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
