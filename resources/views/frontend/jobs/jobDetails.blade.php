@extends('layouts.frontend_app')

@section('title', $jobDetails->name)

@section('content')


    <!--begin::Content-->
    <div class="contain-sec py-4 ">

        @include('frontend.adv')

        <div class="description-sec py-3 mt-2">
            <div class="row">
                <div class="col">
                    <h4 class="title-1">{{ $jobDetails->name }}</h4>
                </div>
                @guest
                    <div class="col-2">
                        <input type="hidden" class="form-control" id="product_id" value="">
                        <input type="hidden" class="form-control" id="type">
                        <button class="likeAndUnlike"><i class="fa fa-heart-o not-liked"></i></button>
                    </div>
                @endguest
                @auth
                    <div class="col">
                        @php
                            $isLike = \App\Models\Like::whereUserId(auth()->user()->id)
                                ->whereProductId($jobDetails->id)
                                ->whereType('JobProduct')
                                ->first();
                        @endphp
                        <form id="SubmitFormJobProduct">
                            <input type="hidden" class="form-control" id="product_id" value="{{ $jobDetails->id }}">
                            <input type="hidden" class="form-control" id="type" value="JobProduct">
                            <button type="submit" class="likeAndUnlike"><i
                                    class="like-button {{ !empty($isLike) ? 'fa fa-heart liked' : 'fa fa-heart-o not-liked' }}"></i></button>
                        </form>

                    </div>
                @endauth
            </div>

            <h5>التخصص</h5>
            <div class="des-sec-1">
                <p class="description-details">{{ $jobDetails->speciality }}</p>
            </div>
            <h5> الوصف</h5>
            <div class="des-sec-1">
                <p class="description-details">{{ $jobDetails->description }}</p>
            </div>
            <h5> التفاصيل</h5>
            <div class="des-sec-1">
                <div class="row">
                    <div class="col">
                        <p class="details1">النوع</p>
                    </div>
                    <div class="col">
                        <p class="details1">{{ $jobDetails->gender == '1' ? 'معلم' : 'معلمة' }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="details1">سنوات الخبرة</p>
                    </div>
                    <div class="col">
                        <p class="details1">{{ $jobDetails->exp_years }}</p>
                    </div>
                </div>
            </div>
            <h5> ساعات العمل</h5>
            <div class="des-sec-1">
                <p class="description-details">{{ $jobDetails->description }}</p>
            </div>

            <h5>
                العنوان
            </h5>
            <div class="des-sec-1">
                {{-- @if ($jobDetails->country_id != '')
                        <p class="description-details">{{ $jobDetails->country->name .' - '. $jobDetails->state->name .' - '. $jobDetails->city->name }}</p>
                        <p class="description-details">{{ $jobDetails->address }}</p>
                    @else
                    <p class="description-details">{{__('كل الدول') }}</p>
                    @endif --}}
                @if ($jobDetails->country_id != '')
                    @if ($jobDetails->city_id != '' && $jobDetails->state_id != '')
                        <p class="description-details">
                            {{ $jobDetails->country->name . ' - ' . $jobDetails->state->name . ' - ' . $jobDetails->city->name }}
                        </p>
                        <p class="description-details">{{ $jobDetails->address != '' ? $jobDetails->address : '' }}
                        </p>
                    @elseif ($jobDetails->state_id != '')
                        <p class="description-details">
                            {{ $jobDetails->country->name . ' - ' . $jobDetails->state->name }}
                        </p>
                        <p class="description-details">{{ $jobDetails->address != '' ? $jobDetails->address : '' }}
                        </p>
                    @else
                        <p class="description-details">{{ $jobDetails->country->name }}</p>
                        <p class="description-details">{{ $jobDetails->address != '' ? $jobDetails->address : '' }}
                        </p>
                    @endif
                @else
                    <p class="description-details">{{ __('كل الدول') }}</p>
                @endif
            </div>
            <h5>
                التواصل
            </h5>
            <div class="des-sec-1">
                <p class="contact-details">
                    <a href="https://wa.me/{{ $jobDetails->phone }}" target="_blank" class="social-link">
                        <i class="fab fa-whatsapp"></i>{{ $jobDetails->phone }}
                    </a>
                </p>
            </div>
        </div>
    </div>
    <!--end::Content-->

@endsection
@section('script')
    <script src="{{ asset('frontend/js/index.js') }}"></script>

    <script type="text/javascript">
        $('#SubmitFormJobProduct').on('submit', function(e) {
            e.preventDefault();
            let product_id = $('#product_id').val();
            let type = $('#type').val();
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
@endsection
