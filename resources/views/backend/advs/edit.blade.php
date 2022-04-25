@extends('layouts.auth_admin_app')

@section('title', 'تعديل الاعلان')

@section('style')
    <link rel="stylesheet" href="{{ asset('backend/vendor/select2/css/select2.min.css') }}">
@endsection

@section('content')

    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <div class="col-6">
                    <h6 class="m-0 font-weight-bold text-primary">تعديل الاعلان</h6>
                </div>
                <div class="col-6 text-right">
                    <a href="{{ route('admin.advs.index') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-home"></i>
                        </span>
                        <span class="text">الاعلانات</span>
                    </a>
                </div>
            </div>
            <div class="card-body">

                <form action="{{ route('admin.advs.update', $adv->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="name">اسم الاعلان</label>
                                <input type="text" name="name" value="{{ old('name', $adv->name) }}"
                                    class="form-control">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <label for="category">القسم التابع له</label>
                            <select name="category" class="form-control">
                                <option value="عام" {{ old('category', $adv->category) == 'عام' ? 'selected' : null }}>عام</option>
                                <option value="عقارات" {{ old('category', $adv->category) == 'عقارات' ? 'selected' : null }}>عقارات</option>
                                <option value="سيارات" {{ old('category', $adv->category) == 'سيارات' ? 'selected' : null }}>سيارات</option>
                                <option value="منتجات" {{ old('category', $adv->category) == 'منتجات' ? 'selected' : null }}>منتجات</option>
                                <option value="خدمات طبية" {{ old('category', $adv->category) == 'خدمات طبية' ? 'selected' : null }}>خدمات طبية</option>
                                <option value="وظائف" {{ old('category', $adv->category) == 'وظائف' ? 'selected' : null }}>وظائف</option>
                                <option value="اخري" {{ old('category', $adv->category) == 'اخري' ? 'selected' : null }}>اخري</option>
                            </select>
                            @error('category')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-4">
                            <label for="status">الحالة</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ old('status', $adv->status) == 1 ? 'selected' : null }}>نشط
                                </option>
                                <option value="0" {{ old('status', $adv->status) == 0 ? 'selected' : null }}>غير نشط
                                </option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="user_id">اسم العميل | صاحب الاعلان</label>
                                <input type="text" name="customer_name"
                                    value="{{ $adv->user->full_name }}" class="form-control" readonly>
                                <input type="hidden" name="user_id" id="user_id" class="form-control"
                                    value="{{ $adv->user->id  }}" readonly>
                                @error('user_id')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <label for="description">وصف الاعلان</label>
                            <textarea name="description" rows="5" class="form-control">{!! old('description', $adv->description) !!}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-6">
                        <div class="col-4">
                            <label for="quantity">الكمية</label>
                            <input type="number" name="quantity" value="{{ old('quantity', $adv->quantity) }}"
                                class="form-control" min="0">
                            @error('quantity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-4">
                            <label for="price">السعر</label>
                            <input type="number" name="price" value="{{ old('price', $adv->price) }}"
                                class="form-control" min="0">
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-4">
                            <label for="featured">مميز</label>
                            <select name="featured" class="form-control">
                                <option value="1" {{ old('featured', $adv->featured) == 1 ? 'selected' : null }}>نعم
                                </option>
                                <option value="0" {{ old('featured', $adv->featured) == 0 ? 'selected' : null }}>لا
                                </option>
                            </select>
                            @error('featured')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-6">
                        <div class="col-4">
                            <label for="start_date">تاريخ بداية الاعلان</label>
                            <input type="date" name="start_date"
                                value="{{ Carbon\Carbon::parse($adv->start_date)->format('Y-m-d') }}"
                                class="form-control" min="0">
                            @error('start_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="end_date">تاريخ انتهاء الاعلان</label>
                            <input type="date" name="end_date"
                                value="{{ Carbon\Carbon::parse($adv->end_date)->format('Y-m-d') }}"
                                class="form-control" min="0">
                            @error('end_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="phone">رقم الهاتف</label>
                            <input type="text" name="phone" value="{{ old('phone', $adv->phone) }}"
                                class="form-control" min="0">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-6">
                        <div class="col-4">
                            <label for="country_id">الدولة</label>
                            <select name="country_id" class="form-control" id="country_id">
                                <option value="">كل الدول</option>
                                @forelse (\App\Models\Country::wherestatus('1')->get(['id', 'name']) as $country)
                                    <option value="{{ $country->id }}"
                                        {{ old('country_id', $adv->country_id) == $country->id ? 'selected' : null }}>
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
                        <div class="col-12 mt-6">
                            <label for="description">وصف تفصيلي للعنوان</label>
                            <textarea name="description" rows="5" class="form-control">{!! old('description', $adv->description) !!}</textarea>
                            @error('description')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="row pt-4 mt-4">
                        <div class="col-12">
                            <div class="form-group file-loading">
                                <label for="images">صور الاعلان</label>
                                <input type="file" name="images[]" id="adv_images" class="file-input-overview"
                                    multiple="multiple">
                                <span class="form-text text-muted">Image Width Should be (500px) X (500px)</span>
                                @error('images')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group pt-4 text-center">
                        <button type="submit" name="submit" class="btn btn-primary">تعديل الاعلانات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script src="{{ asset('backend/vendor/select2/js/select2.full.min.js') }}"></script>
    <script>
        function matchCustom(params, data) {
            // If there are no search terms, return all of the data
            if ($.trim(params.term) === '') {
                return data;
            }

            // Do not display the item if there is no 'text' property
            if (typeof data.text === 'undefined') {
                return null;
            }

            // `params.term` should be the term that is used for searching
            // `data.text` is the text that is displayed for the data object
            if (data.text.indexOf(params.term) > -1) {
                var modifiedData = $.extend({}, data, true);
                modifiedData.text += ' (matched)';

                // You can return modified objects from here
                // This includes matching the `children` how you want in nested data sets
                return modifiedData;
            }

            // Return `null` if the term should not be displayed
            return null;
        }

        $(".select2").select2({
            tags: true,
            closeOnSelect: false,
            minimumResultForsearch: Infinity,
            matcher: matchCustom
        });

        $(function() {
            $('.summernote').summernote({
                tabSize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            $('#adv_images').fileinput({
                theme: "fas",
                maxFileCount: {{ 10 - $adv->media->count() }},
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @if ($adv->media->count() > 0)
                        @foreach ($adv->media as $media)
                            "{{ asset($media->file_name) }}",
                        @endforeach
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($adv->media->count() > 0)
                        @foreach ($adv->media as $media)
                            {
                            caption: "{{ $media->file_name }}",
                            size: {{ $media->file_size }},
                            width: "120px",
                            url:
                            "{{ route('admin.advs.removeImage', ['image_id' => $media->id,'adv_id' => $adv->id,'_token' => csrf_token()]) }}",
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
                    '{{ old('country_id', $adv->country_id) }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('admin.backend.get_state') }}", {
                    country_id: countryIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#state_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#state_id').append($('<option></option>').val('').html('---'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id ==
                            '{{ old('state_id', $adv->state_id) }}' ? "selected" :
                            "";
                        $("#state_id").append($('<option ' + selectedVal + '></option>').val(text
                            .id).html(text.name));
                    });
                }, "json")

            }

            function populateCities() {
                let stateIdVal = $('#state_id').val() != null ? $('#state_id').val() :
                    '{{ old('state_id', $adv->state_id) }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('admin.backend.get_city') }}", {
                    state_id: stateIdVal
                }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#city_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#city_id').append($('<option></option>').val('').html('---'));
                    $.each(data, function(val, text) {
                        let selectedVal = text.id ==
                            '{{ old('city_id', $adv->city_id) }}' ? "selected" : "";
                        $("#city_id").append($('<option ' + selectedVal + '></option>').val(text.id)
                            .html(text.name));
                    });
                }, "json")
            }

        });
    </script>
@endsection
