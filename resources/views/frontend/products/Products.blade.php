@extends('layouts.frontend_app')

@section('title', $category->name)

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
                <form action="{{ route('frontend.productSearch') }}" method="Post">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <input type="hidden" name="category" value="{{ $category->id }}">

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
        @forelse ($products as $product)
            <div class="buildings-ads py-2 ">
                <div class="ads-building ">
                    <div class="row ">
                        <div class="col-4">
                            <a href="{{ route('frontend.productDetails', ['product' => $product]) }}">
                                @if ($product->firstMedia)
                                    <img class="rounded" src="{{ asset($product->firstMedia->file_name) }}"
                                        width="90" height="60" alt="{{ $product->name }}">
                                @else
                                    <img class="rounded" src="{{ asset('assets/no_image.png') }}" width="60"
                                        height="90" alt="{{ $product->name }}">
                                @endif
                            </a>
                        </div>
                        <div class="col-8">
                            <div class="row text-right">
                                <div class="col-10">
                                    <div id="outer">
                                        <div class="button_slide slide_left show-details-btn" style="width: 95%;">
                                            <a href="{{ route('frontend.productDetails', ['product' => $product]) }}"
                                                style="font-size: 12px;">
                                                {{ $product->name }}
                                            </a>
                                        </div>
                                        <p style="color: blue;"><span>{{ $product->category->name }}</span></p>
                                        <p style="color: red;"><span>{{ $product->price }} $</span></p>
                                        <p style="color: red;"><span>{{ $product->feature == 1 ? 'مميز' : '' }}</span>
                                        </p>
                                        <p style="font-size: 12px;">
                                            @if ($product->country_id != '')
                                                @if ($product->city_id != '' && $product->state_id != '')
                                                    {{ $product->country->name . ' - ' . $product->state->name . ' - ' . $product->city->name }}
                                                @elseif ($product->state_id != '')
                                                    {{ $product->country->name . ' - ' . $product->state->name }}
                                                @else
                                                    {{ $product->country->name }}
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
                                                ->whereProductId($product->id)
                                                ->whereType('Product')
                                                ->first();
                                        @endphp
                                        <form id="SubmitFormProduct_{{ $product->id }}">
                                            <input type="hidden" class="form-control" id="product_id{{ $product->id }}"
                                                value="{{ $product->id }}">
                                            <input type="hidden" class="form-control" id="type{{ $product->id }}"
                                                value="Product">
                                            <button type="submit" class="likeAndUnlike"><i
                                                    class="like-button {{ !empty($isLike) ? 'fa fa-heart liked' : 'fa fa-heart-o not-liked' }}"></i></button>
                                        </form>
                                        <script type="text/javascript">
                                            $('#SubmitFormProduct_{{ $product->id }}').on('submit', function(e) {
                                                e.preventDefault();
                                                let product_id = $('#product_id{{ $product->id }}').val();
                                                let type = $('#type{{ $product->id }}').val();
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
