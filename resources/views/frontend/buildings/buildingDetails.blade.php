@extends('layouts.frontend_app')

@section('title', $buildingDetails->name)

@section('content')

    <div class="contain-sec py-4">

        <!--begin::Content-->
        <div class="contain-sec py-4 ">

            @include('frontend.adv')

            <div class="gallery-buildings99 text-center">
                <div class="row">
                    @foreach ($buildingDetails->media as $media)
                        <div class="column">
                            <img src="{{ asset($media->file_name) }}" alt="" style="width:100%"
                                onclick="myFunction(this);">
                        </div>
                        <script>
                            function myFunction(imgs) {
                                var expandImg = document.getElementById("expandedImg");
                                var imgText = document.getElementById("imgtext");
                                expandImg.src = imgs.src;
                                imgText.innerHTML = imgs.alt;
                                expandImg.parentElement.style.display = "block";
                            }
                        </script>
                    @endforeach
                </div>
                <div class="container container-99">
                    <span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
                    <img id="expandedImg">
                    <div id="imgtext"></div>
                </div>
            </div>


            <div class="description-sec py-3 mt-2">
                <div class="row">
                    <div class="col">
                        <h4 class="title-1">{{ $buildingDetails->name }}</h4>
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
                                    ->whereProductId($buildingDetails->id)
                                    ->whereType('BuildingProduct')
                                    ->first();
                            @endphp
                            <form id="SubmitFormBuildingProduct">
                                <input type="hidden" class="form-control" id="product_id"
                                    value="{{ $buildingDetails->id }}">
                                <input type="hidden" class="form-control" id="type" value="BuildingProduct">
                                <button type="submit" class="likeAndUnlike"><i
                                        class="like-button {{ !empty($isLike) ? 'fa fa-heart liked' : 'fa fa-heart-o not-liked' }}"></i></button>
                            </form>

                        </div>
                    @endauth
                </div>
                <h5>
                    القسم
                </h5>
                <div class="des-sec-1">
                    <p class="description-details">{{ $buildingDetails->buildingCategory->name }}</p>
                </div>
                <h5>
                    الوصف
                </h5>
                <div class="des-sec-1">
                    <p class="description-details">{{ $buildingDetails->description }}</p>
                </div>
                <h5>
                    التفاصيل
                </h5>
                <div class="des-sec-1">
                    <div class="row">
                        <div class="col">
                            <p class="details1">المساحة</p>
                        </div>
                        <div class="col">
                            <p class="details1">{{ $buildingDetails->size }} متر</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="details1">الفرف</p>
                        </div>
                        <div class="col">
                            <p class="details1">{{ $buildingDetails->bedroom }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="details1">الحمام</p>
                        </div>
                        <div class="col">
                            <p class="details1">{{ $buildingDetails->bathroom }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="details1">الصالة</p>
                        </div>
                        <div class="col">
                            <p class="details1">{{ $buildingDetails->hall }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="details1">بيع - ايجار</p>
                        </div>
                        <div class="col">
                            <p class="details1">{{ $buildingDetails->rent == 1 ? 'ايجار' : 'بيع' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="details1">السعر</p>
                        </div>
                        <div class="col">
                            <p class="details1">{{ $buildingDetails->price }} $</p>
                        </div>
                    </div>
                </div>
                <h5>
                    العنوان
                </h5>
                <div class="des-sec-1">
                    {{-- @if ($buildingDetails->country_id != '')
                        <p class="description-details">{{ $buildingDetails->country->name .' - '. $buildingDetails->state->name .' - '. $buildingDetails->city->name }}</p>
                        <p class="description-details">{{ $buildingDetails->address }}</p>

                    @else
                    <p class="description-details">{{__('كل الدول') }}</p>
                    @endif --}}
                    @if ($buildingDetails->country_id != '')
                        @if ($buildingDetails->city_id != '' && $buildingDetails->state_id != '')
                            <p class="description-details">
                                {{ $buildingDetails->country->name .' - ' .$buildingDetails->state->name .' - ' .$buildingDetails->city->name }}
                            </p>
                            <p class="description-details">
                                {{ $buildingDetails->address != '' ? $buildingDetails->address : '' }}</p>
                        @elseif ($buildingDetails->state_id != '')
                            <p class="description-details">
                                {{ $buildingDetails->country->name . ' - ' . $buildingDetails->state->name }}</p>
                            <p class="description-details">
                                {{ $buildingDetails->address != '' ? $buildingDetails->address : '' }}</p>
                        @else
                            <p class="description-details">{{ $buildingDetails->country->name }}</p>
                            <p class="description-details">
                                {{ $buildingDetails->address != '' ? $buildingDetails->address : '' }}</p>
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
                        <a href="https://wa.me/{{ $buildingDetails->phone }}" target="_blank" class="social-link">
                            <i class="fab fa-whatsapp"></i>{{ $buildingDetails->phone }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <!--end::Content-->


    </div>
@endsection
@section('script')
    <script src="{{ asset('frontend/js/index.js') }}"></script>

    <script type="text/javascript">
        $('#SubmitFormBuildingProduct').on('submit', function(e) {
            e.preventDefault();
            let product_id = $('#product_id').val();
            let type = $('#type').val();
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
@endsection
