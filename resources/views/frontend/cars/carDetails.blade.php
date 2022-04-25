@extends('layouts.frontend_app')

@section('title', $carDetails->name)

@section('content')


    <!--begin::Content-->
    <div class="contain-sec py-4 ">

        @include('frontend.adv')

        <div class="gallery-buildings99 text-center">
            <div class="row">
                @foreach ($carDetails->media as $media)
                    <div class="column">
                        <img src="{{ asset($media->file_name) }}" alt="" style="width:100%" onclick="myFunction(this);">
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
                    <h4 class="title-1">{{ $carDetails->name }}</h4>
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
                                ->whereProductId($carDetails->id)
                                ->whereType('CarProduct')
                                ->first();
                        @endphp
                        <form id="SubmitFormCarProduct">
                            <input type="hidden" class="form-control" id="product_id" value="{{ $carDetails->id }}">
                            <input type="hidden" class="form-control" id="type" value="CarProduct">
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
                <p class="description-details">{{ $carDetails->carCategory->name }}</p>
            </div>
            <h5>
                الوصف
            </h5>
            <div class="des-sec-1">
                <p class="description-details">{{ $carDetails->description }}</p>
            </div>
            <h5>
                التفاصيل
            </h5>
            <div class="des-sec-1">
                <div class="row">
                    <div class="col">
                        <p class="details1">الماركة</p>
                    </div>
                    <div class="col">
                        <p class="details1">{{ $carDetails->carType->name }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="details1">الموديل</p>
                    </div>
                    <div class="col">
                        <p class="details1">{{ $carDetails->year }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="details1">اللون</p>
                    </div>
                    <div class="col">
                        <p class="details1">{{ $carDetails->color }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="details1">عادي - اوتوماتيك</p>
                    </div>
                    <div class="col">
                        <p class="details1">{{ $carDetails->manual == 1 ? 'عادي' : 'اوتوماتيك' }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="details1">المسافة التي قطعتها</p>
                    </div>
                    <div class="col">
                        <p class="details1">{{ $carDetails->distance }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="details1">حالة الموتور</p>
                    </div>
                    <div class="col">
                        <p class="details1">{{ $carDetails->motor }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="details1">الصوت</p>
                    </div>
                    <div class="col">
                        <p class="details1">{{ $carDetails->sound }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="details1">عدد المقاعد</p>
                    </div>
                    <div class="col">
                        <p class="details1">{{ $carDetails->seat }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="details1">بيع - ايجار</p>
                    </div>
                    <div class="col">
                        <p class="details1">{{ $carDetails->rent == 1 ? 'ايجار' : 'بيع' }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="details1">السعر</p>
                    </div>
                    <div class="col">
                        <p class="details1">{{ $carDetails->price }} $</p>
                    </div>
                </div>
            </div>
            <h5>
                العنوان
            </h5>
            <div class="des-sec-1">
                {{-- <p class="description-details">{{ $carDetails->country->name .' - '. $carDetails->state->name .' - '. $carDetails->city->name }}</p>

                    <p class="description-details">{{ $carDetails->address }}</p> --}}
                @if ($carDetails->country_id != '')
                    @if ($carDetails->city_id != '' && $carDetails->state_id != '')
                        <p class="description-details">
                            {{ $carDetails->country->name . ' - ' . $carDetails->state->name . ' - ' . $carDetails->city->name }}
                        </p>
                        <p class="description-details">{{ $carDetails->address != '' ? $carDetails->address : '' }}
                        </p>
                    @elseif ($carDetails->state_id != '')
                        <p class="description-details">
                            {{ $carDetails->country->name . ' - ' . $carDetails->state->name }}
                        </p>
                        <p class="description-details">{{ $carDetails->address != '' ? $carDetails->address : '' }}
                        </p>
                    @else
                        <p class="description-details">{{ $carDetails->country->name }}</p>
                        <p class="description-details">{{ $carDetails->address != '' ? $carDetails->address : '' }}
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
                    <a href="https://wa.me/{{ $carDetails->phone }}" target="_blank" class="social-link">
                        <i class="fab fa-whatsapp"></i>{{ $carDetails->phone }}
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
        $('#SubmitFormCarProduct').on('submit', function(e) {
            e.preventDefault();
            let product_id = $('#product_id').val();
            let type = $('#type').val();
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
@endsection
