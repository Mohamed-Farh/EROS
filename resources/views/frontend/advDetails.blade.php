@extends('layouts.frontend_app')

@section('title', $advDetails->name)

@section('content')




    <div class="contain-sec py-4">

        @include('frontend.adv')

        <div class="gallery-buildings99 text-center">
            <div class="row">
                @foreach ($advDetails->media as $media)
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
                    <h4 class="title-1">{{ $advDetails->name }}</h4>
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
                                ->whereProductId($advDetails->id)
                                ->whereType('Adv')
                                ->first();
                        @endphp
                        <form id="SubmitFormAdv">
                            <input type="hidden" class="form-control" id="product_id" value="{{ $advDetails->id }}">
                            <input type="hidden" class="form-control" id="type" value="Adv">
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
                <p class="description-details">{{ $advDetails->category }}</p>
            </div>
            <h5>
                الوصف
            </h5>
            <div class="des-sec-1">
                <p class="description-details">{{ $advDetails->description }}</p>
            </div>
            <h5>
                التفاصيل
            </h5>
            <div class="des-sec-1">
                {{-- <div class="row">
                    <div class="col">
                        <p class="details1">تاريخ ب</p>
                    </div>
                    <div class="col">
                        <p class="details1">
                            {{ Carbon\Carbon::parse($advDetails->start_date)->format('Y-m-d') }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="details1">تاريخ الانتهاء</p>
                    </div>
                    <div class="col">
                        <p class="details1">
                            {{ Carbon\Carbon::parse($advDetails->end_date)->format('Y-m-d') }}</p>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col">
                        <p class="details1">مميز</p>
                    </div>
                    <div class="col">
                        <p class="details1">{{ $advDetails->feature == 1 ? 'مميز' : 'لا' }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="details1">السعر</p>
                    </div>
                    <div class="col">
                        <p class="details1">{{ $advDetails->price }} $</p>
                    </div>
                </div>
            </div>
            <h5>
                العنوان
            </h5>
            <div class="des-sec-1">
                @if ($advDetails->country_id != '')
                    @if ($advDetails->city_id != '' && $advDetails->state_id != '')
                        <p class="description-details">
                            {{ $advDetails->country->name . ' - ' . $advDetails->state->name . ' - ' . $advDetails->city->name }}
                        </p>
                        <p class="description-details">
                            {{ $advDetails->address != '' ? $advDetails->address : '' }}</p>
                    @elseif ($advDetails->state_id != '')
                        <p class="description-details">
                            {{ $advDetails->country->name . ' - ' . $advDetails->state->name }}</p>
                        <p class="description-details">
                            {{ $advDetails->address != '' ? $advDetails->address : '' }}</p>
                    @else
                        <p class="description-details">{{ $advDetails->country->name }}</p>
                        <p class="description-details">
                            {{ $advDetails->address != '' ? $advDetails->address : '' }}</p>
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
                    <a href="https://wa.me/{{ $advDetails->phone }}" target="_blank" class="social-link">
                        <i class="fab fa-whatsapp"></i>{{ $advDetails->phone }}
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
        $('#SubmitFormAdv').on('submit', function(e) {
            e.preventDefault();
            let product_id = $('#product_id').val();
            let type = $('#type').val();
            $.ajax({
                url: "{{ route('frontend.advLikeAndDislike') }}",
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
