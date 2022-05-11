@extends('layouts.frontend_app')

@section('title', 'الخدمات')

@section('content')


    <!-- start services -->
    <div class="services py-4 text-center">
        <div class="container">
            <h5>الخدمات</h5>
            <!-- Start PageTile -->
            @php
                $pageTitles = \App\Models\PageTitle::whereStatus(1)
                    ->wherePage('الخدمات')
                    ->get();
            @endphp
            @if ($pageTitles->count() > 0)
                @foreach ($pageTitles as $pageTitle)
                    <p class="text-center" style="color:white; text-align: justify !important;">{{ $pageTitle->title }}</p>
                @endforeach
            @endif
            <!-- End PageTile -->

            <div class="row" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1500">

                @foreach ($categories as $category)
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 mt-3">
                        <div class="image-services">
                            <img src="{{ asset($category->cover) }}" alt="Avatar" class="image"
                                style="width:100%">
                            <div class="middle">
                                <div class="text"><a href="/categories/{{ $category->id }}">{{ $category->name }}</a></div>
                                {{-- <a href="/project-details/{{ $category->id }}">{{ $category->name }}</a> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="button-sec py-3">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
    <!-- end services -->


@endsection
