@extends('layouts.frontend_app')

@section('title', 'طقس')

@section('content')

    <div class="contain-sec py-4">

        <!--begin::Content-->
        <div class="container-jobs text-right  mt-5">
            <div class="weather-img-sec text-center">
                <div class="cuurent-weather text-center">

                    {{-- ######  This Is Best One ########### --}}
                    <div id="ww_e34c3c6c4660c" v='1.20' loc='auto' a='{"t":"responsive","lang":"en","ids":["wl4455"],"cl_bkg":"image","cl_font":"#FFFFFF","cl_cloud":"#FFFFFF","cl_persp":"#81D4FA","cl_sun":"#FFC107","cl_moon":"#FFC107","cl_thund":"#FF5722","sl_tof":"7","sl_sot":"celsius","sl_ics":"one_a","font":"Arial"}'><a href="https://weatherwidget.org/" id="ww_e34c3c6c4660c_u" target="_blank" hidden>HTML Weather widget for website by Weatherwidget.org</a></div><script async src="https://srv2.weatherwidget.org/js/?id=ww_e34c3c6c4660c"></script>

                </div>

            </div>
        </div>
        <!--end::Content-->

    </div>
@endsection
