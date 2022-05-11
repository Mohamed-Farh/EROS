@extends('layouts.auth_admin_app')

@section('title', 'انشاء نص لعنوان ')

@section('content')

    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <div class="col-6">
                    <h6 class="m-0 font-weight-bold text-primary">عنصر جديد</h6>
                </div>
                <div class="col-6 text-right">
                    <a href="{{ route('admin.page-titles.index') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-home"></i>
                        </span>
                        <span class="text">نصوص العناوين</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.page-titles.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-9">
                            <label for="page">الصفحة</label>
                            <select name="page" class="form-control">
                                <option value="تسجيل الدخول" {{ old('page') == "تسجيل الدخول" ? 'selected' : null }}>تسجيل الدخول</option>
                                <option value="انشاء حساب" {{ old('page') == "انشاء حساب" ? 'selected' : null }}>انشاء حساب</option>
                                <option value="الرئيسية (الخدمات)" {{ old('page') == "الرئيسية (الخدمات)" ? 'selected' : null }}>الرئيسية (الخدمات)</option>
                                <option value="الرئيسية (مقتراحاتك)" {{ old('page') == "الرئيسية (مقتراحاتك)" ? 'selected' : null }}>الرئيسية (مقتراحاتك)</option>
                                <option value="الخدمات" {{ old('page') == "الخدمات" ? 'selected' : null }}>الخدمات</option>
                                <option value="اتصل بنا" {{ old('page') == "اتصل بنا" ? 'selected' : null }}>اتصل بنا</option>
                                <option value="Footer" {{ old('page') == "Footer" ? 'selected' : null }}>Footer</option>
                            </select>
                            @error('page')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-3">
                            <label for="status">الحالة</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ old('status') == 1 ? 'selected' : null }}>نشط</option>
                                <option value="0" {{ old('status') == 0 ? 'selected' : null }}>غير نشط</option>
                            </select>
                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <label for="title">النص</label>
                            <textarea name="title" rows="5" class="form-control" >{!! old('title') !!}</textarea>
                            @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group pt-4 text-center">
                        <button type="submit" name="submit" class="btn btn-primary">حفظ البيانات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


