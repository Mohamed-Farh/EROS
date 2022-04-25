@extends('layouts.frontend_app')

@section('title', 'الحساب الشخصي')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="{{ asset('frontend/js/jquery-3.6.0.min.js') }}"></script>

    <div class="contain-sec py-4">
        <div class="container-jobs py-2 ">
            <div class="image-profile py-3 text-center">
                @if (auth()->user()->user_image != '')
                    <img src="{{ asset(auth()->user()->user_image) }}" alt="{{ auth()->user()->full_name }}">
                @else
                    <img src="{{ asset('frontend/images/94991421-black-happy-girls-icon-vector-woman-icon-illustration.jpg') }}"
                        alt="{{ auth()->user()->full_name }}">
                @endif
            </div>
            <div class="personal-info text-center py-2">
                <p>{{ auth()->user()->username }}</p>
                <p>{{ auth()->user()->full_name }}</p>
                <p>{{ auth()->user()->email }}</p>
                <p>{{ auth()->user()->mobile }}</p>
                @if ($userAddress && $userAddress->country_id != '')
                    @if ($userAddress->city_id != '' && $userAddress->state_id != '')
                        <p>{{ $userAddress->country->name . ' - ' . $userAddress->state->name . ' - ' . $userAddress->city->name }}<i
                                class="fas fa-map-marker-alt"></i></p>
                    @elseif ($userAddress->state_id != '')
                        <p>{{ $userAddress->country->name . ' - ' . $userAddress->state->name }}<i
                                class="fas fa-map-marker-alt"></i></p>
                    @else
                        <p>{{ $userAddress->country->name }}<i class="fas fa-map-marker-alt"></i></p>
                    @endif
                @endif
            </div>
            <div class=" row exchange-btn profile-btns-edit text-center mt-4 ">
                <div class="col-sx-12 col-sm-12 col-md-12 col-lg-12">
                    <button onclick="location.href='{{ route('frontend.editProfile') }}'">تعديل بياناتي</button>
                </div>
                <div class="col-sx-12 col-sm-12 col-md-12 col-lg-12 mt-1">
                    <button onclick="location.href='{{ route('frontend.editLocation') }}'">تعديل موقعي</button>
                </div>
                <div class="col-sx-12 col-sm-12 col-md-12 col-lg-12 mt-1">
                    <button class="my-history-btn">اعلاناتي</button>
                </div>
            </div>
        </div>


        @php
            $userAdvs = \App\Models\Adv::whereStatus('1')
                ->whereUserId(auth()->user()->id)
                ->get();
            $userBuildings = \App\Models\BuildingProduct::whereStatus('1')
                ->whereUserId(auth()->user()->id)
                ->get();
            $userCars = \App\Models\CarProduct::whereStatus('1')
                ->whereUserId(auth()->user()->id)
                ->get();
            $userProducts = \App\Models\Product::whereStatus('1')
                ->whereUserId(auth()->user()->id)
                ->get();
            $userMedicals = \App\Models\Medical::whereStatus('1')
                ->whereUserId(auth()->user()->id)
                ->get();
            $userJobs = \App\Models\Job::whereStatus('1')
                ->whereUserId(auth()->user()->id)
                ->get();
        @endphp

        {{-- User Adv --}}
        @if ($userAdvs)
            @foreach ($userAdvs as $userAdv)
                <div class="my-all-hestory-{{ $userAdv->id }}" style="display: none;">
                    <div class="hestory-sec">
                        <div class="des-sec-1 notification-sec  hest-{{ $userAdv->id }} " id="close-div-1">
                            <button id='close '
                                class="close-ads-sec1 toggle-btn toggle-btn-1 hest-btn-{{ $userAdv->id }}">
                                <i class="fas fa-times"></i>
                            </button>
                            <div class="notification-containt py-2 m-2">
                                <div class="media">
                                    <a href="{{ route('frontend.advDetails', ['advProduct' => $userAdv]) }}">
                                        @if ($userAdv->firstMedia)
                                            <img src="{{ asset($userAdv->firstMedia->file_name) }}"
                                                class="image-products-1" alt="{{ $userAdv->name }}">
                                        @else
                                            <img src="{{ asset('assets/no_image.png') }}" class="image-products-1"
                                                alt="{{ $userAdv->name }}">
                                        @endif
                                    </a>
                                    <div class="media-body">
                                        <h5 class="mt-0"><a
                                                href="{{ route('frontend.advDetails', ['advProduct' => $userAdv]) }}">{{ $userAdv->name }}</a>
                                        </h5>
                                        <h5 class="mt-0"><a>القسم : الاعلانات</a></h5>
                                        <p class="contact-details">
                                            <a href="https://wa.me/{{ $userAdv->phone }}" target="_blank">
                                                <i class="fab fa-whatsapp"></i>{{ $userAdv->phone }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    // remove my hestory
                    $(document).ready(function() {
                        $(".hest-btn-{{ $userAdv->id }}").click(function() {
                            $(".hest-{{ $userAdv->id }}").hide(2000);
                        });
                        $(".my-history-btn").click(function() {
                            $(".my-all-hestory-{{ $userAdv->id }}").toggle(2000);
                        });
                    });
                </script>
            @endforeach
        @endif

        {{-- User Building Products --}}
        @if ($userBuildings)
            @foreach ($userBuildings as $buildingProduct)
                <div class="my-all-hestory-buildingProduct{{ $buildingProduct->id }}" style="display: none;">
                    <div class="hestory-sec">
                        <div class="des-sec-1 notification-sec  hest-buildingProduct{{ $buildingProduct->id }} "
                            id="close-div-1">
                            <div class="row">
                                <div class="col text-right">
                                    <a href="{{ route('frontend.profileEditBuilding', ['id' => $buildingProduct]) }}"
                                        class="edit btn btn-info btn-sm"><i class="fas fa-edit"></i>
                                    </a>
                                </div>
                                <div class="col text-left">
                                    <button id='close '
                                        class="close-ads-sec1 toggle-btn toggle-btn-1 hest-btn-buildingProduct{{ $buildingProduct->id }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="notification-containt py-2 m-2">
                                <div class="media">
                                    <a
                                        href="{{ route('frontend.buildingDetails', ['buildingProduct' => $buildingProduct]) }}">
                                        @if ($buildingProduct->firstMedia)
                                            <img src="{{ asset($buildingProduct->firstMedia->file_name) }}"
                                                class="image-products-1" alt="{{ $buildingProduct->name }}">
                                        @else
                                            <img src="{{ asset('assets/no_image.png') }}" class="image-products-1"
                                                alt="{{ $buildingProduct->name }}">
                                        @endif
                                    </a>
                                    <div class="media-body">
                                        <h5 class="mt-0"><a
                                                href="{{ route('frontend.buildingDetails', ['buildingProduct' => $buildingProduct]) }}">{{ $buildingProduct->name }}</a>
                                        </h5>
                                        <h5 class="mt-0"><a>القسم : العقارات</a></h5>
                                        <p class="contact-details">
                                            <a href="https://wa.me/{{ $buildingProduct->phone }}" target="_blank">
                                                <i class="fab fa-whatsapp"></i>{{ $buildingProduct->phone }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    // remove my hestory
                    $(document).ready(function() {
                        $(".hest-btn-buildingProduct{{ $buildingProduct->id }}").click(function() {
                            $(".hest-buildingProduct{{ $buildingProduct->id }}").hide(2000);
                        });
                        $(".my-history-btn").click(function() {
                            $(".my-all-hestory-buildingProduct{{ $buildingProduct->id }}").toggle(2000);
                        });
                    });
                </script>
            @endforeach
        @endif

        {{-- User Car Products --}}
        @if ($userCars)
            @foreach ($userCars as $carProduct)
                <div class="my-all-hestory-carProduct{{ $carProduct->id }}" style="display: none;">
                    <div class="hestory-sec">
                        <div class="des-sec-1 notification-sec  hest-carProduct{{ $carProduct->id }} " id="close-div-1">
                            <div class="row">
                                <div class="col text-right">
                                    <a href="{{ route('frontend.profileEditCar', ['id' => $carProduct]) }}"
                                        class="edit btn btn-info btn-sm"><i class="fas fa-edit"></i>
                                    </a>
                                </div>
                                <div class="col text-left">
                                    <button id='close '
                                        class="close-ads-sec1 toggle-btn toggle-btn-1 hest-btn-carProduct{{ $carProduct->id }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="notification-containt py-2 m-2">
                                <div class="media">
                                    <a href="{{ route('frontend.carDetails', ['carProduct' => $carProduct]) }}">
                                        @if ($carProduct->firstMedia)
                                            <img src="{{ asset($carProduct->firstMedia->file_name) }}"
                                                class="image-products-1" alt="{{ $carProduct->name }}">
                                        @else
                                            <img src="{{ asset('assets/no_image.png') }}" class="image-products-1"
                                                alt="{{ $carProduct->name }}">
                                        @endif
                                    </a>
                                    <div class="media-body">
                                        <h5 class="mt-0"><a
                                                href="{{ route('frontend.carDetails', ['carProduct' => $carProduct]) }}">{{ $carProduct->name }}</a>
                                        </h5>
                                        <h5 class="mt-0"><a>القسم : السيارات</a></h5>
                                        <p class="contact-details"><a href="https://wa.me/{{ $carProduct->phone }}"
                                                target="_blank"><i
                                                    class="fab fa-whatsapp"></i>{{ $carProduct->phone }}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    // remove my hestory
                    $(document).ready(function() {
                        $(".hest-btn-carProduct{{ $carProduct->id }}").click(function() {
                            $(".hest-carProduct{{ $carProduct->id }}").hide(2000);
                        });
                        $(".my-history-btn").click(function() {
                            $(".my-all-hestory-carProduct{{ $carProduct->id }}").toggle(2000);
                        });
                    });
                </script>
            @endforeach
        @endif

        {{-- User Products --}}
        @if ($userProducts)
            @foreach ($userProducts as $product)
                <div class="my-all-hestory-product{{ $product->id }}" style="display: none;">
                    <div class="hestory-sec">
                        <div class="des-sec-1 notification-sec  hest-product{{ $product->id }} " id="close-div-1">
                            <div class="row">
                                <div class="col text-right">
                                    <a href="{{ route('frontend.profileEditProduct', ['id' => $product]) }}"
                                        class="edit btn btn-info btn-sm"><i class="fas fa-edit"></i>
                                    </a>
                                </div>
                                <div class="col text-left">
                                    <button id='close '
                                        class="close-ads-sec1 toggle-btn toggle-btn-1 hest-btn-product{{ $product->id }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="notification-containt py-2 m-2">
                                <div class="media">
                                    <a href="{{ route('frontend.productDetails', ['product' => $product]) }}">
                                        @if ($product->firstMedia)
                                            <img src="{{ asset($product->firstMedia->file_name) }}"
                                                class="image-products-1" alt="{{ $product->name }}">
                                        @else
                                            <img src="{{ asset('assets/no_image.png') }}" class="image-products-1"
                                                alt="{{ $product->name }}">
                                        @endif
                                    </a>
                                    <div class="media-body">
                                        <h5 class="mt-0"><a
                                                href="{{ route('frontend.productDetails', ['product' => $product]) }}">{{ $product->name }}</a>
                                        </h5>
                                        <h5 class="mt-0"><a>القسم : المنتجات</a></h5>
                                        <p class="contact-details"><a href="https://wa.me/{{ $product->phone }}"
                                                target="_blank"><i class="fab fa-whatsapp"></i>{{ $product->phone }}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    // remove my hestory
                    $(document).ready(function() {
                        $(".hest-btn-product{{ $product->id }}").click(function() {
                            $(".hest-product{{ $product->id }}").hide(2000);
                        });
                        $(".my-history-btn").click(function() {
                            $(".my-all-hestory-product{{ $product->id }}").toggle(2000);
                        });
                    });
                </script>
            @endforeach
        @endif

        {{-- User Medical Products --}}
        @if ($userMedicals)
            @foreach ($userMedicals as $medical)
                <div class="my-all-hestory-medical{{ $medical->id }}" style="display: none;">
                    <div class="hestory-sec">
                        <div class="des-sec-1 notification-sec  hest-medical{{ $medical->id }} " id="close-div-1">
                            <div class="row">
                                <div class="col text-right">
                                    @if ($medical->medical_type != 'Medicine')
                                        <a href="{{ route('frontend.profileEditMedicalDoctor', ['id' => $medical]) }}"
                                            class="edit btn btn-info btn-sm"><i class="fas fa-edit"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('frontend.profileEditMedicalMedicine', ['id' => $medical]) }}"
                                            class="edit btn btn-info btn-sm"><i class="fas fa-edit"></i>
                                        </a>
                                    @endif
                                </div>
                                <div class="col text-left">
                                    <button id='close '
                                        class="close-ads-sec1 toggle-btn toggle-btn-1 hest-btn-medical{{ $medical->id }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="notification-containt py-2 m-2">
                                <div class="media">
                                    <a href="{{ route('frontend.medicalDetails', ['medical' => $medical->id]) }}">
                                        <img src="{{ asset('images/medicalImage.png') }}" class="image-products-1"
                                            alt="{{ $medical->name }}">
                                    </a>
                                    <div class="media-body">
                                        <h5 class="mt-0"><a
                                                href="{{ route('frontend.medicalDetails', ['medical' => $medical->id]) }}">{{ $medical->name }}</a>
                                        </h5>
                                        <h5 class="mt-0"><a>القسم : خدمات طبية</a></h5>
                                        <p class="contact-details"><a href="https://wa.me/{{ $medical->phone }}"
                                                target="_blank"><i class="fab fa-whatsapp"></i>{{ $medical->phone }}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    // remove my hestory
                    $(document).ready(function() {
                        $(".hest-btn-medical{{ $medical->id }}").click(function() {
                            $(".hest-medical{{ $medical->id }}").hide(2000);
                        });
                        $(".my-history-btn").click(function() {
                            $(".my-all-hestory-medical{{ $medical->id }}").toggle(2000);
                        });
                    });
                </script>
            @endforeach
        @endif

        {{-- User Jobs --}}
        @if ($userJobs)
            @foreach ($userJobs as $job)
                <div class="my-all-hestory-job{{ $job->id }}" style="display: none;">
                    <div class="hestory-sec">
                        <div class="des-sec-1 notification-sec  hest-job{{ $job->id }} " id="close-div-1">
                            <div class="row">
                                <div class="col text-right">
                                    <a href="{{ route('frontend.profileEditJob', ['id' => $job]) }}"
                                        class="edit btn btn-info btn-sm"><i class="fas fa-edit"></i>
                                    </a>
                                </div>
                                <div class="col text-left">
                                    <button id='close '
                                        class="close-ads-sec1 toggle-btn toggle-btn-1 hest-btn-job{{ $job->id }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="notification-containt py-2 m-2">
                                <div class="media">
                                    <a href="{{ route('frontend.jobDetails', ['job' => $job->id]) }}">
                                        <img src="{{ asset('images/job.png') }}" class="image-products-1"
                                            alt="{{ $medical->name }}">
                                    </a>
                                    <div class="media-body">
                                        <h5 class="mt-0"><a
                                                href="{{ route('frontend.jobDetails', ['job' => $job->id]) }}">{{ $job->name }}</a>
                                        </h5>
                                        <h5 class="mt-0"><a>القسم : الوظائف</a></h5>
                                        <p class="contact-details"><a href="https://wa.me/{{ $job->phone }}"
                                                target="_blank"><i class="fab fa-whatsapp"></i>{{ $job->phone }}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    // remove my hestory
                    $(document).ready(function() {
                        $(".hest-btn-job{{ $job->id }}").click(function() {
                            $(".hest-job{{ $job->id }}").hide(2000);
                        });
                        $(".my-history-btn").click(function() {
                            $(".my-all-hestory-job{{ $job->id }}").toggle(2000);
                        });
                    });
                </script>
            @endforeach
        @endif
    </div>




@endsection
@section('script')
    <script src="{{ asset('frontend/js/index.js') }}"></script>
@endsection
