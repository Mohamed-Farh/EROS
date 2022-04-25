@extends('layouts.frontend_app')

@section('title', $medical->name)

@section('content')

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
            <!-- Add medical-->
            <form action="{{ route('frontend.profileUpdateMedicalDoctor', ['id' => $medical]) }}" method="post">
                @csrf
                <div class="add-doctors-ads-sec py-4 text-center">
                    <h4 class="text-center pb-3">{{ $medical->name }}</h4>
                    <div class="row mt-2">
                        <div class="col-12 mt-2">
                            <input type="text" name="name" value="{{ old('name', $medical->name) }}" placeholder="اسم الدكتور"
                                class="form-control addForm" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mt-2">
                            <select name="medical_type" class="form-control addForm">
                                <option value="Doctor" {{ old('medical_type', $medical->medical_type) == 'Doctor' ? 'selected' : null }}>
                                    دكتور|دكتورة</option>
                                <option value="Nurse" {{ old('medical_type', $medical->medical_type) == 'Nurse' ? 'selected' : null }}>ممرض|ممرضة
                                </option>
                            </select>
                            @error('medical_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mt-2">
                            <select name="gender" class="form-control addForm">
                                <option value="1" {{ old('gender', $medical->gender) == 1 ? 'selected' : null }}>ذكر</option>
                                <option value="0" {{ old('gender', $medical->gender) == 0 ? 'selected' : null }}>أنثي</option>
                            </select>
                            @error('gender')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mt-2">
                            <input type="number" name="exp_years" value="{{ old('exp_years', $medical->exp_years) }}" placeholder="سنوات الخبرة"
                                class="form-control addForm" min="1" max="70" required>
                            @error('exp_years')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mt-2">
                            <input type="text" name="speciality" value="{{ old('speciality', $medical->speciality) }}" placeholder="التخصص"
                                class="form-control addForm" required>
                            @error('speciality')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mt-2">
                            <input type="text" name="type" value="{{ old('type', $medical->type) }}" placeholder="المسمي الوظيفي"
                                class="form-control addForm" required>
                            @error('type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-12 mt-2">
                            <textarea name="description" rows="2" class="form-control addForm" placeholder="تفاصيل او نبذة"
                                required>{!! old('description', $medical->description) !!}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mt-2">
                            <textarea name="work_hours" rows="2" class="form-control addForm" placeholder="ساعات العمل"
                                required>{!! old('work_hours', $medical->work_hours) !!}</textarea>
                            @error('work_hours')
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
                                        {{ old('country_id', $medical->country_id) == $country->id ? 'selected' : null }}>
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
                            <select name="state_id" id="state_id" class="form-control addForm"
                                style="font-size: 0.8rem;">
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
                            <textarea name="address" rows="2" placeholder="العنوان بالتفصيل" class="form-control addForm"
                                required>{!! old('address', $medical->address) !!}</textarea>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="contact-sec-ads py-2">
                        <h6>للتواصل</h6>
                        <div class="row mt-1">
                            <div class="col-12">
                                <input type="text" name="phone" value="{{ old('phone', $medical->phone) }}"
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
                    '{{ old('country_id', $medical->country_id) }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('frontend.frontGetState') }}", {
                    country_id: countryIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#state_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#state_id').append($('<option></option>').val('').html('---'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id ==
                            '{{ old('state_id', $medical->state_id) }}' ? "selected" : "";
                        $("#state_id").append($('<option ' + selectedVal + '></option>').val(text
                            .id).html(text.name));
                    });
                }, "json")

            }

            function populateCities() {
                let stateIdVal = $('#state_id').val() != null ? $('#state_id').val() :
                    '{{ old('state_id', $medical->state_id) }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('frontend.frontGetCity') }}", {
                    state_id: stateIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#city_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#city_id').append($('<option></option>').val('').html('---'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id ==
                            '{{ old('city_id', $medical->city_id) }}' ? "selected" : "";
                        $("#city_id").append($('<option ' + selectedVal + '></option>').val(text.id)
                            .html(text.name));
                    });
                }, "json")
            }

        });
    </script>
@endsection
