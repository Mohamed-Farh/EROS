@extends('layouts.auth_admin_app')

@section('title', 'تعدبل السيارة')

@section('style')
    <link rel="stylesheet" href="{{ asset('backend/vendor/select2/css/select2.min.css') }}">
@endsection

@section('content')

<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="col-6">
                <h6 class="m-0 font-weight-bold text-primary">تعدبل السيارة </h6>
            </div>
            <div class="col-6 text-right">
                <a href="{{ route('admin.carCategories.show', $carProduct->car_category_id) }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">السيارات</span>
                </a>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.carProducts.update', $carProduct->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-9">
                        <div class="form-group">
                            <label for="name">اسم السيارة</label>
                            <input type="text" name="name" value="{{ old('name', $carProduct->name ) }}" class="form-control">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <label for="phone">رقم الهاتف او الواتس</label>
                        <input type="text" name="phone" value="{{ old('phone', $carProduct->phone ) }}" class="form-control" required>
                        @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="user_id">اسم العميل | صاحب الاعلان</label>
                            <input type="text" name="customer_name"
                                value="{{ $carProduct->user->full_name }}" class="form-control" readonly>
                            <input type="hidden" name="user_id" id="user_id" class="form-control"
                                value="{{ $carProduct->user->id  }}" readonly>
                            @error('user_id')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-4">
                        <label for="status">حالة السيارة</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status', $carProduct->status ) == 1 ? 'selected' : null }}>نشط</option>
                            <option value="0" {{ old('status', $carProduct->status ) == 0 ? 'selected' : null }}>غير نشط</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-4">
                        <label for="rent">بيع او ايجار</label>
                        <select name="rent" class="form-control">
                            <option value="1" {{ old('rent', $carProduct->rent ) == 1 ? 'selected' : null }}>ايجار</option>
                            <option value="0" {{ old('rent', $carProduct->rent ) == 0 ? 'selected' : null }}>بيع</option>
                        </select>
                        @error('rent')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-4">
                        <label for="price">السعر</label>
                        <input type="number" name="price" value="{{ old('price', $carProduct->price) }}" class="form-control"  min="0"  required>
                        @error('price')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-3">
                        <label for="car_type_id">ماركة السيارة</label>
                        <select name="car_type_id" class="form-control" required>
                            @forelse (\App\Models\CarType::whereStatus(1)->get(['id', 'name']) as $carType)
                                <option value="{{ $carType->id }}"
                                    {{ old('car_type_id', $carProduct->car_type_id) == $carType->id ? 'selected' : null }}>{{ $carType->name }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                        @error('car_type_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-3">
                        <label for="year">سنة الاصدار</label>
                        <input type="text" name="year" value="{{ old('year', $carProduct->year) }}" class="form-control" id="datepicker" required>
                        @error('year')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-3">
                        <label for="color">اللون</label>
                        <input type="text" name="color" value="{{ old('color', $carProduct->color) }}" class="form-control" required>
                        @error('color')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-3">
                        <label for="manual">عادي - اوتوماتيك</label>
                        <select name="manual" class="form-control">
                            <option value="1" {{ old('manual', $carProduct->manual) == 1 ? 'selected' : null }}>عادي</option>
                            <option value="0" {{ old('manual', $carProduct->manual) == 0 ? 'selected' : null }}>اوتوماتيك</option>
                        </select>
                        @error('manual')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-3">
                        <label for="distance">المسافة التي قطعتها</label>
                        <input distance="text" name="distance" value="{{ old('distance', $carProduct->distance) }}" class="form-control" required>
                        @error('distance')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-3">
                        <label for="motor">حالة الموتور</label>
                        <input type="text" name="motor" value="{{ old('motor', $carProduct->motor) }}" class="form-control" required>
                        @error('motor')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-3">
                        <label for="sound">الصوت</label>
                        <input type="text" name="sound" value="{{ old('sound', $carProduct->sound) }}" class="form-control" required>
                        @error('sound')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-3">
                        <label for="seat">عدد المقاعد</label>
                        <input type="number" name="seat" value="{{ old('seat', $carProduct->seat) }}" class="form-control"  min="0" required>
                        @error('seat')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <label for="description">وصف السيارة</label>
                        <textarea name="description" rows="5" class="form-control">{!! old('description', $carProduct->description ) !!}</textarea>
                        @error('description')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-4">
                        <label for="country_id">الدولة</label>
                        <select name="country_id" class="form-control" id="country_id">
                            <option value="">كل الدول</option>
                            @forelse ($countries as $country)
                                <option value="{{ $country->id }}"
                                    {{ old('country_id', $carProduct->country_id) == $country->id ? 'selected' : null }}>{{ $country->name }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                        @error('country_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-4">
                        <label for="state_id">المحافظة</label>
                        <select name="state_id" id="state_id" class="form-control">
                        </select>
                        @error('state_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-4">
                        <label for="city_id">المدينة</label>
                        <select name="city_id" id="city_id" class="form-control">
                        </select>
                        @error('city_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <label for="address">العنوان بالتفصيل</label>
                        <textarea name="address" rows="5" class="form-control" required>{!! old('address', $carProduct->address ) !!}</textarea>
                        @error('address')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>


                <div class="row pt-4 mt-4">
                    <div class="col-12">
                        <div class="form-group file-loading">
                            <label for="images">صور السيارات</label>
                            <input type="file" name="images[]" id="carProduct_images" class="file-input-overview" multiple="multiple">
                            <span class="form-text text-muted">Image Width Should be (500px) X (500px)</span>
                            <span class="form-text text-muted">ادخل صورة وحيدة او مجموعة من الصورة خاصة هذا السيارة</span>
                            @error('images')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group pt-4 text-center">
                    <button type="submit" name="submit" class="btn btn-primary">تعديل بيانات السيارة</button>
                </div>
            </form>
        </div>
    </div>
</div>


    @endsection

    @section('script')
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
                        @if($carProduct->media->count() > 0)
                            @foreach($carProduct->media as $media)
                                "{{asset($media->file_name)}}",
                            @endforeach
                        @endif
                    ],
                    initialPreviewAsData: true,
                    initialPreviewFileType: 'image',
                    initialPreviewConfig: [
                        @if($carProduct->media->count() > 0)
                            @foreach($carProduct->media as $media)
                                {
                                    caption: "{{ $media->file_name }}",
                                    size: {{ $media->file_size }},
                                    width: "120px",
                                    url: "{{ route('admin.carProducts.removeImage', ['image_id'=>$media->id, 'carProduct_id'=>$carProduct->id, '_token' => csrf_token()]) }}",
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
            $.get("{{ route('admin.carProducts.get_state') }}", {
                country_id: countryIdVal
            }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                $('option', $('#state_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                $('#state_id').append($('<option></option>').val('').html('---'));
                $.each(data, function(val, text) {
                    let selectedVal = text.id == '{{ old('state_id', $carProduct->state_id) }}' ? "selected" : "";
                    $("#state_id").append($('<option ' + selectedVal + '></option>').val(text
                        .id).html(text.name));
                });
            }, "json")

        }

        function populateCities() {
            let stateIdVal = $('#state_id').val() != null ? $('#state_id').val() :
            '{{ old('state_id', $carProduct->state_id) }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
            $.get("{{ route('admin.carProducts.get_city') }}", {
                state_id: stateIdVal
            }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                $('option', $('#city_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                $('#city_id').append($('<option></option>').val('').html('---'));
                $.each(data, function(val, text) {
                    let selectedVal = text.id == '{{ old('city_id', $carProduct->city_id) }}' ? "selected" : "";
                    $("#city_id").append($('<option ' + selectedVal + '></option>').val(text.id)
                        .html(text.name));
                });
            }, "json")
        }

    });
</script>
    @endsection

