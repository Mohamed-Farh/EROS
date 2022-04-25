@extends('layouts.frontend_app')

@section('title', $productDetails->name)

@section('content')

    <!--begin::Content-->
    <div class="contain-sec py-4">

        @include('frontend.adv')

        <div class="gallery-buildings99 text-center">
            <div class="row">
                @foreach ($productDetails->media as $media)
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
                    <h4 class="title-1">{{ $productDetails->name }}</h4>
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
                                ->whereProductId($productDetails->id)
                                ->whereType('Product')
                                ->first();
                        @endphp
                        <form id="SubmitFormProduct">
                            <input type="hidden" class="form-control" id="product_id" value="{{ $productDetails->id }}">
                            <input type="hidden" class="form-control" id="type" value="Product">
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
                <p class="description-details">{{ $productDetails->category->name }}</p>
            </div>
            <h5>
                الوصف
            </h5>
            <div class="des-sec-1">
                <p class="description-details">{{ $productDetails->description }}</p>
            </div>
            <h5>
                التفاصيل
            </h5>
            <div class="des-sec-1">
                <div class="row">
                    <div class="col">
                        <p class="details1">تاريخ الانتاج</p>
                    </div>
                    <div class="col">
                        <p class="details1">
                            {{ Carbon\Carbon::parse($productDetails->start_date)->format('Y-m-d') }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="details1">تاريخ الانتهاء</p>
                    </div>
                    <div class="col">
                        <p class="details1">
                            {{ Carbon\Carbon::parse($productDetails->end_date)->format('Y-m-d') }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="details1">مميز</p>
                    </div>
                    <div class="col">
                        <p class="details1">{{ $productDetails->feature == 1 ? 'مميز' : 'لا' }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="details1">السعر</p>
                    </div>
                    <div class="col">
                        <p class="details1">{{ $productDetails->price }} $</p>
                    </div>
                </div>
            </div>
            <h5>
                العنوان
            </h5>
            <div class="des-sec-1">
                {{-- @if ($productDetails->country_id != '')
                        <p class="description-details">{{ $productDetails->country->name .' - '. $productDetails->state->name .' - '. $productDetails->city->name }}</p>
                        <p class="description-details">{{ $productDetails->address }}</p>
                    @else
                        <p class="description-details">{{__('كل الدول') }}</p>
                    @endif --}}
                @if ($productDetails->country_id != '')
                    @if ($productDetails->city_id != '' && $productDetails->state_id != '')
                        <p class="description-details">
                            {{ $productDetails->country->name . ' - ' . $productDetails->state->name . ' - ' . $productDetails->city->name }}
                        </p>
                        <p class="description-details">
                            {{ $productDetails->address != '' ? $productDetails->address : '' }}</p>
                    @elseif ($productDetails->state_id != '')
                        <p class="description-details">
                            {{ $productDetails->country->name . ' - ' . $productDetails->state->name }}</p>
                        <p class="description-details">
                            {{ $productDetails->address != '' ? $productDetails->address : '' }}</p>
                    @else
                        <p class="description-details">{{ $productDetails->country->name }}</p>
                        <p class="description-details">
                            {{ $productDetails->address != '' ? $productDetails->address : '' }}</p>
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
                    <a href="https://wa.me/{{ $productDetails->phone }}" target="_blank" class="social-link">
                        <i class="fab fa-whatsapp"></i>{{ $productDetails->phone }}
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
        $('#SubmitFormProduct').on('submit', function(e) {
            e.preventDefault();
            let product_id = $('#product_id').val();
            let type = $('#type').val();
            $.ajax({
                url: "{{ route('frontend.productLikeAndDislike') }}",
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
