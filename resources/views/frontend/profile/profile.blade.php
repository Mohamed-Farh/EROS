@extends('layouts.frontend_app')

@section('title', 'الحساب الشخصي')

@section('content')

<style>
    .input-booking {
        width: 70%;
        height: 42px;
        border: 1px solid #ebebeb;
        border-radius: 8px;
        box-shadow: 0px 0px 10px #dddddd;
        outline: none;
        margin: 0px 0px 15px;
    }
    label {
        margin: 14px 0px 0px 0px;
    }
    @media (min-width:320px) and (max-width:767px){
        .input-booking{
            width: 100%;
            margin: 10px 0px;
        }
    }
</style>
    <!--start profile info  -->
    <div class="profile-info py-4">
        <div class="container">
            <div class="upload-image1">
                <div class="upload-profile-pic py-4">
                    @if (auth()->user()->user_image != '')
                        <img src="{{ asset(auth()->user()->user_image) }}" class="profile-pic"
                            alt="{{ auth()->user()->full_name }}">
                    @else
                        <img src="{{ asset('frontend/images/94991421-black-happy-girls-icon-vector-woman-icon-illustration.jpg') }}"
                            class="profile-pic" alt="{{ auth()->user()->full_name }}">
                    @endif
                </div>
            </div>
            <div class="text-center">
                <div class="row">
                    <div class="col-12">
                        <input  value="{{ auth()->user()->full_name }}" class="input-booking" readonly placeholder="الاسم بالكامل">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <input  value="{{ auth()->user()->username }}" class="input-booking" readonly placeholder="اسم المستخدم">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <input  value="{{ auth()->user()->mobile }}" class="input-booking" readonly placeholder="رقم الهاتف" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <input  value="{{ auth()->user()->email }}" class="input-booking" readonly  placeholder="البريد الالكتروني">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        @if (auth()->user()->country_id != '')
                            @if (auth()->user()->city_id != '' && auth()->user()->state_id != '')
                                @php $address = auth()->user()->country->name .' - ' .auth()->user()->state->name .' - ' .auth()->user()->city->name @endphp
                            @elseif (auth()->user()->state_id != '')
                                @php $address = auth()->user()->country->name . ' - ' . auth()->user()->state->name @endphp
                            @else
                                @php $address = auth()->user()->country->name @endphp
                            @endif
                        @else
                            @php $address = 'العنوان' @endphp
                        @endif
                        <input  value="{{ $address }}" class="input-booking" readonly >
                    </div>
                </div>
            </div>


            <div class="btn-send text-center">
                <button onclick="location.href='{{ route('frontend.editProfile') }}'" class="edit-btn">تعديل بياناتي</button>
            </div>
            <div class="btn-send text-center">
                <button onclick="location.href='{{ route('frontend.editLocation') }}'" class="edit-btn">تعديل موقعي</button>
            </div>
            <div class="tow-btns text-center">
                <div class="row">
                    <div class="col">
                        <button onclick="myFunction1()" class="reviews-buttons">الصالح</button>
                    </div>
                    <div class="col">
                        <button name="answer" value="Show Div" onclick="myFunction2()"
                            class="reviews-buttons">المنتهي</button>
                    </div>
                </div>
            </div>
            <!--  -->
            <div class=" reviews-div ">
                <div class="container-msg-1 mb-3 mt-3  " id="myDIV1" style="display: none;">
                    @foreach ($bookings as $booking)
                        @if ($booking->day != date('Y-m-d') )
                            <div class="des-sec-1 notification-sec  menu-{{ $booking->id }}" id="close-div-{{ $booking->id }} ">
                                <button id='close ' class="close-ads-sec1 toggle-btn toggle-btn-{{ $booking->id }}">
                                    <i class="fas fa-times"></i>
                                </button>
                                <div class="notification-containt">
                                    <div class="media">
                                        @if ($booking->product_id != '')
                                            <img src="{{ asset($booking->product->firstMedia->file_name) }}" class="image-products-1" alt="...">
                                            <div class="media-body">
                                                <h5 class="mt-0">{{ $booking->product->name }}</h5>
                                                <p class="contact-details">{{ $booking->category->name }}</p>
                                                <p class="contact-details">{{ \Carbon\Carbon::parse($booking->day)->translatedFormat('l j F Y') }} - {{ date('h:i A', strtotime($booking->start)) }}</p>
                                                @if($booking->status == '1')
                                                    <p style="color:green">تمت الموافقة</p>
                                                @else
                                                    <p style="color:red">قائمة الانتظار</p>
                                                @endif
                                            </div>
                                        @else
                                            <img src="{{ asset($booking->category->cover) }}" class="image-products-1" alt="...">
                                            <div class="media-body">
                                                <h5 class="mt-0">{{ $booking->category->name }}</h5>
                                                <p class="contact-details">{{ \Carbon\Carbon::parse($booking->day)->translatedFormat('l j F Y') }} - {{ date('h:i A', strtotime($booking->start)) }}</p>
                                                @if($booking->status == '1')
                                                    <p style="color:green">تمت الموافقة</p>
                                                @else
                                                    <p style="color:red">قائمة الانتظار</p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @elseif ( $booking->day == date('Y-m-d') && (date('h:i A', strtotime($booking->start))) > date('h:i A', strtotime('+2 hours')) )
                            <div class="des-sec-1 notification-sec  menu-{{ $booking->id }}" id="close-div-{{ $booking->id }} ">
                                <button id='close ' class="close-ads-sec1 toggle-btn toggle-btn-{{ $booking->id }}">
                                    <i class="fas fa-times"></i>
                                </button>
                                <div class="notification-containt">
                                    <div class="media">
                                        @if ($booking->product_id != '')
                                            <img src="{{ asset($booking->product->firstMedia->file_name) }}" class="image-products-1" alt="...">
                                            <div class="media-body">
                                                <h5 class="mt-0">{{ $booking->product->name }}</h5>
                                                <p class="contact-details">{{ $booking->category->name }}</p>
                                                <p class="contact-details">{{ \Carbon\Carbon::parse($booking->day)->translatedFormat('l j F Y') }} - {{ date('h:i A', strtotime($booking->start)) }}</p>
                                                @if($booking->status == '1')
                                                    <p style="color:green">تمت الموافقة</p>
                                                @else
                                                    <p style="color:red">قائمة الانتظار</p>
                                                @endif
                                            </div>
                                        @else
                                            <img src="{{ asset($booking->category->cover) }}" class="image-products-1" alt="...">
                                            <div class="media-body">
                                                <h5 class="mt-0">{{ $booking->category->name }}</h5>
                                                <p class="contact-details">{{ \Carbon\Carbon::parse($booking->day)->translatedFormat('l j F Y') }} - {{ date('h:i A', strtotime($booking->start)) }}</p>
                                                @if($booking->status == '1')
                                                    <p style="color:green">تمت الموافقة</p>
                                                @else
                                                    <p style="color:red">قائمة الانتظار</p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="description-div">
                <div class="container-msg-1 mb-3 mt-3  text-center " id="myDIV2" style="display:none;" class="answer_list">
                    @foreach ($finishedBookings as $booking)
                        <div class=" notification-sec  menu-{{ $booking->id }}" id="close-div-{{ $booking->id }} ">
                            <button id='close ' class="close-ads-sec1 toggle-btn toggle-btn-{{ $booking->id }}">
                                <i class="fas fa-times"></i>
                            </button>
                            <div class="notification-containt">
                                <div class="media">
                                    @if ($booking->product_id != '')
                                        @if ($booking->day < date('Y-m-d') )
                                            <img src="{{ asset($booking->product->firstMedia->file_name) }}" class="image-products-1" alt="...">
                                            <div class="media-body">
                                                <h5 class="mt-0">{{ $booking->product->name }}</h5>
                                                <p class="contact-details">{{ $booking->category->name }}</p>
                                                <p class="contact-details">{{ \Carbon\Carbon::parse($booking->day)->translatedFormat('l j F Y') }} - {{ date('h:i A', strtotime($booking->start)) }}</p>
                                            </div>
                                        @elseif ( $booking->day == date('Y-m-d') && (date('h:i A', strtotime($booking->start))) < date('h:i A', strtotime('+2 hours')) )
                                            <img src="{{ asset($booking->product->firstMedia->file_name) }}" class="image-products-1" alt="...">
                                            <div class="media-body">
                                                <h5 class="mt-0">{{ $booking->product->name }}</h5>
                                                <p class="contact-details">{{ $booking->category->name }}</p>
                                                <p class="contact-details">{{ \Carbon\Carbon::parse($booking->day)->translatedFormat('l j F Y') }} - {{ date('h:i A', strtotime($booking->start)) }}</p>
                                            </div>
                                        @endif
                                    @else
                                        @if ($booking->day < date('Y-m-d') )
                                            <img src="{{ asset($booking->category->cover) }}" class="image-products-1" alt="...">
                                            <div class="media-body">
                                                <h5 class="mt-0">{{ $booking->category->name }}</h5>
                                                <p class="contact-details">{{ \Carbon\Carbon::parse($booking->day)->translatedFormat('l j F Y') }} - {{ date('h:i A', strtotime($booking->start)) }}</p>
                                            </div>
                                        @elseif ( $booking->day == date('Y-m-d') && (date('h:i A', strtotime($booking->start))) < date('h:i A', strtotime('+2 hours')) )
                                            <img src="{{ asset($booking->category->cover) }}" class="image-products-1" alt="...">
                                            <div class="media-body">
                                                <h5 class="mt-0">{{ $booking->category->name }}</h5>
                                                <p class="contact-details">{{ \Carbon\Carbon::parse($booking->day)->translatedFormat('l j F Y') }} - {{ date('h:i A', strtotime($booking->start)) }}</p>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!--  -->
        </div>
    </div>
    <!--end profile info  -->

@endsection
@section('script')
    <script src="{{ asset('frontend/js/popper.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/js/js.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.js') }}"></script>
@endsection
