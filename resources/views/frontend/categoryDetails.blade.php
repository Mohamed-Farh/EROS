@extends('layouts.frontend_app')

@section('title', $category->name)

@section('content')

<style>
    .about img {
        width: 100%;
        height: 400px;
        border-radius: 15px;
        border: 5px solid #f9b519;
        object-fit: unset;
    }
</style>
    <!-- start about -->
    <div class="about py-4 text-center">
        <div class="container">
            <h5 style="text-align: center;">{{ $category->name }}</h5>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
                    <img src="{{ asset($category->cover) }}" data-aos="flip-left" data-aos-easing="linear"
                        data-aos-duration="1500" class="responsive">
                </div>
            </div>
        </div>
    </div>
    <!-- end about -->

        <!-- start services -->
        <div class="services py-4 text-center">
            <div class="container">
                <h5>قائمة الخدمات المتاحة</h5>
                <div class="row" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1500">
                    @foreach ($products as $product)
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 mt-3">
                            <div class="image-services">
                                <img src="{{ asset($product->firstMedia->file_name) }}" alt="Avatar" class="image"
                                    style="width:100%">
                                <div class="middle">
                                    <div class="text"><a href="/categories/{{ $category->id }}">{{ $product->name }}</a></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="button-sec py-3">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
        <!-- end services -->


@endsection
