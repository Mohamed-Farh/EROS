@extends('layouts.frontend_app')

@section('title', $carProduct->name)

@section('content')

    <!-- Custom styles for this template-->
    <link href="{{ asset('backend/vendor/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">


    <style>
        .addForm {
            border-radius: 30px;
        }

        .contain-sec input {
            width: 100% !important;
        }

        input.file-caption-name.form-control.kv-fileinput-caption {
            width: 50% !important;
        }

        input.file-caption-name.form-control.kv-fileinput-caption {
            border-radius: 30px !important;
        }

        select.form-control.addForm {
            width: 100% !important;
        }

        textarea.form-control.addForm {
            width: 100%;
            border-radius: 30px;
        }

    </style>

    <div class="contain-sec py-4 ">
        <div class="row py-2 start-containt-search">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">

            </div>
        </div>


        <div class="description-sec py-3">
            <!-- Add Car-->
            <form action="{{ route('frontend.profileUpdateCar', ['id' => $carProduct]) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="add-buildings-ads-sec py-4 text-center">
                    <h4 class="text-center pb-3">{{ $carProduct->name }}</h4>
                    <div class="upload-image-gallery">
                        <div class="row">
                            <div class="col-12">
                                <input type="file" name="images[]" id="carProduct_images" class="file-input-overview"
                                    multiple="multiple">
                                @error('images')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-2">
                            <input type="text" name="name" value="{{ old('name', $carProduct->name) }}"
                                placeholder="اسم السيارة" class="form-control addForm" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mt-2">
                            <select name="car_category_id" class="form-control addForm" style="font-size: 0.8rem;" required>
                                <option value="">اختر القسم</option>
                                @forelse (\App\Models\CarCategory::whereStatus('1')->get(['id', 'name']) as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('car_category_id', $carProduct->car_category_id) == $category->id ? 'selected' : null }}>
                                        {{ $category->name }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                            @error('car_category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mt-2">
                            <select name="rent" class="form-control addForm">
                                <option value="1" {{ old('rent', $carProduct->rent) == 1 ? 'selected' : null }}>ايجار
                                </option>
                                <option value="0" {{ old('rent', $carProduct->rent) == 0 ? 'selected' : null }}>بيع
                                </option>
                            </select>
                            @error('rent')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mt-2">
                            <input type="number" name="price" value="{{ old('price', $carProduct->price) }}"
                                placeholder="السعر" class="form-control addForm" required>
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mt-2">
                            <select name="car_type_id" class="form-control addForm" required>
                                <option value="">اختر الماركة</option>
                                @forelse (\App\Models\CarType::whereStatus(1)->get(['id', 'name']) as $carType)
                                    <option value="{{ $carType->id }}"
                                        {{ old('car_type_id', $carProduct->car_type_id) == $carType->id ? 'selected' : null }}>
                                        {{ $carType->name }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                            @error('car_type_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mt-2">
                            <input type="text" name="year" value="{{ old('year', $carProduct->year) }}"
                                placeholder="سنة الاصدار" class="form-control addForm" id="datepicker" required>
                            <script>
                                $("#datepicker").datepicker({
                                    format: "yyyy",
                                    viewMode: "years",
                                    minViewMode: "years",
                                    autoclose: true
                                });
                            </script>
                            @error('year')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mt-2">
                            <input type="text" name="color" value="{{ old('color', $carProduct->color) }}"
                                placeholder="اللون" class="form-control addForm" required>
                            @error('color')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mt-2">
                            <select name="manual" class="form-control addForm">
                                <option value="1" {{ old('manual', $carProduct->manual) == 1 ? 'selected' : null }}>عادي
                                </option>
                                <option value="0" {{ old('manual', $carProduct->manual) == 0 ? 'selected' : null }}>
                                    اوتوماتيك</option>
                            </select>
                            @error('manual')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mt-2">
                            <input distance="text" name="distance" value="{{ old('distance', $carProduct->distance) }}"
                                placeholder="المسافة التي قطعتها" class="form-control addForm" required>
                            @error('distance')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mt-2">
                            <input type="text" name="motor" value="{{ old('motor', $carProduct->motor) }}"
                                class="form-control addForm" placeholder="حالة الموتور" required>
                            @error('motor')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mt-2">
                            <input type="text" name="sound" value="{{ old('sound', $carProduct->sound) }}"
                                class="form-control addForm" placeholder="الصوت" required>
                            @error('sound')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mt-2">
                            <input type="number" name="seat" value="{{ old('seat', $carProduct->seat) }}"
                                class="form-control addForm" min="0" placeholder="عدد المقاعد" required>
                            @error('seat')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mt-2">
                            <textarea name="description" rows="5" class="form-control addForm addForm" placeholder="وصف السيارة"
                                required>{!! old('description', $carProduct->description) !!}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-4">
                            <select name="country_id" placeholder="" id="country_id" class="form-control addForm"
                                style="font-size: 0.8rem;">
                                <option value="">كل الدول</option>
                                @forelse (\App\Models\Country::get(['id', 'name']) as $country)
                                    <option value="{{ $country->id }}"
                                        {{ old('country_id', $carProduct->country_id) == $country->id ? 'selected' : null }}>
                                        {{ $country->name }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                            @error('country_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-4">
                            <select name="state_id" id="state_id" class="form-control addForm" style="font-size: 0.8rem;">
                            </select>
                            @error('state_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-4">
                            <select name="city_id" id="city_id" class="form-control addForm" style="font-size: 0.8rem;">
                            </select>
                            @error('city_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-2">
                            <textarea name="address" rows="3" placeholder="عنوان العقار بالتفصيل" class="form-control addForm"
                                required>{!! old('address', $carProduct->address) !!}</textarea>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="contact-sec-ads py-2">
                        <h6>للتواصل</h6>
                        <div class="row mt-1">
                            <div class="col-12">
                                <input type="text" name="phone" value="{{ old('phone', $carProduct->phone) }}"
                                    placeholder="رقم الهاتف او الواتس" required>
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="send-btn">
                        <button type="submit">تحديث البيانات</button>
                    </div>
                </div>
            </form>

        </div>
    </div>


@endsection
@section('script')
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('backend/vendor/bootstrap-fileinput/js/plugins/piexif.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap-fileinput/js/plugins/sortable.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap-fileinput/themes/fas/theme.min.js') }}"></script>

    <script>
        $(function() {
            $('#carProduct_images').fileinput({
                theme: "fas",
                maxFileCount: {{ 10 - $carProduct->media->count() }},
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @if ($carProduct->media->count() > 0)
                        @foreach ($carProduct->media as $media)
                            "{{ asset($media->file_name) }}",
                        @endforeach
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($carProduct->media->count() > 0)
                        @foreach ($carProduct->media as $media)
                            {
                            caption: "{{ $media->file_name }}",
                            size: {{ $media->file_size }},
                            width: "120px",
                            url:
                            "{{ route('frontend.carRemoveImage', ['image_id' => $media->id,'carProduct_id' => $carProduct->id,'_token' => csrf_token()]) }}",
                            key: "{{ $media->id }}"
                            },
                        @endforeach
                    @endif
                ],
                // on('filesorted', function(event, params){
                //     console;log
                // })
            });
        });
    </script>

    <script>
        $(function() {
            populateStates();
            populateCities();

            $("#country_id").change(function() {
                populateStates();
                populateCities();
                return false;
            });

            $("#state_id").change(function() {
                populateCities();
                return false;
            });

            function populateStates() {
                let countryIdVal = $('#country_id').val() != null ? $('#country_id').val() :
                    '{{ old('country_id', $carProduct->country_id) }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('frontend.frontGetState') }}", {
                    country_id: countryIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#state_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#state_id').append($('<option></option>').val('').html('---'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id ==
                            '{{ old('state_id', $carProduct->state_id) }}' ? "selected" : "";
                        $("#state_id").append($('<option ' + selectedVal + '></option>').val(text
                            .id).html(text.name));
                    });
                }, "json")

            }

            function populateCities() {
                let stateIdVal = $('#state_id').val() != null ? $('#state_id').val() :
                    '{{ old('state_id', $carProduct->state_id) }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('frontend.frontGetCity') }}", {
                    state_id: stateIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#city_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#city_id').append($('<option></option>').val('').html('---'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id ==
                            '{{ old('city_id', $carProduct->city_id) }}' ? "selected" : "";
                        $("#city_id").append($('<option ' + selectedVal + '></option>').val(text.id)
                            .html(text.name));
                    });
                }, "json")
            }

        });
    </script>
@endsection
