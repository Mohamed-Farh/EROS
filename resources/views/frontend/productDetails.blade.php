@extends('layouts.frontend_app')

@section('title', $productDetails->name)

@section('content')

    <style>
        /* start gallery */
        /* The grid: Four equal columns that floats next to each other */
        .gallery-buildings99 .column {
            float: left;
            width: 25%;
            padding: 10px;
        }

        /* Style the images inside the grid */
        .gallery-buildings99 .column img {
            opacity: 0.8;
            cursor: pointer;
            height: auto;
        }

        .gallery-buildings99 .column img:hover {
            opacity: 1;
        }

        .gallery-buildings99 .column #expandedImg {
            width: 266px;
            height: 266px;
        }

        /* Clear floats after the columns */
        .gallery-buildings99 .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* The expanding image container */
        .gallery-buildings99 .container-99 {
            position: relative;
            display: none;
        }

        .gallery-buildings99 .container-99 #expandedImg {
            height: 210px;
            width: 250px;
        }

        /* Expanding image text */
        .gallery-buildings99 #imgtext {
            position: absolute;
            bottom: 15px;
            left: 15px;
            color: white;
            font-size: 20px;
        }

        /* Closable button inside the expanded image */
        .gallery-buildings99 .closebtn {
            position: absolute;
            top: 0;
            right: 50;
            color: white;
            font-size: 26px;
            cursor: pointer;
        }
        p {
            color: white;
        }

    </style>

    <!--begin::Content-->
    <div class="services py-4 text-center">
        <div class="container">
            <h5>{{ $productDetails->name }}</h5>
            <div class="row" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1500">
                <div class="contain-sec py-4">

                    <div class="gallery-buildings99 text-center">
                        <div class="row" style="    margin-right: 0px; margin-left: 0px;">
                            @foreach ($productDetails->media as $media)
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
                            </div>
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
                                    <p class="details1">مميز</p>
                                </div>
                                <div class="col">
                                    <p class="details1">{{ $productDetails->featured == 1 ? 'مميز' : 'لا' }}</p>
                                </div>
                            </div>
                            @if ($productDetails->quantity != '')
                                <div class="row">
                                    <div class="col">
                                        <p class="details1">الكمية</p>
                                    </div>
                                    <div class="col">
                                        <p class="details1">{{ $productDetails->quantity }}</p>
                                    </div>
                                </div>
                            @endif
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
                                <a href="https://wa.me/{{ $productDetails->phone }}" target="_blank"
                                    class="social-link">
                                    <i class="fab fa-whatsapp"></i>{{ $productDetails->phone }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Content-->




@endsection
@section('script')
    <script src="{{ asset('frontend/js/index.js') }}"></script>
@endsection
