<!-- start footer -->

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
$locations = \App\Models\Location::whereStatus(1)
    ->orderBy('id', 'desc')
    ->get();
@endphp

<div class="footer py-4 text-center">
    <div class="line-2 mt-2 mb-2">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <h5>روابط مختصرة</h5>
                        <ul>
                            <li><a href="{{ route('frontend.index') }}">الرئيسية</a></li>
                            <li><a href="{{ route('frontend.about-us') }}"> من نحن</a></li>
                            <li><a href="{{ route('frontend.categories') }}"> الخدمات</a></li>
                            <li><a href="{{ route('frontend.contact-us') }}"> اتصل بنا</a></li>
                        </ul>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <h5>التواصل</h5>
                        <ul>
                            @foreach ($emails as $email)
                                <li style="color: white"><i class="fas fa-envelope"></i>{{ $email->email }}</li>
                            @endforeach

                            @foreach ($phones as $phone)
                                <li style="color: white">
                                    <i class="fas fa-phone-alt"></i> {{ $phone->number }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <img src="{{ asset('frontend/images/Capture.PNG') }}" />
                @php
                    $pageTitles = \App\Models\PageTitle::whereStatus(1)
                        ->wherePage('Footer')
                        ->get();
                @endphp
                @if ($pageTitles->count() > 0)
                    @foreach ($pageTitles as $pageTitle)
                        <p>{{ $pageTitle->title }}</p>
                    @endforeach
                @endif
                <!-- End PageTile -->

                @foreach ($socials as $social)
                    <a href="{{ $social->link }}" target="_blank">
                        <img src="{{ asset('images/icon/' . $social->type) . '.png' }}"
                            style="width: 40px; height: 40px;">
                    </a>
                @endforeach
                @foreach ($whats as $what)
                    <a href="https://wa.me/{{ $what->number }}" target="_blank" class="social-link">
                        <img src="{{ asset('images/icon/' . $what->type) . '.png' }}"
                            style="width: 40px; height: 40px;">
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="line-2 mt-2 mb-2">
    </div>
</div>
<!-- end footer -->

<!-- start copyright -->
<div class="copyright ">
    <div class="container">
        <p>Eros Copyright 2022 - All Rights Reserved</p>
    </div>
</div>
<!-- end copyright -->
