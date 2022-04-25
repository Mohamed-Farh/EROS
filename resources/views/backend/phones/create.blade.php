@extends('layouts.auth_admin_app')

@section('title', 'الهاتف')

@section('content')

    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <div class="col-6">
                    <h6 class="m-0 font-weight-bold text-primary">الهاتف</h6>
                </div>
                <div class="col-6 text-right">
                    <a href="{{ route('admin.phones.index') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-home"></i>
                        </span>
                        <span class="text">الهاتف</span>
                    </a>
                </div>
            </div>
            <div class="card-body">

                <form action="{{ route('admin.phones.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="number">رقم الهاتف</label>
                                <input type="text" name="number" value="{{ old('number') }}" class="form-control">
                                @error('number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="type">النوع</label>
                            <select name="type" class="form-control">
                                <option value="WhatsApp" {{ old('type') == 'WhatsApp' ? 'selected' : null }}>WhatsApp
                                </option>
                                <option value="Phone" {{ old('type') == 'Phone' ? 'selected' : null }}>Phone</option>
                            </select>
                            @error('type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="status">الحالة</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ old('status') == 1 ? 'selected' : null }}>نشط</option>
                                <option value="0" {{ old('status') == 0 ? 'selected' : null }}>غير نشط</option>
                            </select>
                            @error('status')
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
