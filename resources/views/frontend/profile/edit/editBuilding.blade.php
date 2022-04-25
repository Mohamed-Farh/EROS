@extends('layouts.frontend_app')

@section('title', $buildingProduct->name)

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
            <!-- Add Building-->
            <form action="{{ route('frontend.profileUpdateBuilding', ['id' => $buildingProduct]) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="add-buildings-ads-sec py-4 text-center">
                    <h4 class="text-center pb-3">{{ $buildingProduct->name }}</h4>
                    <div class="upload-image-gallery">
                        <div class="row">
                            <div class="col-12">
                                <input type="file" name="images[]" id="buildingProduct_images" class="file-input-overview"
                                    multiple="multiple">
                                @error('images')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-2">
                            <input type="text" name="name" value="{{ old('name', $buildingProduct->name) }}"
                                placeholder="اسم العقار" class="form-control addForm" required>
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
                                        {{ old('building_category_id', $buildingProduct->building_category_id) == $category->id ? 'selected' : null }}>
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
                                <option value="1" {{ old('rent', $buildingProduct->rent) == 1 ? 'selected' : null }}>
                                    ايجار</option>
                                <option value="0" {{ old('rent', $buildingProduct->rent) == 0 ? 'selected' : null }}>بيع
                                </option>
                            </select>
                            @error('rent')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mt-2">
                            <input type="number" name="price" value="{{ old('price', $buildingProduct->price) }}"
                                placeholder="السعر" min="0" class="form-control addForm" required>
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mt-2">
                            <input type="number" name="size" value="{{ old('size', $buildingProduct->size) }}"
                                placeholder="المساحة" min="0" class="form-control addForm" required>
                            @error('size')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mt-2">
                            <input type="number" name="bedroom" value="{{ old('bedroom', $buildingProduct->bedroom) }}"
                                placeholder="غرف النوم" min="0" class="form-control addForm" required>
                            @error('bedroom')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mt-2">
                            <input type="number" name="bathroom"
                                value="{{ old('bathroom', $buildingProduct->bathroom) }}" placeholder="الحمامات" min="0"
                                class="form-control addForm" required>
                            @error('bathroom')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mt-2">
                            <input type="number" name="hall" value="{{ old('hall', $buildingProduct->hall) }}"
                                placeholder="الصالة" min="0" class="form-control addForm" required>
                            @error('hall')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mt-2">
                            <textarea name="description" rows="3" placeholder="وصف العقار" class="form-control addForm"
                                required>{!! old('description', $buildingProduct->description) !!}</textarea>
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
                                        {{ old('country_id', $buildingProduct->country_id) == $country->id ? 'selected' : null }}>
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
                                required>{!! old('address', $buildingProduct->address) !!}</textarea>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="contact-sec-ads py-2">
                        <h6>للتواصل</h6>
                        <div class="row mt-1">
                            <div class="col-12">
                                <input type="text" name="phone" value="{{ old('phone', $buildingProduct->phone) }}"
                                    placeholder="رقم الهاتف او الواتس" required>
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="send-btn">
                        <button type="submit">تعديل البيانات</button>
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
            $('#buildingProduct_images').fileinput({
                theme: "fas",
                maxFileCount: {{ 10 - $buildingProduct->media->count() }},
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @if ($buildingProduct->media->count() > 0)
                        @foreach ($buildingProduct->media as $media)
                            "{{ asset($media->file_name) }}",
                        @endforeach
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($buildingProduct->media->count() > 0)
                        @foreach ($buildingProduct->media as $media)
                            {
                            caption: "{{ $media->file_name }}",
                            size: {{ $media->file_size }},
                            width: "120px",
                            url:
                            "{{ route('frontend.buildingRemoveImage', ['image_id' => $media->id,'buildingProduct_id' => $buildingProduct->id,'_token' => csrf_token()]) }}",
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
                    '{{ old('country_id', $buildingProduct->country_id) }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('frontend.frontGetState') }}", {
                    country_id: countryIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#state_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#state_id').append($('<option></option>').val('').html('---'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id ==
                            '{{ old('state_id', $buildingProduct->state_id) }}' ? "selected" :
                            "";
                        $("#state_id").append($('<option ' + selectedVal + '></option>').val(text
                            .id).html(text.name));
                    });
                }, "json")

            }

            function populateCities() {
                let stateIdVal = $('#state_id').val() != null ? $('#state_id').val() :
                    '{{ old('state_id', $buildingProduct->state_id) }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('frontend.frontGetCity') }}", {
                    state_id: stateIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#city_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#city_id').append($('<option></option>').val('').html('---'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id ==
                            '{{ old('city_id', $buildingProduct->city_id) }}' ? "selected" : "";
                        $("#city_id").append($('<option ' + selectedVal + '></option>').val(text.id)
                            .html(text.name));
                    });
                }, "json")
            }

        });
    </script>
@endsection
