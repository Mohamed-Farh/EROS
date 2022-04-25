@extends('layouts.auth_admin_app')

@section('title', 'السيارات')

@section('style')
    <style>
        table.dataTable tbody td.select-checkbox:before,
        table.dataTable tbody th.select-checkbox:before {
            content: " ";
            margin-top: 22px;
            margin-left: 0;
            border: 1px solid darkblue;
            border-radius: 3px;
        }

        table.dataTable tr.selected td.select-checkbox:after,
        table.dataTable tr.selected th.select-checkbox:after {
            content: "✓";
            font-size: 20px;
            margin-top: 6px;
            margin-left: 0px;
            text-align: center;
            text-shadow: 1px 1px #b0bed9, -1px -1px #b0bed9, 1px -1px #b0bed9, -1px 1px #b0bed9;
        }
    </style>
@endsection

@section('content')

    <div class="container">
        <div class="row mb-10">
            <div class="col-6 d-flex text-left">
                <h1 class=" text-left">السيارات</h1>
            </div>
            <div class="col-6 d-flex justify-content-end">
                @ability('superAdmin', 'manage_carProducts,create_carProducts')
                <a href="{{ route('admin.carProducts.create', ['carCategory' => $carCategory]) }}" class="btn btn-primary font-weight-bolder">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <circle fill="#000000" cx="9" cy="15" r="6" />
                                <path
                                    d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                    fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    عنصر جديد
                </a>
                @endability
            </div>
        </div>

        {{-- @include('backend.carCategory_products.filter') --}}

        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-hover table-striped table-light yajra-datatable">
                    <thead class="table-dark ">
                        <tr class="text-light">
                            <th class="text-light">No</th>
                            <th class="text-light">الصور</th>
                            <th class="text-light">الاسم</th>
                            <th class="text-light">العميل | صاحب الاعلان</th>
                            <th class="text-light">الماركة</th>
                            <th class="text-light">اللون</th>
                            <th class="text-light">بيع-ابجار</th>
                            <th class="text-light">السعر</th>
                            <th class="text-light">العنوان</th>
                            <th class="text-light">المسافة</th>
                            <th class="text-light">الهاتف</th>
                            <th class="text-light">الحالة</th>
                            <th class="text-light">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($carProducts as $k => $carProduct)
                            <tr data-entry-id="{{ $carProduct->id }}">
                                <td></td>
                                <td class="text-center">
                                    @if ($carProduct->firstMedia)
                                        <img class="rounded" src="{{ asset($carProduct->firstMedia->file_name) }}" width="90" height="60" alt="{{ $carProduct->name }}">
                                    @else
                                        <img class="rounded" src="{{ asset('assets/no_image.png')}}" width="60" height="90" alt="{{ $carProduct->name }}">
                                    @endif
                                </td>
                                <td class="text-center">{{ $carProduct->name }}</td>
                                <td class="text-center">
                                    {{ $carProduct->user->first_name .' '. $carProduct->user->last_name }}
                                    <p class="text-gray-400">{{ $carProduct->user->email }}<br>{{ $carProduct->user->mobile }}</p>
                                </td>
                                <td class="text-center">
                                    {{ $carProduct->carType->name }}
                                    <p class="text-gray-400">{{ $carProduct->year }}</p>
                                </td>
                                <td class="text-center">{{ $carProduct->color }}</td>
                                <td class="text-center">{{ $carProduct->rent == 1 ? 'ايجار' : 'بيع'}}</td>
                                <td class="text-center">{{ $carProduct->price }}</td>
                                <td class="text-center">
                                    @if($carProduct->country)
                                        {{ $carProduct->country->name .' - '. $carProduct->state->name .' - '. $carProduct->city->name }}
                                    @else
                                        {{__('كل الدول') }}
                                    @endif
                                </td>
                                <td class="text-center">{{ $carProduct->distance }}</td>
                                <td class="text-center">{{ $carProduct->phone }}</td>
                                <td class="text-center">
                                    <span class="switch switch-icon">
                                        <label>
                                            <input data-id="{{ $carProduct->id }}" class="status-class" type="checkbox"
                                                data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="On"
                                                data-width="40" data-height="30" data-off="Off"
                                                {{ $carProduct->status == 1 ? 'checked' : '' }}>
                                            <span></span>
                                        </label>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div style="display: flex" class="text-center justify-content-between">
                                        @ability('superAdmin', 'manage_carProducts,update_carProducts')
                                            <a href="{{ route('admin.carProducts.edit', $carProduct->id) }}"
                                                class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i>
                                            </a>
                                        @endability

                                        @ability('superAdmin', 'manage_carProducts,delete_carProducts')
                                            <a href="javascript:void(0)"
                                                onclick="
                                                    if (confirm('Are You Sure You Want To Delete This Record ?') )
                                                        { document.getElementById('record_delete_{{ $carProduct->id }}').submit(); }
                                                    else
                                                        { return false; }"
                                                class="btn btn-danger"><i class="fa fa-trash"></i>
                                            </a>
                                        @endability
                                    </div>
                                    <form action="{{ route('admin.carProducts.destroy', $carProduct->id) }}" method="post" id="record_delete_{{ $carProduct->id }}" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {!! $carProducts->appends(request()->input())->links() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>

    <script type="text/javascript">
        $(function() {
            let languages = {
                'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
            };
            var table = $('.yajra-datatable').DataTable({
                language: {
                    url: languages['{{ app()->getLocale() }}']
                },
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0
                }, {
                    orderable: false,
                    searchable: false,
                    targets: -1
                }],
                select: {
                    style: 'multi+shift',
                    selector: 'td:first-child'
                },
                order: [],
                scrollX: false,
                dom: 'lBfrtip<"actions">',
                buttons: [{
                        extend: 'copy',
                        className: 'btn btn-light-primary px-6 font-weight-bold ml-20',
                        text: 'Copy',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        className: 'btn btn-light-primary px-6 font-weight-bold',
                        text: 'CSV',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-light-primary px-6 font-weight-bold',
                        text: 'Excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-light-primary px-6 font-weight-bold',
                        text: 'PDF',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-light-warning px-6 font-weight-bold',
                        text: 'Printf',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        className: 'btn btn-light-success px-6 font-weight-bold',
                        text: 'Column Visible',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'selectAll',
                        className: 'btn btn-light-primary px-6 font-weight-bold',
                    },
                    {
                        extend: 'selectNone',
                        className: 'btn btn-light-primary px-6 font-weight-bold',
                    },
                    {
                        className: 'btn btn-light-danger px-6 font-weight-bold',
                        text: 'Delete All',
                        url: "{{ route('admin.carProducts.massDestroy') }}",
                        action: function(e, dt, node, config) {

                            var ids = $.map(dt.rows({
                                selected: true
                            }).nodes(), function(entry) {
                                return $(entry).data('entry-id')
                            });

                            if (ids.length === 0) {
                                Swal.fire('No Data Selected')
                                return
                            }
                            Swal.fire({
                                title: 'Do You Want To Save This Changes?',
                                showDenyButton: true,
                                showCancelButton: true,
                                confirmButtonText: 'Save',
                                denyButtonText: `Don't save`,
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $(
                                                'meta[name="csrf-token"]').attr(
                                                'content')
                                        }
                                    })
                                    $.ajax({
                                            // headers: {'x-csrf-token': _token},
                                            method: 'POST',
                                            url: config.url,
                                            data: {
                                                ids: ids,
                                                _method: 'POST'
                                            }
                                        })
                                        .done(function() {
                                            location.reload()
                                        })
                                    Swal.fire('Saved!', '', 'success')
                                } else if (result.isDenied) {
                                    Swal.fire('Changes are not saved', '', 'info')
                                }
                            })
                        }
                    }
                ],
            });
        });
    </script>


    <script>
        $(function () {
            $('.status-class').change(function() {
                console.log("success");
                var status = $(this).prop('checked') == true ? 1 : 0;
                var cat_id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('admin.carProducts.updateStatus') }}',
                    data: {
                        'status': status,
                        'cat_id': cat_id
                    },
                    success: function(data) {
                        Swal.fire({
                            title: 'Status Change Successfully',
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            }
                        })
                    }
                });
            })
        });
    </script>


@endsection
