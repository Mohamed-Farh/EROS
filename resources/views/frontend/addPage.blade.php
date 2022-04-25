@extends('layouts.frontend_app')

@section('title', 'اضافة')

@section('content')

    <!-- bootstrap 5.x or 4.x is supported. You can also use the bootstrap css 3.3.x versions -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
        crossorigin="anonymous">

    <!-- default icons used in the plugin are from Bootstrap 5.x icon library (which can be enabled by loading CSS below) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css"
        crossorigin="anonymous">

    <!-- alternatively you can use the font awesome icon library if using with `fas` theme (or Bootstrap 4.x) by uncommenting below. -->
    <!-- link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous" -->

    <!-- the fileinput plugin styling CSS file -->
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput.min.css" media="all"
        rel="stylesheet" type="text/css" />

    <!-- if using RTL (Right-To-Left) orientation, load the RTL CSS file after fileinput.css by uncommenting below -->
    <!-- link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css" /-->

    <!-- the jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you
                                                                                                wish to resize images before upload. This must be loaded before fileinput.min.js -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/plugins/piexif.min.js"
        type="text/javascript"></script>

    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview.
                                                                                                This must be loaded before fileinput.min.js -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/plugins/sortable.min.js"
        type="text/javascript"></script>

    <!-- bootstrap.bundle.min.js below is needed if you wish to zoom and preview file content in a detail modal
                                                                                                dialog. bootstrap 5.x or 4.x is supported. You can also use the bootstrap js 3.3.x versions. -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <!-- the main fileinput plugin script JS file -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/fileinput.min.js"></script>

    <!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`). Uncomment if needed. -->
    <!-- script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/themes/fas/theme.min.js"></script -->

    <!-- optionally if you need translation for your language then include the locale file as mentioned below (replace LANG.js with your language locale) -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/js/locales/LANG.js"></script>

    {{-- datepicker --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"
        rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>


    @include('frontend.adv')

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
        <div class="description-sec py-3 ads-sec-btn">
            <div class="btn-secs">
                <div class="row">
                    <div class="col-12 mt-2">
                        <button class="add-ads-buildings add-buildings">اضافة عقار</button>
                    </div>
                    <div class="col-12 mt-2">
                        <button class="add-ads-buildings add-car">اضافة سيارة</button>
                    </div>
                    <div class="col-12 mt-2">
                        <button class="add-ads-buildings add-productss">اضافة منتج</button>
                    </div>
                    <div class="col-12 mt-2">
                        <button class="add-ads-buildings add-services">اضافة وظيفة عامة</button>
                    </div>
                    <div class="col-12 mt-2">
                        <button class="add-ads-buildings add-doctors">اضافة دكتور|ممرض</button>
                    </div>
                    <div class="col-12 mt-2">
                        <button class="add-ads-buildings add-medicines">اضافة صيدلية</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Building-->
        <form action="{{ route('frontend.addFrontBuildings') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="add-buildings-ads-sec py-4 text-center" style="display: none;">
                <div class="upload-image-gallery">
                    <div class="row">
                        <div class="col-12">
                            <input id="input-id input-b8" type="file" name="images[]" multiple="multiple"
                                class="file" data-preview-file-type="text" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-2">
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="اسم العقار"
                            class="form-control addForm" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 mt-2">
                        <select name="building_category_id" class="form-control addForm" style="font-size: 0.8rem;"
                            required>
                            <option value="">اختر القسم</option>
                            @forelse (\App\Models\BuildingCategory::whereStatus('1')->get(['id', 'name']) as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('building_category_id') == $category->id ? 'selected' : null }}>
                                    {{ $category->name }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                        @error('building_category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mt-2 ">
                        <select name="rent" class="form-control addForm" required>
                            <option value="1" {{ old('rent') == 1 ? 'selected' : null }}>ايجار</option>
                            <option value="0" {{ old('rent') == 0 ? 'selected' : null }}>بيع</option>
                        </select>
                        @error('rent')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6 mt-2">
                        <input type="number" name="price" value="{{ old('price') }}" placeholder="السعر" min="0"
                            class="form-control addForm" required>
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-6 mt-2">
                        <input type="number" name="size" value="{{ old('size') }}" placeholder="المساحة" min="0"
                            class="form-control addForm" required>
                        @error('size')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6 mt-2">
                        <input type="number" name="bedroom" value="{{ old('bedroom') }}" placeholder="غرف النوم" min="0"
                            class="form-control addForm" required>
                        @error('bedroom')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6 mt-2">
                        <input type="number" name="bathroom" value="{{ old('bathroom') }}" placeholder="الحمامات" min="0"
                            class="form-control addForm" required>
                        @error('bathroom')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6 mt-2">
                        <input type="number" name="hall" value="{{ old('hall') }}" placeholder="الصالة" min="0"
                            class="form-control addForm" required>
                        @error('hall')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12 mt-2">
                        <textarea name="description" rows="3" placeholder="وصف العقار" class="form-control addForm"
                            required>{!! old('description') !!}</textarea>
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
                                    {{ old('country_id') == $country->id ? 'selected' : null }}>{{ $country->name }}
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
                            required>{!! old('address') !!}</textarea>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="contact-sec-ads py-2">
                    <h6>للتواصل</h6>
                    <div class="row mt-1">
                        <div class="col-12">
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="رقم الهاتف او الواتس"
                                required>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="send-btn">
                    <button type="submit">تنزيل</button>
                </div>
            </div>
        </form>

        <!-- Add Cars-->
        <form action="{{ route('frontend.addFrontCars') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="add-car-ads-sec py-4 text-center" style="display: none;">
                <div class="upload-image-gallery">
                    <div class="row">
                        <div class="col-12">
                            <input id="input-id input-b8" type="file" name="images[]" multiple="multiple"
                                class="file" data-preview-file-type="text">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-2">
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="اسم السيارة"
                            class="form-control addForm" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 mt-2">
                        <select name="car_category_id" class="form-control addForm" style="font-size: 0.8rem;" required>
                            <option value="">اختر القسم</option>
                            @forelse (\App\Models\CarCategory::whereStatus('1')->get(['id', 'name']) as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('car_category_id') == $category->id ? 'selected' : null }}>
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
                            <option value="1" {{ old('rent') == 1 ? 'selected' : null }}>ايجار</option>
                            <option value="0" {{ old('rent') == 0 ? 'selected' : null }}>بيع</option>
                        </select>
                        @error('rent')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6 mt-2">
                        <input type="number" name="price" value="{{ old('price') }}" placeholder="السعر"
                            class="form-control addForm" required>
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 mt-2">
                        <select name="car_type_id" class="form-control addForm" required>
                            <option value="">اختر الماركة</option>
                            @forelse (\App\Models\CarType::whereStatus(1)->get(['id', 'name']) as $carType)
                                <option value="{{ $carType->id }}"
                                    {{ old('car_type_id') == $carType->id ? 'selected' : null }}>
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
                        <input type="text" name="year" value="{{ old('year') }}" placeholder="سنة الاصدار"
                            class="form-control addForm" id="datepicker" required>
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
                        <input type="text" name="color" value="{{ old('color') }}" placeholder="اللون"
                            class="form-control addForm" required>
                        @error('color')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-6 mt-2">
                        <select name="manual" class="form-control addForm">
                            <option value="1" {{ old('manual') == 1 ? 'selected' : null }}>عادي</option>
                            <option value="0" {{ old('manual') == 0 ? 'selected' : null }}>اوتوماتيك</option>
                        </select>
                        @error('manual')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6 mt-2">
                        <input distance="text" name="distance" value="{{ old('distance') }}"
                            placeholder="المسافة التي قطعتها" class="form-control addForm" required>
                        @error('distance')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 mt-2">
                        <input type="text" name="motor" value="{{ old('motor') }}" class="form-control addForm"
                            placeholder="حالة الموتور" required>
                        @error('motor')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-6 mt-2">
                        <input type="text" name="sound" value="{{ old('sound') }}" class="form-control addForm"
                            placeholder="الصوت" required>
                        @error('sound')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6 mt-2">
                        <input type="number" name="seat" value="{{ old('seat') }}" class="form-control addForm" min="0"
                            placeholder="عدد المقاعد" required>
                        @error('seat')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-2">
                        <textarea name="description" rows="5" class="form-control addForm addForm" placeholder="وصف السيارة"
                            required>{!! old('description') !!}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-4">
                        <select name="country_id" placeholder="" id="car_country_id" class="form-control addForm"
                            style="font-size: 0.8rem;">
                            <option value="">كل الدول</option>
                            @forelse (\App\Models\Country::get(['id', 'name']) as $country)
                                <option value="{{ $country->id }}"
                                    {{ old('country_id') == $country->id ? 'selected' : null }}>{{ $country->name }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                        @error('country_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-4">
                        <select name="state_id" id="car_state_id" class="form-control addForm" style="font-size: 0.8rem;">
                        </select>
                        @error('state_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-4">
                        <select name="city_id" id="car_city_id" class="form-control addForm" style="font-size: 0.8rem;">
                        </select>
                        @error('city_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-2">
                        <textarea name="address" rows="3" placeholder="عنوان العقار بالتفصيل" class="form-control addForm"
                            required>{!! old('address') !!}</textarea>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="contact-sec-ads py-2">
                    <h6>للتواصل</h6>
                    <div class="row mt-1">
                        <div class="col-12">
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="رقم الهاتف او الواتس"
                                required>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="send-btn">
                    <button type="submit">تنزيل</button>
                </div>
            </div>
        </form>

        <!-- Add Products-->
        <form action="{{ route('frontend.addFrontProducts') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="add-products-ads-sec py-4 text-center" style="display: none;">
                <div class="upload-image-gallery">
                    <div class="row">
                        <div class="col-12">
                            <input id="input-id input-b8" type="file" name="images[]" multiple="multiple"
                                class="file" data-preview-file-type="text" required>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12 mt-2">
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control addForm"
                            placeholder="اسم المنتج">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 mt-2">
                        <select name="category_id" class="form-control addForm">
                            <option value="">القسم التابع له</option>
                            @forelse (\App\Models\Category::whereStatus('1')->get(['id', 'name']) as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : null }}>
                                    {{ $category->name }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                        @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="col-12 mt-2">
                        <textarea name="description" rows="2" class="form-control addForm"
                            placeholder="وصف المنتج">{!! old('description') !!}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-4 mt-2">
                        <input type="number" name="quantity" value="{{ old('quantity') }}" class="form-control addForm"
                            min="0" placeholder="الكمية">
                        @error('quantity')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-4 mt-2">
                        <input type="number" name="price" value="{{ old('price') }}" class="form-control addForm"
                            placeholder="السعر" min="0">
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-4 mt-2">
                        <select name="featured" class="form-control addForm">
                            <option value="1" {{ old('featured') == 1 ? 'selected' : null }}>مميز</option>
                            <option value="0" {{ old('featured') == 0 ? 'selected' : null }}>لا</option>
                        </select>
                        @error('featured')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="col-6 mt-2">
                        <input type="date" name="start_date" value="{{ old('start_date') }}"
                            class="form-control addForm" placeholder="تاريخ الانتاج" min="0">
                        @error('start_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6 mt-2">
                        <input type="date" name="end_date" value="{{ old('end_date') }}" class="form-control addForm"
                            placeholder="تاريخ الانتهاء" min="0">
                        @error('end_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-4">
                        <select name="country_id" placeholder="" id="product_country_id" class="form-control addForm"
                            style="font-size: 0.8rem;">
                            <option value="">كل الدول</option>
                            @forelse (\App\Models\Country::get(['id', 'name']) as $country)
                                <option value="{{ $country->id }}"
                                    {{ old('country_id') == $country->id ? 'selected' : null }}>{{ $country->name }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                        @error('country_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-4">
                        <select name="state_id" id="product_state_id" class="form-control addForm"
                            style="font-size: 0.8rem;">
                        </select>
                        @error('state_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-4">
                        <select name="city_id" id="product_city_id" class="form-control addForm"
                            style="font-size: 0.8rem;">
                        </select>
                        @error('city_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-2">
                        <textarea name="address" rows="3" placeholder="العنوان بالتفصيل" class="form-control addForm"
                            required>{!! old('address') !!}</textarea>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="contact-sec-ads py-2">
                    <h6>للتواصل</h6>
                    <div class="row mt-1">
                        <div class="col-12">
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="رقم الهاتف او الواتس"
                                required>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="send-btn">
                    <button type="submit">تنزيل</button>
                </div>
            </div>
        </form>

        <form action="{{ route('frontend.addFrontJobs') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="add-services-ads-sec py-4 text-center" style="display: none;">
                <div class="row mt-2">
                    <div class="col-12 mt-2">
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="اسم الوظيفة"
                            class="form-control addForm" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-6 mt-2">
                        <select name="gender" class="form-control addForm">
                            <option value="1" {{ old('gender') == 1 ? 'selected' : null }}>ذكر</option>
                            <option value="0" {{ old('gender') == 0 ? 'selected' : null }}>أنثي</option>
                        </select>
                        @error('gender')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6 mt-2">
                        <input type="number" name="exp_years" value="{{ old('exp_years') }}" placeholder="سنوات الخبرة"
                            class="form-control addForm" min="1" max="70" required>
                        @error('exp_years')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 mt-2">
                        <select name="job_category_id" class="form-control addForm">
                            <option value="">القسم التابع له</option>
                            @forelse (\App\Models\JobCategory::whereStatus('1')->get(['id', 'name']) as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('job_category_id') == $category->id ? 'selected' : null }}>
                                    {{ $category->name }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                        @error('job_category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 mt-2">
                        <input type="text" name="speciality" value="{{ old('speciality') }}" placeholder="التخصص"
                            class="form-control addForm" required>
                        @error('speciality')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="col-12 mt-2">
                        <textarea name="description" rows="5" class="form-control addForm" placeholder="تفاصيل او نبذة"
                            required>{!! old('description') !!}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-4">
                        <select name="country_id" placeholder="" id="job_country_id" class="form-control addForm"
                            style="font-size: 0.8rem;">
                            <option value="">كل الدول</option>
                            @forelse (\App\Models\Country::get(['id', 'name']) as $country)
                                <option value="{{ $country->id }}"
                                    {{ old('country_id') == $country->id ? 'selected' : null }}>
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
                        <select name="state_id" id="job_state_id" class="form-control addForm" style="font-size: 0.8rem;">
                        </select>
                        @error('state_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-4">
                        <select name="city_id" id="job_city_id" class="form-control addForm" style="font-size: 0.8rem;">
                        </select>
                        @error('city_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-2">
                        <textarea name="address" rows="3" placeholder="العنوان بالتفصيل" class="form-control addForm"
                            required>{!! old('address') !!}</textarea>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="contact-sec-ads py-2">
                    <h6>للتواصل</h6>
                    <div class="row mt-1">
                        <div class="col-12">
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                placeholder="رقم الهاتف او الواتس" required>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="send-btn">
                    <button type="submit">تنزيل</button>
                </div>
            </div>
        </form>

        <form action="{{ route('frontend.addFrontDoctors') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="add-doctors-ads-sec py-4 text-center" style="display: none;">
                <div class="row mt-2">
                    <div class="col-12 mt-2">
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="اسم الدكتور"
                            class="form-control addForm" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 mt-2">
                        <select name="medical_type" class="form-control addForm">
                            <option value="Doctor" {{ old('medical_type') == 'Doctor' ? 'selected' : null }}>
                                دكتور|دكتورة</option>
                            <option value="Nurse" {{ old('medical_type') == 'Nurse' ? 'selected' : null }}>ممرض|ممرضة
                            </option>
                        </select>
                        @error('medical_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-6 mt-2">
                        <select name="gender" class="form-control addForm">
                            <option value="1" {{ old('gender') == 1 ? 'selected' : null }}>ذكر</option>
                            <option value="0" {{ old('gender') == 0 ? 'selected' : null }}>أنثي</option>
                        </select>
                        @error('gender')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6 mt-2">
                        <input type="number" name="exp_years" value="{{ old('exp_years') }}" placeholder="سنوات الخبرة"
                            class="form-control addForm" min="1" max="70" required>
                        @error('exp_years')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 mt-2">
                        <input type="text" name="speciality" value="{{ old('speciality') }}" placeholder="التخصص"
                            class="form-control addForm" required>
                        @error('speciality')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12 mt-2">
                        <input type="text" name="type" value="{{ old('type') }}" placeholder="المسمي الوظيفي"
                            class="form-control addForm" required>
                        @error('type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="col-12 mt-2">
                        <textarea name="description" rows="2" class="form-control addForm" placeholder="تفاصيل او نبذة"
                            required>{!! old('description') !!}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12 mt-2">
                        <textarea name="work_hours" rows="2" class="form-control addForm" placeholder="ساعات العمل"
                            required>{!! old('work_hours') !!}</textarea>
                        @error('work_hours')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-4">
                        <select name="country_id" placeholder="" id="doctor_country_id" class="form-control addForm"
                            style="font-size: 0.8rem;">
                            <option value="">كل الدول</option>
                            @forelse (\App\Models\Country::get(['id', 'name']) as $country)
                                <option value="{{ $country->id }}"
                                    {{ old('country_id') == $country->id ? 'selected' : null }}>
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
                        <select name="state_id" id="doctor_state_id" class="form-control addForm"
                            style="font-size: 0.8rem;">
                        </select>
                        @error('state_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-4">
                        <select name="city_id" id="doctor_city_id" class="form-control addForm" style="font-size: 0.8rem;">
                        </select>
                        @error('city_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-2">
                        <textarea name="address" rows="2" placeholder="العنوان بالتفصيل" class="form-control addForm"
                            required>{!! old('address') !!}</textarea>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="contact-sec-ads py-2">
                    <h6>للتواصل</h6>
                    <div class="row mt-1">
                        <div class="col-12">
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                placeholder="رقم الهاتف او الواتس" required>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="send-btn">
                    <button type="submit">تنزيل</button>
                </div>
            </div>
        </form>

        <form action="{{ route('frontend.addFrontMedicines') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="add-medicines-ads-sec py-4 text-center" style="display: none;">
                <div class="row mt-2">
                    <div class="col-12 mt-2">
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="اسم الصيدلية"
                            class="form-control addForm" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 mt-2" hidden>
                            <input type="hidden" name="medical_type" value="Medicine" placeholder="اسم الصيدلية">
                        @error('medical_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 mt-2">
                        <textarea name="description" rows="2" class="form-control addForm" placeholder="تفاصيل او نبذة"
                            required>{!! old('description') !!}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12 mt-2">
                        <textarea name="work_hours" rows="2" class="form-control addForm" placeholder="ساعات العمل"
                            required>{!! old('work_hours') !!}</textarea>
                        @error('work_hours')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-4">
                        <select name="country_id" placeholder="" id="medicine_country_id" class="form-control addForm"
                            style="font-size: 0.8rem;">
                            <option value="">كل الدول</option>
                            @forelse (\App\Models\Country::get(['id', 'name']) as $country)
                                <option value="{{ $country->id }}"
                                    {{ old('country_id') == $country->id ? 'selected' : null }}>
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
                        <select name="state_id" id="medicine_state_id" class="form-control addForm"
                            style="font-size: 0.8rem;">
                        </select>
                        @error('state_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-4">
                        <select name="city_id" id="medicine_city_id" class="form-control addForm" style="font-size: 0.8rem;">
                        </select>
                        @error('city_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-2">
                        <textarea name="address" rows="2" placeholder="العنوان بالتفصيل" class="form-control addForm"
                            required>{!! old('address') !!}</textarea>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="contact-sec-ads py-2">
                    <h6>للتواصل</h6>
                    <div class="row mt-1">
                        <div class="col-12">
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                placeholder="رقم الهاتف او الواتس" required>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="send-btn">
                    <button type="submit">تنزيل</button>
                </div>
            </div>
        </form>
    </div>



@endsection
@section('script')
    <script src="{{ asset('frontend/js/index.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#datepicker").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                autoclose: true
            });
        });
    </script>
    <script>
        $(function() {
            carStates();
            carCities();

            $("#car_country_id").change(function() {
                carStates();
                carCities();
                return false;
            });

            $("#car_state_id").change(function() {
                carCities();
                return false;
            });

            function carStates() {
                let countryIdVal = $('#car_country_id').val() != null ? $('#car_country_id').val() :
                    '{{ old('country_id') }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('frontend.frontGetState') }}", {
                    country_id: countryIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#car_state_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#car_state_id').append($('<option></option>').val('').html('المحافظة'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id == '{{ old('state_id') }}' ? "selected" : "";
                        $("#car_state_id").append($('<option ' + selectedVal + '></option>').val(
                            text
                            .id).html(text.name));
                    });
                }, "json")

            }

            function carCities() {
                let stateIdVal = $('#car_state_id').val() != null ? $('#car_state_id').val() :
                    '{{ old('state_id') }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('frontend.frontGetCity') }}", {
                    state_id: stateIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#car_city_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#car_city_id').append($('<option></option>').val('').html('المدينة'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id == '{{ old('city_id') }}' ? "selected" : "";
                        $("#car_city_id").append($('<option ' + selectedVal + '></option>').val(text
                                .id)
                            .html(text.name));
                    });
                }, "json")
            }

        });
    </script>

    <script>
        $(function() {
            productStates();
            productCities();

            $("#product_country_id").change(function() {
                productStates();
                productCities();
                return false;
            });

            $("#product_state_id").change(function() {
                productCities();
                return false;
            });

            function productStates() {
                let countryIdVal = $('#product_country_id').val() != null ? $('#product_country_id').val() :
                    '{{ old('country_id') }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('frontend.frontGetState') }}", {
                    country_id: countryIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#product_state_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#product_state_id').append($('<option></option>').val('').html('المحافظة'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id == '{{ old('state_id') }}' ? "selected" : "";
                        $("#product_state_id").append($('<option ' + selectedVal + '></option>')
                            .val(
                                text
                                .id).html(text.name));
                    });
                }, "json")

            }

            function productCities() {
                let stateIdVal = $('#product_state_id').val() != null ? $('#product_state_id').val() :
                    '{{ old('state_id') }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('frontend.frontGetCity') }}", {
                    state_id: stateIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#product_city_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#product_city_id').append($('<option></option>').val('').html('المدينة'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id == '{{ old('city_id') }}' ? "selected" : "";
                        $("#product_city_id").append($('<option ' + selectedVal + '></option>').val(
                                text
                                .id)
                            .html(text.name));
                    });
                }, "json")
            }

        });
    </script>

    <script>
        $(function() {
            jobStates();
            jobCities();

            $("#job_country_id").change(function() {
                jobStates();
                jobCities();
                return false;
            });

            $("#job_state_id").change(function() {
                jobCities();
                return false;
            });

            function jobStates() {
                let countryIdVal = $('#job_country_id').val() != null ? $('#job_country_id').val() :
                    '{{ old('country_id') }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('frontend.frontGetState') }}", {
                    country_id: countryIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#job_state_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#job_state_id').append($('<option></option>').val('').html('المحافظة'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id == '{{ old('state_id') }}' ? "selected" : "";
                        $("#job_state_id").append($('<option ' + selectedVal + '></option>')
                            .val(
                                text
                                .id).html(text.name));
                    });
                }, "json")

            }

            function jobCities() {
                let stateIdVal = $('#job_state_id').val() != null ? $('#job_state_id').val() :
                    '{{ old('state_id') }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('frontend.frontGetCity') }}", {
                    state_id: stateIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#job_city_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#job_city_id').append($('<option></option>').val('').html('المدينة'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id == '{{ old('city_id') }}' ? "selected" : "";
                        $("#job_city_id").append($('<option ' + selectedVal + '></option>').val(
                                text
                                .id)
                            .html(text.name));
                    });
                }, "json")
            }

        });
    </script>

    <script>
        $(function() {
            doctorStates();
            doctorCities();

            $("#doctor_country_id").change(function() {
                doctorStates();
                doctorCities();
                return false;
            });

            $("#doctor_state_id").change(function() {
                doctorCities();
                return false;
            });

            function doctorStates() {
                let countryIdVal = $('#doctor_country_id').val() != null ? $('#doctor_country_id').val() :
                    '{{ old('country_id') }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('frontend.frontGetState') }}", {
                    country_id: countryIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#doctor_state_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#doctor_state_id').append($('<option></option>').val('').html('المحافظة'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id == '{{ old('state_id') }}' ? "selected" : "";
                        $("#doctor_state_id").append($('<option ' + selectedVal + '></option>')
                            .val(
                                text
                                .id).html(text.name));
                    });
                }, "json")

            }

            function doctorCities() {
                let stateIdVal = $('#doctor_state_id').val() != null ? $('#doctor_state_id').val() :
                    '{{ old('state_id') }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('frontend.frontGetCity') }}", {
                    state_id: stateIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#doctor_city_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#doctor_city_id').append($('<option></option>').val('').html('المدينة'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id == '{{ old('city_id') }}' ? "selected" : "";
                        $("#doctor_city_id").append($('<option ' + selectedVal + '></option>').val(
                                text
                                .id)
                            .html(text.name));
                    });
                }, "json")
            }

        });
    </script>

    <script>
        $(function() {
            medicineStates();
            medicineCities();

            $("#medicine_country_id").change(function() {
                medicineStates();
                medicineCities();
                return false;
            });

            $("#medicine_state_id").change(function() {
                medicineCities();
                return false;
            });

            function medicineStates() {
                let countryIdVal = $('#medicine_country_id').val() != null ? $('#medicine_country_id').val() :
                    '{{ old('country_id') }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('frontend.frontGetState') }}", {
                    country_id: countryIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#medicine_state_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#medicine_state_id').append($('<option></option>').val('').html('المحافظة'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id == '{{ old('state_id') }}' ? "selected" : "";
                        $("#medicine_state_id").append($('<option ' + selectedVal + '></option>')
                            .val(
                                text
                                .id).html(text.name));
                    });
                }, "json")

            }

            function medicineCities() {
                let stateIdVal = $('#medicine_state_id').val() != null ? $('#medicine_state_id').val() :
                    '{{ old('state_id') }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('frontend.frontGetCity') }}", {
                    state_id: stateIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#medicine_city_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#medicine_city_id').append($('<option></option>').val('').html('المدينة'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id == '{{ old('city_id') }}' ? "selected" : "";
                        $("#medicine_city_id").append($('<option ' + selectedVal + '></option>').val(
                                text
                                .id)
                            .html(text.name));
                    });
                }, "json")
            }

        });
    </script>
@endsection
