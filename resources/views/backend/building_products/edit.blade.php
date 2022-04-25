@extends('layouts.auth_admin_app')

@section('title', 'تعدبل العقار')

@section('style')
    <link rel="stylesheet" href="{{ asset('backend/vendor/select2/css/select2.min.css') }}">
@endsection

@section('content')

    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <div class="col-6">
                    <h6 class="m-0 font-weight-bold text-primary">تعدبل العقار </h6>
                </div>
                <div class="col-6 text-right">
                    <a href="{{ route('admin.buildings.show', $buildingProduct->building_category_id) }}"
                        class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-home"></i>
                        </span>
                        <span class="text">العقارات</span>
                    </a>
                </div>
            </div>
            <div class="card-body">

                <form action="{{ route('admin.buildingProducts.update', $buildingProduct->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-9">
                            <div class="form-group">
                                <label for="name">اسم العقار</label>
                                <input type="text" name="name" value="{{ old('name', $buildingProduct->name) }}"
                                    class="form-control">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <label for="phone">رقم الهاتف او الواتس</label>
                            <input type="text" name="phone" value="{{ old('phone', $buildingProduct->phone) }}"
                                class="form-control" required>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-3" hidden>
                            <div class="form-group">
                                <label for="building_category_id">فئة العقار</label>
                                <input type="hidden" name="building_category_id"
                                    value="{{ $buildingProduct->building_category_id }}" class="form-control">
                                @error('building_category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="user_id">اسم العميل | صاحب الاعلان</label>
                                <input type="text" name="customer_name" value="{{ $buildingProduct->user->full_name }}"
                                    class="form-control" readonly>
                                <input type="hidden" name="user_id" id="user_id" class="form-control"
                                    value="{{ $buildingProduct->user->id }}" readonly>
                                @error('user_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-4">
                            <label for="status">حالة العقار</label>
                            <select name="status" class="form-control">
                                <option value="1"
                                    {{ old('status', $buildingProduct->status) == 1 ? 'selected' : null }}>نشط</option>
                                <option value="0"
                                    {{ old('status', $buildingProduct->status) == 0 ? 'selected' : null }}>غير نشط
                                </option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="rent">بيع او ايجار</label>
                            <select name="rent" class="form-control">
                                <option value="1" {{ old('rent', $buildingProduct->rent) == 1 ? 'selected' : null }}>
                                    ايجار</option>
                                <option value="0" {{ old('rent', $buildingProduct->rent) == 0 ? 'selected' : null }}>بيع
                                </option>
                            </select>
                            @error('rent')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="price">السعر</label>
                            <input type="number" name="price" value="{{ old('price', $buildingProduct->price) }}"
                                class="form-control" min="0" required>
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-3">
                            <label for="size">المساحة</label>
                            <input type="number" name="size" value="{{ old('size', $buildingProduct->size) }}"
                                class="form-control" min="0" required>
                            @error('size')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="bedroom">غرف النوم</label>
                            <input type="number" name="bedroom" value="{{ old('bedroom', $buildingProduct->bedroom) }}"
                                class="form-control" min="0" required>
                            @error('bedroom')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="bathroom">الحمامات</label>
                            <input type="number" name="bathroom"
                                value="{{ old('bathroom', $buildingProduct->bathroom) }}" class="form-control" min="0"
                                required>
                            @error('bathroom')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="hall">الصالة</label>
                            <input type="number" name="hall" value="{{ old('hall', $buildingProduct->hall) }}"
                                class="form-control" min="0" required>
                            @error('hall')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <label for="description">وصف العقار</label>
                            <textarea name="description" rows="5" class="form-control">{!! old('description', $buildingProduct->description) !!}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-4">
                            <label for="country_id">الدولة</label>
                            <select name="country_id" class="form-control" id="country_id">
                                <option value="">كل الدول</option>
                                @forelse ($countries as $country)
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
                            <label for="state_id">المحافظة</label>
                            <select name="state_id" id="state_id" class="form-control">
                            </select>
                            @error('state_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-4">
                            <label for="city_id">المدينة</label>
                            <select name="city_id" id="city_id" class="form-control">
                            </select>
                            @error('city_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <label for="address">عنوان العقار بالتفصيل</label>
                            <textarea name="address" rows="5" class="form-control" required>{!! old('address', $buildingProduct->address) !!}</textarea>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="row pt-4 mt-4">
                        <div class="col-12">
                            <div class="form-group file-loading">
                                <label for="images">صور العقارات</label>
                                <input type="file" name="images[]" id="buildingProduct_images" class="file-input-overview"
                                    multiple="multiple">
                                <span class="form-text text-muted">Image Width Should be (500px) X (500px)</span>
                                <span class="form-text text-muted">ادخل صورة وحيدة او مجموعة من الصورة خاصة هذا
                                    العقار</span>
                                @error('images')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group pt-4 text-center">
                        <button type="submit" name="submit" class="btn btn-primary">تعديل بيانات العقار</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('script')
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
                            "{{ route('admin.buildingProducts.removeImage', ['image_id' => $media->id,'buildingProduct_id' => $buildingProduct->id,'_token' => csrf_token()]) }}",
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
                $.get("{{ route('admin.backend.get_state') }}", {
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
                $.get("{{ route('admin.backend.get_city') }}", {
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
