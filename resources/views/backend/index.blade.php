@extends('layouts.auth_admin_app')

@section('title', 'Dashboard')

@section('content')


    @php
        $customerCount = \App\Models\User::whereHas('roles', function($query){
            $query->where('name', 'customer');
        })->count();
        $buildingCount = \App\Models\BuildingProduct::count();
        $carCount = \App\Models\CarProduct::count();
        $productCount = \App\Models\Product::count();
        $jobCount = \App\Models\job::count();
        $medicalCount = \App\Models\Medical::count();
    @endphp

    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">

        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Dashboard-->
                <div class="row">

                    <div class="col-lg-4 col-xxl-4">
                        <!--begin::Stats Widget 11-->
                        <div class="card card-custom card-stretch card-stretch-half gutter-b">
                            <!--begin::Body-->
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                    <span class="symbol symbol-50 symbol-light-success mr-2">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-success">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                                <i class="fas fa-user-tie"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    </span>
                                    <div class="d-flex flex-column text-right">
                                        <span class="text-dark-75 font-weight-bolder font-size-h3">{{ $customerCount }}</span>
                                        <span class="text-muted font-weight-bold mt-2">المستخدمين</span>
                                    </div>
                                </div>
                                <div class="card-rounded-bottom" data-color="success" style="height: 150px">
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 11-->

                        <!--begin::Stats Widget 12-->
                        <div class="card card-custom card-stretch card-stretch-half gutter-b">
                            <!--begin::Body-->
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                    <span class="symbol symbol-50 symbol-light-primary mr-2">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group.svg-->
                                                <i class="fas fa-car-side"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    </span>
                                    <div class="d-flex flex-column text-right">
                                        <span class="text-dark-75 font-weight-bolder font-size-h3">{{ $carCount }}</span>
                                        <span class="text-muted font-weight-bold mt-2">السيارات</span>
                                    </div>
                                </div>
                                <div class="card-rounded-bottom" data-color="primary" style="height: 150px"></div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 12-->
                    </div>


                    <div class="col-lg-4 col-xxl-4">
                        <!--begin::Stats Widget 11-->
                        <div class="card card-custom card-stretch card-stretch-half gutter-b">
                            <!--begin::Body-->
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                    <span class="symbol symbol-50 symbol-light-success mr-2">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-success">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                                <i class="fas fa-city"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    </span>
                                    <div class="d-flex flex-column text-right">
                                        <span class="text-dark-75 font-weight-bolder font-size-h3">{{ $buildingCount }}</span>
                                        <span class="text-muted font-weight-bold mt-2">العقارات</span>
                                    </div>
                                </div>
                                <div class="card-rounded-bottom" data-color="success" style="height: 150px">
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 11-->

                        <!--begin::Stats Widget 12-->
                        <div class="card card-custom card-stretch card-stretch-half gutter-b">
                            <!--begin::Body-->
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                    <span class="symbol symbol-50 symbol-light-primary mr-2">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group.svg-->
                                                <i class="fas fa-tshirt"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    </span>
                                    <div class="d-flex flex-column text-right">
                                        <span class="text-dark-75 font-weight-bolder font-size-h3">{{ $productCount }}</span>
                                        <span class="text-muted font-weight-bold mt-2">المنتجات</span>
                                    </div>
                                </div>
                                <div class="card-rounded-bottom" data-color="primary" style="height: 150px"></div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 12-->
                    </div>


                    <div class="col-lg-4 col-xxl-4">
                        <!--begin::Stats Widget 11-->
                        <div class="card card-custom card-stretch card-stretch-half gutter-b">
                            <!--begin::Body-->
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                    <span class="symbol symbol-50 symbol-light-success mr-2">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-success">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                                <i class="fas fa-clinic-medical"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    </span>
                                    <div class="d-flex flex-column text-right">
                                        <span class="text-dark-75 font-weight-bolder font-size-h3">{{ $medicalCount }}</span>
                                        <span class="text-muted font-weight-bold mt-2">الخدمات الطبية</span>
                                    </div>
                                </div>
                                <div class="card-rounded-bottom" data-color="success" style="height: 150px">
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 11-->

                        <!--begin::Stats Widget 12-->
                        <div class="card card-custom card-stretch card-stretch-half gutter-b">
                            <!--begin::Body-->
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                    <span class="symbol symbol-50 symbol-light-primary mr-2">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group.svg-->
                                                <i class="fas fa-briefcase"></i>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    </span>
                                    <div class="d-flex flex-column text-right">
                                        <span class="text-dark-75 font-weight-bolder font-size-h3">{{ $jobCount }}</span>
                                        <span class="text-muted font-weight-bold mt-2">الوظائف</span>
                                    </div>
                                </div>
                                <div class="card-rounded-bottom" data-color="primary" style="height: 150px"></div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 12-->
                    </div>

                </div>
                <!--end::Dashboard-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <!--end::Content-->


@endsection
