<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no" />

<meta name="csrf-token" content="{{ csrf_token() }}">
<title>EROS | @yield('title')</title>
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('frontend/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('frontend/favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('frontend/site.webmanifest') }}">
<link rel="mask-icon" href="{{ asset('frontend/safari-pinned-tab.svg') }}" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">

<link rel="stylesheet"href='{{ asset('frontend/fontawesome/css/all.min.css') }}'>
<link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.css') }}">

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">

{{-- <style>
    p {
    color: white !important;
    text-decoration: none;
    font-size: 15px !important;
}
</style> --}}
