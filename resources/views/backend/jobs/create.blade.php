@extends('layouts.auth_admin_app')

@section('title', 'انشاء وظيفة جديدة')

@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <div class="col-6">
                    <h3 class="m-0 font-weight-bold text-primary">{{ __('انشاء وظيفة جديدة') }}</h3>
                </div>
                <div class="col-6 text-right">
                    <a href="{{ route('admin.jobs.index') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-home"></i>
                        </span>
                        <span class="text">{{ __('الوظائف') }}</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.jobs.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-9">
                            <div class="form-group">
                                <label for="name">اسم الوظيفة</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <label for="gender">النوع</label>
                            <select name="gender" class="form-control">
                                <option value="1" {{ old('gender') == 1 ? 'selected' : null }}>ذكر</option>
                                <option value="0" {{ old('gender') == 0 ? 'selected' : null }}>أنثي</option>
                            </select>
                            @error('gender')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
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
                        <div class="col-6">
                            <div class="form-group">
                                <label for="job_category_id">قسم الوظيفة</label>
                                <select name="job_category_id" class="form-control" id="job_category_id" required>
                                    <option value="">---</option>
                                    @forelse ($jobCategories as $jobCategory)
                                        <option value="{{ $jobCategory->id }}"
                                            {{ old('job_category_id') == $jobCategory->id ? 'selected' : null }}>
                                            {{ $jobCategory->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="phone">رقم الهاتف او الواتس</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" required>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <label for="speciality">التخصص</label>
                            <input type="text" name="speciality" value="{{ old('speciality') }}" class="form-control"
                                required>
                            @error('speciality')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="exp_years">سنوات الخبرة</label>
                            <input type="number" name="exp_years" value="{{ old('exp_years') }}" class="form-control"
                                min="1" max="70" required>
                            @error('exp_years')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="status">حالة الوظيفة</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ old('status') == 1 ? 'selected' : null }}>نشط</option>
                                <option value="0" {{ old('status') == 0 ? 'selected' : null }}>غير نشط</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <label for="description">تفاصيل او نبذة</label>
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
                    <div class="form-group pt-4 text-center">
                        <button type="submit" name="submit" class="btn btn-primary">اضافة البيانات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
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
                $.get("{{ route('admin.backend.get_state') }}", {
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
                $.get("{{ route('admin.backend.get_city') }}", {
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
