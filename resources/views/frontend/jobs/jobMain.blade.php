@extends('layouts.frontend_app')

@section('title', 'فرص عمل')

@section('content')

    <div class="contain-sec py-4">

        @include('frontend.adv')

        <div class="search-job">
            <div class="row start-containt-search ">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <form action="{{ route('frontend.jobCategorySearch') }}" method="Post">
                        @csrf
                        <input type="text" name="keyword" required>
                        <button type="submit" class="search-btn"> بحث</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!--begin::Content-->
    @forelse ($jobCategories as $jobCategory)
        <div class="buildings-ads">
            <div class="ads-building ">
                <div class="row">
                    <div class="col-6">
                        <div class="title-buildings">
                            <p class="title-link">
                                <a href="{{ route('frontend.jobs', ['jobCategory' => $jobCategory->id]) }}">
                                    {{ $jobCategory->name }}
                                </a>
                            </p>
                            <p class="advertisment-num">( {{ $jobCategory->jobs_count }} ) اعلان</p>
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
