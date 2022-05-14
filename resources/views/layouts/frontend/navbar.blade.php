<!-- start nav -->
<div class="navbar-sec">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('frontend.index') }}">
            @php
                $logo = \App\Models\Logo::whereStatus(1)->first();
            @endphp
            @if ($logo)
                <img src="{{ asset($logo->logo) }}" />
            @else
                <img src="{{ asset('frontend/images/Capture.PNG') }}" />
            @endif
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('frontend.index') }}">الرئيسية <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('frontend.about-us') }}">من نحن</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('frontend.categories') }}">الخدمات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('frontend.booking') }}">حجز موعد</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('frontend.contact-us') }}">اتصل بنا</a>
                </li>
            </ul>
            @guest
                <div class="row">
                    <div class="col">
                        <a href="#" class="nav-link" class="btn btn-info btn-lg" data-toggle="modal"
                            data-target="#myModalSignIn">تسجيل الدخول</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <a href="#" class="nav-link" class="btn btn-info btn-lg" data-toggle="modal"
                            data-target="#myModalSignUp">انشاء حساب</a>
                    </div>
                </div>
            @endguest
            @auth
                <div class="row">
                    <div class="col">
                        <a class="nav-link" href="{{ route('frontend.profile') }}">
                            <i class="fas fa-user-circle mr-1 text-gray"></i>&nbsp;
                            الحساب الشخصي
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <a href="javascript:void(0);" class="menu__item" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();" style="color: white">
                            <i class="fas fa-sign-out-alt mr-1 text-gray"></i>&nbsp;
                            تسجيل خروج
                        </a>
                        <form method="POST" action="{{ route('logout') }}" id="logout-form"
                            class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </nav>
</div>

@php
    $whats = \App\Models\Phone::whereType('WhatsApp')
        ->whereStatus(1)
        ->latest()
        ->first();
@endphp
<!-- end nav -->
<a href="https://wa.me/{{ $whats->number }}" class="float1" target="_blank">
    <i class="fab fa-whatsapp my-float1"></i>
</a>



{{-- <!-- navbar-->
<div class="navbar-sec">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('frontend.index') }}"><img
                src="{{ asset('frontend/images/Capture.PNG') }}" /></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('frontend.index') }}">الرئيسية <span
                            class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('frontend.about') }}">من نخن</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="services.html">الخدمات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="booking.html">حجز موعد</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.html">اتصل بنا</a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-user-alt mr-1 text-gray"></i>&nbsp;
                            تسجيل دخول
                        </a>
                    </li>
                @endguest
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('frontend.profile') }}">
                            <i class="fas fa-user-circle mr-1 text-gray"></i>&nbsp;
                            الحساب الشخصي
                        </a>
                    </li>
                @endauth
                @auth
                    <li>
                        <a href="javascript:void(0);" class="menu__item" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt mr-1 text-gray"></i>&nbsp;
                            تسجيل خروج
                        </a>
                        <form method="POST" action="{{ route('logout') }}" id="logout-form"
                            class="d-none">
                            @csrf
                        </form>
                    </li>
                @endauth


            </ul>
        </div>
    </nav>
</div>

<a href="#" class="float1" target="_blank">
    <i class="fab fa-whatsapp my-float1"></i>
</a> --}}
