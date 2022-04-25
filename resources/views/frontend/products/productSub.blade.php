@extends('layouts.frontend_app')

@section('title', $category->name)

@section('content')



    <div class="contain-sec">

        @include('frontend.adv')


        <div class="container-jobs  ">
            <div class="row start-containt-search py-3">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <form action="{{ route('frontend.productCategorySubSearch') }}" method="Post">
                        @csrf
                        <input type="hidden" name="category" value="{{ $category->id }}">
                        <input type="text" name="keyword" required>
                        <button type="submit" class="search-btn"> بحث</button>
                    </form>
                </div>
            </div>

            <!--begin::Content-->
            <div class="row mt-3">
                @forelse ($productCategories as $productCategory)
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="container-medical-services">
                            @if ($productCategory->cover)
                                <img src="{{ asset($productCategory->cover) }}" alt="{{ $productCategory->name }}"
                                    class="image">
                            @else
                                <img src="{{ asset('assets/no_image.png') }}" alt="{{ $product->name }}"
                                    class="image">
                            @endif
                            <div class="middle">
                                <div class="text">
                                    <a href="{{ route('frontend.products', ['productCategory' => $productCategory]) }}"
                                        style="color: white;">
                                        {{ $productCategory->name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="container-medical-services text-center">
                            <h6>عفوا لا بوجد بيانات متاحة حاليا</h6>
                        </div>
                    </div>
                @endforelse
            </div>
            <!--end::Content-->
        </div>
    </div>

@endsection
