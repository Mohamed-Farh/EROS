@extends('layouts.frontend_app')

@section('title', 'مواعيد الصلاة')

@section('content')

    <style>
        select#cid {
            border-radius: 10px !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        select#ciid {
            border-radius: 10px !important;
            width: 100% !important;
            max-width: 100% !important;
        }

    </style>
    <div class="contain-sec py-4">
        <div class="container-jobs py-4 ">

            <div class="prayer-image text-center">
                <img src="{{ asset('frontend/images/d1bf485045fc2ba77a3c2cfb50e0ce59.png') }}" />
            </div>
            <div class="praer-times py-2 text-center">
                {{-- Without Sound --}}
                {{-- <iframe
                    src="https://timesprayer.com/widgets.php?frame=2&amp;lang=en&amp;name=salt&amp;avachang=true&amp;time=0"
                    style="border: none; overflow: hidden; width: 100%; height: 275px;"></iframe> --}}

                <iframe
                    src="https://timesprayer.com/widgets.php?frame=2&amp;lang=en&amp;name=salt&amp;sound=true&amp;avachang=true&amp;fcolor=B4DBD5&amp;tcolor=25A1A1&amp;frcolor=000000"
                    style="border: none; overflow: hidden; width: 100%; height: 275px;"></iframe>

                {{-- <iframe
                    src="https://timesprayer.com/widgets.php?frame=2&amp;lang=en&amp;name=salt&amp;sound=true&amp;avachang=true&amp;fcolor=64D9E8&amp;tcolor=25A1A1&amp;frcolor=000000"
                    style="border: none; overflow: hidden; width: 100%; height: 275px;"></iframe> --}}



                {{-- With Sound --}}
                {{-- <iframe
                    src="https://timesprayer.com/widgets.php?frame=2&amp;lang=en&amp;name=salt&amp;sound=true&amp;avachang=true&amp;time=0"
                    style="border: none; overflow: hidden; width: 100%; height: 275px;" __idm_id__="1531906"></iframe> --}}
            </div>
        </div>
    </div>
@endsection
