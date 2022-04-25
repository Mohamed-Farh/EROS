<!-- navbar-->
<section class="top-nav">
    <div class="navbar-sec">
        <div class="hamburger-menu">
            <div class="logo-link">
                <p><a href="{{ route('frontend.index') }}">بوابتك</a></p>
            </div>
            <input id="menu__toggle" type="checkbox" />
            <label class="menu__btn" for="menu__toggle">
                <span></span>
            </label>

            <ul class="menu__box text-right">
                <li>
                    <a class="menu__item" href="{{ route('frontend.index') }}">
                        <i class="fas fa-home mr-1 text-gray"></i>&nbsp;
                        الرئيسية
                    </a>
                </li>
                @guest
                    <li>
                        <a class="menu__item" href="{{ route('login') }}">
                            <i class="fas fa-user-alt mr-1 text-gray"></i>&nbsp;
                            تسجيل دخول
                        </a>
                    </li>
                @endguest
                @auth
                    <li>
                        <a class="menu__item" href="{{ route('frontend.profile') }}">
                            <i class="fas fa-user-circle mr-1 text-gray"></i>&nbsp;
                            الحساب الشخصي
                        </a>
                    </li>
                @endauth
                <li>
                    <a class="menu__item" href="{{ route('frontend.addPage') }}">
                        <i class="fas fa-plus-circle mr-1 text-gray"></i>&nbsp;
                        اضافة
                    </a>
                </li>
                <li>
                    <a class="menu__item" href="{{ route('frontend.likes') }}">
                        <i class="fas fa-shopping-cart mr-1 text-gray"></i>&nbsp;
                        المفضلة
                    </a>
                </li>
                {{-- <li>
                    <a class="menu__item" href="notifications.html">
                        <i class="fas fa-bell mr-1 text-gray"></i>&nbsp;
                        الاشعارات
                    </a>
                </li> --}}
                {{-- <li>
                    <a class="menu__item" href="setting.html">
                        <i class="fas fa-tools mr-1 text-gray"></i>&nbsp;
                        الاعدادات
                    </a>
                </li> --}}
                <li>
                    <a class="menu__item" href="{{ route('frontend.about') }}">
                        <i class="fas fa-info-circle mr-1 text-gray"></i>&nbsp;
                        حول التطبيق
                    </a>
                </li>
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
    </div>
</section>
