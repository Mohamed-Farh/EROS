<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet"href='{{ asset('frontend/fontawesome/css/all.min.css') }}'>
<link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">

<title>بوابتك | @yield('title')</title>
{{-- <title>@yield('title') | بوابتك </title> --}}
<link rel="shortcut icon" href="{{ asset('frontend/images/4FARH_Logo.png') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
    button.likeAndUnlike {
        border: unset !important;
        background: unset !important;
        max-inline-size: -webkit-fill-available;
    }
    .slider-sec img {
        width: 100%;
        height: 100%;
    }
</style>
