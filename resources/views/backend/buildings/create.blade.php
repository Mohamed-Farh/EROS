@extends('layouts.auth_admin_app')

@section('title', 'انشاء فئة عقار جديدة')

@section('content')

<div class="container">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="col-6">
                <h3 class="m-0 font-weight-bold text-primary">{{__('انشاء فئة عقار جديدة') }}</h3>
            </div>
            <div class="col-6 text-right">
                <a href="{{ route('admin.buildings.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">{{__('فئات العقارات') }}</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.buildings.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-9">
                        <div class="form-group">
                            <label for="name">اسم الفئة</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3" hidden>
                        <label for="parent_id">Category Parent</label>
                        <input type="text" name="parent_id" value="1" class="form-control">
                        @error('parent_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-3">
                        <label for="status">الحالة</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status') == 1 ? 'selected' : null }}>نشط</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : null }}>غير نشط</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-12">
                        <label for="description">الوصف</label>
                        <textarea name="description" class="form-control" rows="5"></textarea>
                        @error('description')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row pt-4">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="cover">صورة</label>
                            <input type="file" name="cover" id="category_image" class="file-input-overview">
                            <span class="form-text text-muted">Image Width Should be (500px) X (500px)</span>
                            @error('cover')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
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
        $(function () {
            $('#category_image').fileinput({
                theme: "fas",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
            });
        });
    </script>
@endsection
