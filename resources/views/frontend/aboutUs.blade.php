@extends('layouts.frontend_app')

@section('title', 'من نحن')

@section('content')

    <!-- start about -->
    <div class="about py-4 text-center">
        <div class="container">
            <h5></h5>
            @foreach ($abouts as $about)
                @if (($loop->index + 1) % 2 != 0)
                    <div class="row" style="margin-right: 0px; margin-left: 0px;">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-3">
                            <h6 class="text-right" data-aos="flip-right" data-aos-easing="ease-out-cubic" style="color: #f9b519"
                                data-aos-duration="2000">{{ $about->title }}
                            </h6>
                            <br>
                            <p data-aos="flip-right" data-aos-easing="linear" data-aos-duration="1500">{{ $about->text }}</p>
                        </div>

                        @if ($about->video != '')
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-3"
                                style="background: white;border-radius: 13px;" data-aos="flip-right">
                                <iframe width="100%" height="90%" src="{{ $about->video }}"
                                        frameborder="0" allowfullscreen style="padding-top: 20px;"></iframe>
                            </div>
                        @else
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-3">
                                <img src="{{ asset($about->image) }}" data-aos="flip-left" data-aos-easing="linear"
                                    data-aos-duration="1500" />
                            </div>
                        @endif
                    </div>
                @else
                    <div class="row" style="margin-right: 0px; margin-left: 0px;">
                        @if ($about->video != '')
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-3"
                                style="background: white;border-radius: 13px;" data-aos="flip-right">
                                <iframe width="100%" height="90%" src="{{ $about->video }}"
                                        frameborder="0" allowfullscreen style="padding-top: 20px;"></iframe>
                            </div>
                        @else
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-3">
                                <img src="{{ asset($about->image) }}" data-aos="flip-left" data-aos-easing="linear"
                                    data-aos-duration="1500" />
                            </div>
                        @endif
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-3">
                            <h6 class="text-right" data-aos="flip-right" data-aos-easing="ease-out-cubic" style="color: #f9b519"
                                data-aos-duration="2000">{{ $about->title }}
                            </h6>
                            <br>
                            <p data-aos="flip-right" data-aos-easing="linear" data-aos-duration="1500">{{ $about->text }}</p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <!-- end about -->


@endsection

