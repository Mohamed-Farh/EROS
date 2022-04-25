@extends('layouts.frontend_app')

@section('title', 'حول التطبيق')

@section('content')


    <style>
        element.style {}

        .container-jobs {
            background: whitesmoke;
            border-radius: 6px;
            margin-top: 16%;
            padding: 0px 20px 0px 0px;
        }

    </style>
    <div class="contain-sec py-4">

        @include('frontend.adv')

        <!--begin::Content-->
        <div class="container-jobs text-right py-4 ">
            <h4 class="about-title">حول التطبيق</h4>
            {!! $about->about !!}
        </div>
        <div class="map-sec py-2">
            <h4 class="about-title text-right">تواصل معنا</h4>
            <div class="social-media-icons ">
                @php
                    $socials = \App\Models\SocialMedia::whereStatus(1)
                        ->orderBy('id', 'desc')
                        ->get();
                    $whats = \App\Models\Phone::whereType('WhatsApp')
                        ->whereStatus(1)
                        ->orderBy('id', 'desc')
                        ->get();
                    $phones = \App\Models\Phone::whereType('Phone')
                        ->whereStatus(1)
                        ->orderBy('id', 'desc')
                        ->get();
                    $emails = \App\Models\Email::whereStatus(1)
                        ->orderBy('id', 'desc')
                        ->get();

                @endphp
                @foreach ($socials as $social)
                    <a href="{{ $social->link }}" target="_blank">
                        <img src="{{ asset('images/icon/' . $social->type) . '.png' }}" width="95%">
                    </a>
                @endforeach
            </div>
        </div>
        <!--end::Content-->

    </div>
@endsection
