<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    @include('layouts.frontend.head')
    @yield('style')
    
</head>

<body>
    <div class="bawabtouk-sec">
        <div class="container">
            @include('layouts.frontend.navbar')

            @yield('content')

        </div>
    </div>


    @include('layouts.frontend.footer_script')
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
    @yield('script')

</body>

</html>
