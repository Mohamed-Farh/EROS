@extends('layouts.frontend_app')

@section('title', $medicalDetails->name)

@section('content')


    <!--begin::Content-->
    <div class="contain-sec py-4 ">

        @include('frontend.adv')

        <div class="description-sec py-3 mt-2">
            <div class="row">
                <div class="col">
                    <h4 class="title-1">{{ $medicalDetails->name }}</h4>
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
                <div class="col">
                    @php
                        $isLike = \App\Models\Like::whereUserId(auth()->user()->id)
                            ->whereProductId($medicalDetails->id)
                            ->whereType('MedicalProduct')
                            ->first();
                    @endphp
                    <form id="SubmitFormMedicalProduct">
                        <input type="hidden" class="form-control" id="product_id" value="{{ $medicalDetails->id }}">
                        <input type="hidden" class="form-control" id="type" value="MedicalProduct">
                        <button type="submit" class="likeAndUnlike"><i
                                class="like-button {{ !empty($isLike) ? 'fa fa-heart liked' : 'fa fa-heart-o not-liked' }}"></i></button>
                    </form>

                </div>
            @endauth



            @if ($medicalDetails->medical_type != 'Medicine')
                <h5>التخصص</h5>
                <div class="des-sec-1">
                    <p class="description-details">{{ $medicalDetails->speciality }}</p>
                </div>
                <h5>المسمي الوظيفي</h5>
                <div class="des-sec-1">
                    <p class="description-details">{{ $medicalDetails->type }}</p>
                </div>
                <h5> الوصف</h5>
                <div class="des-sec-1">
                    <p class="description-details">{{ $medicalDetails->description }}</p>
                </div>
                <h5> التفاصيل</h5>
                <div class="des-sec-1">
                    <div class="row">
                        <div class="col">
                            <p class="details1">النوع</p>
                        </div>
                        <div class="col">
                            <p class="details1">{{ $medicalDetails->gender == '1' ? 'دكتور' : 'دكتورة' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="details1">سنوات الخبرة</p>
                        </div>
                        <div class="col">
                            <p class="details1">{{ $medicalDetails->exp_years }}</p>
                        </div>
                    </div>
                </div>
                <h5> ساعات العمل</h5>
                <div class="des-sec-1">
                    <p class="description-details">{{ $medicalDetails->description }}</p>
                </div>
            @elseif ($medicalDetails->medical_type == 'Medicine')
                <h5> الوصف</h5>
                <div class="des-sec-1">
                    <p class="description-details">{{ $medicalDetails->description }}</p>
                </div>
                <h5> ساعات العمل</h5>
                <div class="des-sec-1">
                    <p class="description-details">{{ $medicalDetails->description }}</p>
                </div>
            @endif
            <h5>
                العنوان
            </h5>
            <div class="des-sec-1">
                {{-- @if ($medicalDetails->country_id != '')
                        <p class="description-details">{{ $medicalDetails->country->name .' - '. $medicalDetails->state->name .' - '. $medicalDetails->city->name }}</p>
                        <p class="description-details">{{ $medicalDetails->address }}</p>
                    @else
                        <p class="description-details">{{__('كل الدول') }}</p>
                    @endif --}}
                @if ($medicalDetails->country_id != '')
                    @if ($medicalDetails->city_id != '' && $medicalDetails->state_id != '')
                        <p class="description-details">
                            {{ $medicalDetails->country->name . ' - ' . $medicalDetails->state->name . ' - ' . $medicalDetails->city->name }}
                        </p>
                        <p class="description-details">
                            {{ $medicalDetails->address != '' ? $medicalDetails->address : '' }}</p>
                    @elseif ($medicalDetails->state_id != '')
                        <p class="description-details">
                            {{ $medicalDetails->country->name . ' - ' . $medicalDetails->state->name }}</p>
                        <p class="description-details">
                            {{ $medicalDetails->address != '' ? $medicalDetails->address : '' }}</p>
                    @else
                        <p class="description-details">{{ $medicalDetails->country->name }}</p>
                        <p class="description-details">
                            {{ $medicalDetails->address != '' ? $medicalDetails->address : '' }}</p>
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
                    <a href="https://wa.me/{{ $medicalDetails->phone }}" target="_blank" class="social-link">
                        <i class="fab fa-whatsapp"></i>{{ $medicalDetails->phone }}
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
        $('#SubmitFormMedicalProduct').on('submit', function(e) {
            e.preventDefault();
            let product_id = $('#product_id').val();
            let type = $('#type').val();
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
@endsection
