@extends('layouts.frontend_app')

@section('title', 'المفضلة')

@section('content')


    <script src="{{ asset('frontend/js/jquery-3.6.0.min.js') }}"></script>



    <div class="contain-sec py-4 ">

        {{-- @include('frontend.adv') --}}
        <div class="row py-2 start-containt-search">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            </div>
        </div>


        <div class="description-sec py-3">
            <h4 class="title-1">المفضلة</h4>

            @foreach ($userLikes as $userLike)
                <!-- Adv Product -->
                @if ($userLike->type == 'Adv')
                    @php
                        $adv = \App\Models\Adv::whereStatus('1')
                            ->whereUserId(auth()->user()->id)
                            ->whereId($userLike->product_id)
                            ->first();
                    @endphp
                    <div class="des-sec-1 notification-sec  menu-adv-{{ $adv->id }}"
                        id="close-div-adv-{{ $adv->id }}">
                        <div class="row">
                            <div class="col text-right">
                                <button id='close ' class="close-ads-sec1 toggle-btn toggle-btn-adv-{{ $adv->id }}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="col text-left">
                                @php
                                    $isLike = \App\Models\Like::whereUserId(auth()->user()->id)
                                        ->whereProductId($adv->id)
                                        ->whereType('Adv')
                                        ->first();
                                @endphp
                                <form id="SubmitFormAdv{{ $adv->id }}">
                                    <input type="hidden" class="form-control" id="product_id{{ $adv->id }}"
                                        value="{{ $adv->id }}">
                                    <input type="hidden" class="form-control" id="type{{ $adv->id }}"
                                        value="Adv">
                                    <button type="submit" class="likeAndUnlike"><i
                                            class="like-button {{ !empty($isLike) ? 'fa fa-heart liked' : 'fa fa-heart-o not-liked' }}"></i></button>
                                </form>
                                <script type="text/javascript">
                                    $('#SubmitFormAdv{{ $adv->id }}').on('submit', function(e) {
                                        e.preventDefault();
                                        let product_id = $('#product_id{{ $adv->id }}').val();
                                        let type = $('#type{{ $adv->id }}').val();
                                        $.ajax({
                                            url: "{{ route('frontend.advLikeAndDislike') }}",
                                            type: "POST",
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                product_id: product_id,
                                                type: type,
                                            },
                                            success: function(response) {
                                                $('#successMsg').show();
                                                console.log(response);
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="notification-containt">
                            <div class="media">
                                <a href="{{ route('frontend.advDetails', ['advProduct' => $adv]) }}">
                                    @if ($adv->firstMedia)
                                        <img src="{{ asset($adv->firstMedia->file_name) }}" class="image-products-1"
                                            alt="{{ $adv->name }}">
                                    @else
                                        <img src="{{ asset('images/adv.png') }}" class="image-products-1"
                                            alt="{{ $adv->name }}">
                                    @endif
                                </a>
                                <div class="media-body">
                                    <h5 class="mt-0">
                                        <a
                                            href="{{ route('frontend.advDetails', ['advProduct' => $adv]) }}">{{ $adv->name }}</a>
                                    </h5>
                                    <h5 class="mt-0"><a>القسم : الاعلانات</a></h5>
                                    <p class="contact-details">
                                        <a href="https://wa.me/{{ $adv->phone }}" target="_blank">
                                            <i class="fab fa-whatsapp"></i>{{ $adv->phone }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $(".toggle-btn-adv-{{ $adv->id }}").click(function() {
                                $(".menu-adv-{{ $adv->id }}").hide(2000);
                            });
                        });
                    </script>
                @endif

                <!-- Building Product & DisLike  -->
                @if ($userLike->type == 'BuildingProduct')
                    @php
                        $building = \App\Models\BuildingProduct::whereStatus('1')
                            ->whereUserId(auth()->user()->id)
                            ->whereId($userLike->product_id)
                            ->first();
                    @endphp
                    <div class="des-sec-1 notification-sec  menu-building-{{ $building->id }}"
                        id="close-div-building-{{ $building->id }}">
                        <div class="row">
                            <div class="col text-right">
                                <button id='close '
                                    class="close-ads-sec1 toggle-btn toggle-btn-building-{{ $building->id }}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="col text-left">
                                @php
                                    $isLike = \App\Models\Like::whereUserId(auth()->user()->id)
                                        ->whereProductId($building->id)
                                        ->whereType('BuildingProduct')
                                        ->first();
                                @endphp
                                <form id="SubmitForm{{ $building->id }}">
                                    <input type="hidden" class="form-control" id="product_id{{ $building->id }}"
                                        value="{{ $building->id }}">
                                    <input type="hidden" class="form-control" id="type{{ $building->id }}"
                                        value="BuildingProduct">
                                    <button type="submit" class="likeAndUnlike"><i
                                            class="like-button {{ !empty($isLike) ? 'fa fa-heart liked' : 'fa fa-heart-o not-liked' }}"></i></button>
                                </form>
                                <script type="text/javascript">
                                    $('#SubmitForm{{ $building->id }}').on('submit', function(e) {
                                        e.preventDefault();
                                        let product_id = $('#product_id{{ $building->id }}').val();
                                        let type = $('#type{{ $building->id }}').val();
                                        $.ajax({
                                            url: "{{ route('frontend.buildingLikeAndDislike') }}",
                                            type: "POST",
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                product_id: product_id,
                                                type: type,
                                            },
                                            success: function(response) {
                                                $('#successMsg').show();
                                                console.log(response);
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="notification-containt">
                            <div class="media">
                                <a href="{{ route('frontend.buildingDetails', ['buildingProduct' => $building]) }}">
                                    @if ($building->firstMedia)
                                        <img src="{{ asset($building->firstMedia->file_name) }}" class="image-products-1"
                                            alt="{{ $building->name }}">
                                    @else
                                        <img src="{{ asset('images/building.png') }}" class="image-products-1"
                                            alt="{{ $building->name }}">
                                    @endif
                                </a>
                                <div class="media-body">
                                    <h5 class="mt-0">
                                        <a
                                            href="{{ route('frontend.buildingDetails', ['buildingProduct' => $building]) }}">{{ $building->name }}</a>
                                    </h5>
                                    <h5 class="mt-0"><a>القسم : العقارات</a></h5>
                                    <p class="contact-details">
                                        <a href="https://wa.me/{{ $building->phone }}" target="_blank">
                                            <i class="fab fa-whatsapp"></i>{{ $building->phone }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $(".toggle-btn-building-{{ $building->id }}").click(function() {
                                $(".menu-building-{{ $building->id }}").hide(2000);
                            });
                        });
                    </script>
                @endif

                <!-- Car Product & DisLike  -->
                @if ($userLike->type == 'CarProduct')
                    @php
                        $car = \App\Models\CarProduct::whereStatus('1')
                            ->whereUserId(auth()->user()->id)
                            ->whereId($userLike->product_id)
                            ->first();
                    @endphp
                    <div class="des-sec-1 notification-sec  menu-car-{{ $car->id }}"
                        id="close-div-car-{{ $car->id }}">
                        <div class="row">
                            <div class="col text-right">
                                <button id='close ' class="close-ads-sec1 toggle-btn toggle-btn-car-{{ $car->id }}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="col text-left">
                                @php
                                    $carProduct = $car;
                                    $isLike = \App\Models\Like::whereUserId(auth()->user()->id)
                                        ->whereProductId($carProduct->id)
                                        ->whereType('CarProduct')
                                        ->first();
                                @endphp
                                <form id="SubmitFormCar_{{ $carProduct->id }}">
                                    <input type="hidden" class="form-control" id="product_id{{ $carProduct->id }}"
                                        value="{{ $carProduct->id }}">
                                    <input type="hidden" class="form-control" id="type{{ $carProduct->id }}"
                                        value="CarProduct">
                                    <button type="submit" class="likeAndUnlike"><i
                                            class="like-button {{ !empty($isLike) ? 'fa fa-heart liked' : 'fa fa-heart-o not-liked' }}"></i></button>
                                </form>
                                <script type="text/javascript">
                                    $('#SubmitFormCar_{{ $carProduct->id }}').on('submit', function(e) {
                                        e.preventDefault();
                                        let product_id = $('#product_id{{ $carProduct->id }}').val();
                                        let type = $('#type{{ $carProduct->id }}').val();
                                        $.ajax({
                                            url: "{{ route('frontend.carLikeAndDislike') }}",
                                            type: "POST",
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                product_id: product_id,
                                                type: type,
                                            },
                                            success: function(response) {
                                                $('#successMsg').show();
                                                console.log(response);
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="notification-containt">
                            <div class="media">
                                <a href="{{ route('frontend.carDetails', ['carProduct' => $car]) }}">
                                    @if ($car->firstMedia)
                                        <img src="{{ asset($car->firstMedia->file_name) }}" class="image-products-1"
                                            alt="{{ $car->name }}">
                                    @else
                                        <img src="{{ asset('images/car.png') }}" class="image-products-1"
                                            alt="{{ $car->name }}">
                                    @endif
                                </a>
                                <div class="media-body">
                                    <h5 class="mt-0">
                                        <a
                                            href="{{ route('frontend.carDetails', ['carProduct' => $car]) }}">{{ $car->name }}</a>
                                    </h5>
                                    <h5 class="mt-0"><a>القسم : السيارات</a></h5>
                                    <p class="contact-details">
                                        <a href="https://wa.me/{{ $car->phone }}" target="_blank">
                                            <i class="fab fa-whatsapp"></i>{{ $car->phone }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $(".toggle-btn-car-{{ $car->id }}").click(function() {
                                $(".menu-car-{{ $car->id }}").hide(2000);
                            });
                        });
                    </script>
                @endif

                <!-- Product & DisLike  -->
                @if ($userLike->type == 'Product')
                    @php
                        $product = \App\Models\Product::whereStatus('1')
                            ->whereUserId(auth()->user()->id)
                            ->whereId($userLike->product_id)
                            ->first();
                    @endphp
                    <div class="des-sec-1 notification-sec  menu-product-{{ $product->id }}"
                        id="close-div-product-{{ $product->id }}">
                        <div class="row">
                            <div class="col text-right">
                                <button id='close '
                                    class="close-ads-sec1 toggle-btn toggle-btn-product-{{ $product->id }}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="col text-left">
                                @php
                                    $isLike = \App\Models\Like::whereUserId(auth()->user()->id)
                                        ->whereProductId($product->id)
                                        ->whereType('Product')
                                        ->first();
                                @endphp
                                <form id="SubmitFormProduct_{{ $product->id }}">
                                    <input type="hidden" class="form-control" id="product_id{{ $product->id }}"
                                        value="{{ $product->id }}">
                                    <input type="hidden" class="form-control" id="type{{ $product->id }}"
                                        value="Product">
                                    <button type="submit" class="likeAndUnlike"><i
                                            class="like-button {{ !empty($isLike) ? 'fa fa-heart liked' : 'fa fa-heart-o not-liked' }}"></i></button>
                                </form>
                                <script type="text/javascript">
                                    $('#SubmitFormProduct_{{ $product->id }}').on('submit', function(e) {
                                        e.preventDefault();
                                        let product_id = $('#product_id{{ $product->id }}').val();
                                        let type = $('#type{{ $product->id }}').val();
                                        $.ajax({
                                            url: "{{ route('frontend.productLikeAndDislike') }}",
                                            type: "POST",
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                product_id: product_id,
                                                type: type,
                                            },
                                            success: function(response) {
                                                $('#successMsg').show();
                                                console.log(response);
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>


                        <div class="notification-containt">
                            <div class="media">
                                <a href="{{ route('frontend.productDetails', ['product' => $product]) }}">
                                    @if ($product->firstMedia)
                                        <img src="{{ asset($product->firstMedia->file_name) }}" class="image-products-1"
                                            alt="{{ $product->name }}">
                                    @else
                                        <img src="{{ asset('images/product.png') }}" class="image-products-1"
                                            alt="{{ $product->name }}">
                                    @endif
                                </a>
                                <div class="media-body">
                                    <h5 class="mt-0">
                                        <a
                                            href="{{ route('frontend.productDetails', ['product' => $product]) }}">{{ $product->name }}</a>
                                    </h5>
                                    <h5 class="mt-0"><a>القسم : المنتجات</a></h5>
                                    <p class="contact-details">
                                        <a href="https://wa.me/{{ $product->phone }}" target="_blank">
                                            <i class="fab fa-whatsapp"></i>{{ $product->phone }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $(".toggle-btn-product-{{ $product->id }}").click(function() {
                                $(".menu-product-{{ $product->id }}").hide(2000);
                            });
                        });
                    </script>
                @endif

                <!-- Medical & DisLike   -->
                @if ($userLike->type == 'MedicalProduct')
                    @php
                        $medical = \App\Models\Medical::whereStatus('1')
                            ->whereUserId(auth()->user()->id)
                            ->whereId($userLike->product_id)
                            ->first();
                    @endphp
                    <div class="des-sec-1 notification-sec  menu-medical-{{ $medical->id }}"
                        id="close-div-medical-{{ $medical->id }}">
                        <div class="row">
                            <div class="col text-right">
                                <button id='close '
                                    class="close-ads-sec1 toggle-btn toggle-btn-medical-{{ $medical->id }}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="col text-left">
                                @php
                                    $isLike = \App\Models\Like::whereUserId(auth()->user()->id)
                                        ->whereProductId($medical->id)
                                        ->whereType('MedicalProduct')
                                        ->first();
                                @endphp
                                <form id="SubmitFormMedical_{{ $medical->id }}">
                                    <input type="hidden" class="form-control" id="product_id{{ $medical->id }}"
                                        value="{{ $medical->id }}">
                                    <input type="hidden" class="form-control" id="type{{ $medical->id }}"
                                        value="MedicalProduct">
                                    <button type="submit" class="likeAndUnlike"><i
                                            class="like-button {{ !empty($isLike) ? 'fa fa-heart liked' : 'fa fa-heart-o not-liked' }}"></i></button>
                                </form>
                                <script type="text/javascript">
                                    $('#SubmitFormMedical_{{ $medical->id }}').on('submit', function(e) {
                                        e.preventDefault();
                                        let product_id = $('#product_id{{ $medical->id }}').val();
                                        let type = $('#type{{ $medical->id }}').val();
                                        $.ajax({
                                            url: "{{ route('frontend.medicalLikeAndDislike') }}",
                                            type: "POST",
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                product_id: product_id,
                                                type: type,
                                            },
                                            success: function(response) {
                                                $('#successMsg').show();
                                                console.log(response);
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="notification-containt">
                            <div class="media">
                                <a href="{{ route('frontend.medicalDetails', ['medical' => $medical->id]) }}">
                                    @if ($medical->firstMedia)
                                        <img src="{{ asset($medical->firstMedia->file_name) }}" class="image-products-1"
                                            alt="{{ $medical->name }}">
                                    @else
                                        <img src="{{ asset('images/medical.png') }}" class="image-products-1"
                                            alt="{{ $medical->name }}">
                                    @endif
                                </a>
                                <div class="media-body">
                                    <h5 class="mt-0">
                                        <a
                                            href="{{ route('frontend.medicalDetails', ['medical' => $medical->id]) }}">{{ $medical->name }}</a>
                                    </h5>
                                    <h5 class="mt-0"><a>القسم : خدمات طبية</a></h5>
                                    <p class="contact-details">
                                        <a href="https://wa.me/{{ $medical->phone }}" target="_blank">
                                            <i class="fab fa-whatsapp"></i>{{ $medical->phone }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $(".toggle-btn-medical-{{ $medical->id }}").click(function() {
                                $(".menu-medical-{{ $medical->id }}").hide(2000);
                            });
                        });
                    </script>
                @endif

                <!-- Job  & DisLike -->
                @if ($userLike->type == 'JobProduct')
                    @php
                        $job = \App\Models\Job::whereStatus('1')
                            ->whereUserId(auth()->user()->id)
                            ->whereId($userLike->product_id)
                            ->first();
                    @endphp
                    <div class="des-sec-1 notification-sec  menu-job-{{ $job->id }}"
                        id="close-div-job-{{ $job->id }}">
                        <div class="row">
                            <div class="col text-right">
                                <button id='close ' class="close-ads-sec1 toggle-btn toggle-btn-job-{{ $job->id }}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="col text-left">
                                @php
                                    $isLike = \App\Models\Like::whereUserId(auth()->user()->id)
                                        ->whereProductId($job->id)
                                        ->whereType('JobProduct')
                                        ->first();
                                @endphp
                                <form id="SubmitFormJob_{{ $job->id }}">
                                    <input type="hidden" class="form-control" id="product_id{{ $job->id }}"
                                        value="{{ $job->id }}">
                                    <input type="hidden" class="form-control" id="type{{ $job->id }}"
                                        value="JobProduct">
                                    <button type="submit" class="likeAndUnlike"><i
                                            class="like-button {{ !empty($isLike) ? 'fa fa-heart liked' : 'fa fa-heart-o not-liked' }}"></i></button>
                                </form>
                                <script type="text/javascript">
                                    $('#SubmitFormJob_{{ $job->id }}').on('submit', function(e) {
                                        e.preventDefault();
                                        let product_id = $('#product_id{{ $job->id }}').val();
                                        let type = $('#type{{ $job->id }}').val();
                                        $.ajax({
                                            url: "{{ route('frontend.jobLikeAndDislike') }}",
                                            type: "POST",
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                product_id: product_id,
                                                type: type,
                                            },
                                            success: function(response) {
                                                $('#successMsg').show();
                                                console.log(response);
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="notification-containt">
                            <div class="media">
                                <a href="{{ route('frontend.jobDetails', ['job' => $job->id]) }}">
                                    @if ($job->firstMedia)
                                        <img src="{{ asset($job->firstMedia->file_name) }}" class="image-products-1"
                                            alt="{{ $job->name }}">
                                    @else
                                        <img src="{{ asset('images/job.png') }}" class="image-products-1"
                                            alt="{{ $job->name }}">
                                    @endif
                                </a>
                                <div class="media-body">
                                    <h5 class="mt-0">
                                        <a
                                            href="{{ route('frontend.jobDetails', ['job' => $job->id]) }}">{{ $job->name }}</a>
                                    </h5>
                                    <h5 class="mt-0"><a>القسم : الوظائف</a></h5>
                                    <p class="contact-details">
                                        <a href="https://wa.me/{{ $job->phone }}" target="_blank">
                                            <i class="fab fa-whatsapp"></i>{{ $job->phone }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $(".toggle-btn-job-{{ $job->id }}").click(function() {
                                $(".menu-job-{{ $job->id }}").hide(2000);
                            });
                        });
                    </script>
                @endif
            @endforeach

        </div>
    </div>



@endsection
@section('script')
    <script src="{{ asset('frontend/js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('frontend/js/index.js') }}"></script>

@endsection
