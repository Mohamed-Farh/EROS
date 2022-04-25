@extends('layouts.auth_admin_app')

@section('title', 'انشاء سيارة جديد')

@section('content')

    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <div class="col-6">
                    <h3 class="m-0 font-weight-bold text-primary">{{ __('انشاء سيارة جديد') }}</h3>
                </div>
                <div class="col-6 text-right">
                    <a href="{{ route('admin.carCategories.show', $carCategory_id) }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-home"></i>
                        </span>
                        <span class="text">{{ __('السيارات') }}</span>
                    </a>
                </div>
            </div>
            <div class="card-body">

                <form action="{{ route('admin.carProducts.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-9">
                            <div class="form-group">
                                <label for="name">اسم السيارة</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                    required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <label for="phone">رقم الهاتف او الواتس</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control"
                                required>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-3" hidden>
                            <div class="form-group">
                                <label for="car_category_id">فئة السيارة</label>
                                <input type="hidden" name="car_category_id" value="{{ $carCategory_id }}"
                                    class="form-control">
                                @error('car_category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="user_id">اسم العميل | صاحب الاعلان</label>
                                <input type="text" name="customer_name" id="customer_name"
                                    value="{{ old('customer_name', request()->input('customer_name')) }}"
                                    placeholder="Start Customer Search" class="form-control typeahead"
                                    data-provide="typeahead" autocomplete="off">
                                <input type="hidden" name="user_id" id="user_id" class="form-control"
                                    value="{{ old('user_id', request()->input('user_id')) }}" readonly required>
                                @error('user_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4">
                            <label for="status">حالة السيارة</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ old('status') == 1 ? 'selected' : null }}>نشط</option>
                                <option value="0" {{ old('status') == 0 ? 'selected' : null }}>غير نشط</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="rent">بيع او ايجار</label>
                            <select name="rent" class="form-control">
                                <option value="1" {{ old('rent') == 1 ? 'selected' : null }}>ايجار</option>
                                <option value="0" {{ old('rent') == 0 ? 'selected' : null }}>بيع</option>
                            </select>
                            @error('rent')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-4">
                            <label for="price">السعر</label>
                            <input type="number" name="price" value="{{ old('price') }}" class="form-control"
                                required>
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-3">
                            <label for="car_type_id">ماركة السيارة</label>
                            <select name="car_type_id" class="form-control" required>
                                @forelse (\App\Models\CarType::whereStatus(1)->get(['id', 'name']) as $carType)
                                    <option value="{{ $carType->id }}"
                                        {{ old('car_type_id') == $carType->id ? 'selected' : null }}>
                                        {{ $carType->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('car_type_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="year">سنة الاصدار</label>
                            <input type="text" name="year" value="{{ old('year') }}" class="form-control"
                                id="datepicker" required>
                            @error('year')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="color">اللون</label>
                            <input type="text" name="color" value="{{ old('color') }}" class="form-control"
                                required>
                            @error('color')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="manual">عادي - اوتوماتيك</label>
                            <select name="manual" class="form-control">
                                <option value="1" {{ old('manual') == 1 ? 'selected' : null }}>عادي</option>
                                <option value="0" {{ old('manual') == 0 ? 'selected' : null }}>اوتوماتيك</option>
                            </select>
                            @error('manual')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-3">
                            <label for="distance">المسافة التي قطعتها</label>
                            <input distance="text" name="distance" value="{{ old('distance') }}"
                                class="form-control" required>
                            @error('distance')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="motor">حالة الموتور</label>
                            <input type="text" name="motor" value="{{ old('motor') }}" class="form-control"
                                required>
                            @error('motor')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="sound">الصوت</label>
                            <input type="text" name="sound" value="{{ old('sound') }}" class="form-control"
                                required>
                            @error('sound')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="seat">عدد المقاعد</label>
                            <input type="number" name="seat" value="{{ old('seat') }}" class="form-control" min="0"
                                required>
                            @error('seat')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <label for="description">وصف السيارة</label>
                            <textarea name="description" rows="5" class="form-control"
                                required>{!! old('description') !!}</textarea>
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
                                        {{ old('country_id') == $country->id ? 'selected' : null }}>
                                        {{ $country->name }}</option>
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
                            <label for="address">العنوان بالتفصيل</label>
                            <textarea name="address" rows="5" class="form-control"
                                required>{!! old('address') !!}</textarea>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row pt-4 mt-4">
                        <div class="col-12">
                            <div class="form-group file-loading">
                                <label for="images">صور السيارات</label>
                                <input type="file" name="images[]" id="product_images" class="file-input-overview"
                                    multiple="multiple" required>
                                <span class="form-text text-muted">Image Width Should be (500px) X (500px)</span>
                                <span class="form-text text-muted">ادخل صورة وحيدة او مجموعة من الصورة خاصة هذا
                                    السيارة</span>
                                @error('images')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group pt-4 text-center">
                        <button type="submit" name="submit" class="btn btn-primary">اضافة السيارة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>
        $(function() {
            $('#product_images').fileinput({
                theme: "fas",
                maxFileCount: 10,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
            });
        });
    </script>

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
                    '{{ old('country_id') }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('admin.buildingProducts.get_state') }}", {
                    country_id: countryIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#state_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#state_id').append($('<option></option>').val('').html('---'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id == '{{ old('state_id') }}' ? "selected" : "";
                        $("#state_id").append($('<option ' + selectedVal + '></option>').val(text
                            .id).html(text.name));
                    });
                }, "json")

            }

            function populateCities() {
                let stateIdVal = $('#state_id').val() != null ? $('#state_id').val() :
                '{{ old('state_id') }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('admin.buildingProducts.get_city') }}", {
                    state_id: stateIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#city_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#city_id').append($('<option></option>').val('').html('---'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id == '{{ old('city_id') }}' ? "selected" : "";
                        $("#city_id").append($('<option ' + selectedVal + '></option>').val(text.id)
                            .html(text.name));
                    });
                }, "json")
            }

        });
    </script>
@endsection
