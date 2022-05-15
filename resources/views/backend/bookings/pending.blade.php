@extends('layouts.auth_admin_app')

@section('title', 'الحجوزات (قائمة الانتظار)')

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
        .input-booking {
            width: 100%;
            height: 42px;
            border: 1px solid #ebebeb;
            border-radius: 8px;
            box-shadow: 0px 0px 10px #dddddd;
            outline: none;
            margin: 0px 0px 15px;
        }
        label {
            margin: 14px 0px 0px 0px;
        }
    </style>
@endsection

@section('content')

    <div class="container">
        <div class="row ">
            <div class="col-6 d-flex text-left">
                <h1 class=" text-left">الحجوزات (قائمة الانتظار)</h1>
            </div>
        </div>

        @include('backend.bookings.filter')

        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-hover table-striped table-light yajra-datatable">
                    <thead class="table-dark ">
                        <tr class="text-light">
                            <th class="text-light">No</th>
                            <th class="text-light">الاسم</th>
                            <th class="text-light">الخدمة</th>
                            <th class="text-light">موعد الحجز</th>
                            <th class="text-light">عنوان المرسل</th>
                            <th class="text-light">البريد الالكتروني - رقم الهاتف</th>
                            <th class="text-light">الرسالة</th>
                            <th class="text-light">تاريخ الرسالة</th>
                            <th class="text-light">الحالة</th>
                            <th class="text-light">العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $k => $booking)
                            @if ($booking->day != date('Y-m-d') )
                                <tr data-entry-id="{{ $booking->id }}">
                                    <td class="text-left">{{ $loop->index + 1 }}</td>
                                    <td class="text-center">{{ $booking->name }}</td>
                                    <td>
                                        <p class="text-gray-400"><b>{{ $booking->category->name }}</b></p>
                                        <a>{{ $booking->product_id != '' ? $booking->product->name : '' }}</a>
                                    </td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($booking->day)->translatedFormat('l j F Y') }} - {{ date('h:i A', strtotime($booking->start)) }}</td>
                                    <td class="text-center">
                                        @if ($booking->country_id != '')
                                            @if ($booking->city_id != '' && $booking->state_id != '')
                                                    {{ $booking->country->name .' - ' .$booking->state->name .' - ' .$booking->city->name }}
                                            @elseif ($booking->state_id != '')
                                                    {{ $booking->country->name . ' - ' . $booking->state->name }}
                                            @else
                                                {{ $booking->country->name }}
                                            @endif
                                        @else
                                            ---
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <p class="text-gray-400"><b>{{ $booking->mobile }}</b></p>
                                        <a>{{ $booking->email }}</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="nav-link" class="btn btn-info btn-lg" data-toggle="modal"
                                            data-target="#myModalMessage">عرض الرسالة</a>
                                        <!-- start modal -->
                                        <div class="modal fade" id="myModalMessage" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content text-center">
                                                    <div class="modal-header">
                                                        <div class="row" style="width: 100% !important">
                                                            <div class="col-9 text-left">
                                                                <h3>{{ \Carbon\Carbon::parse($booking->created_at)->translatedFormat('l j F Y H:i a') }}</h3>
                                                            </div>
                                                            <div class="col-3 text-right">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label class="control-label">اسم العميل</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input  value="{{ $booking->name }}" class="input-booking" readonly >
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label class="control-label">رقم الهاتف</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input  value="{{ $booking->mobile }}" class="input-booking" readonly >
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label class="control-label">البريد الالكتروني</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input  value="{{ $booking->email }}" class="input-booking" readonly >
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label class="control-label">ميعاد الحجز</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input  value="{{ \Carbon\Carbon::parse($booking->day)->translatedFormat('l j F Y') }} - {{ date('h:i A', strtotime($booking->start)) }}" class="input-booking" readonly style="color: orange;" >
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label class="control-label">نوع الخدمة</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input  value="{{ $booking->category->name }}" class="input-booking" readonly style="color: orange;"  >
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label class="control-label">الخدمة</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input  value="{{ $booking->product_id != '' ? $booking->product->name : '' }}" class="input-booking" readonly style="color: orange;"  >
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label class="control-label">عنوان المرسل</label>
                                                            </div>
                                                            <div class="col-9">
                                                                @if ($booking->country_id != '')
                                                                    @if ($booking->city_id != '' && $booking->state_id != '')
                                                                        @php $address = $booking->country->name .' - ' .$booking->state->name .' - ' .$booking->city->name @endphp
                                                                    @elseif ($booking->state_id != '')
                                                                        @php $address = $booking->country->name . ' - ' . $booking->state->name @endphp
                                                                    @else
                                                                        @php $address = $booking->country->name @endphp
                                                                    @endif
                                                                @else
                                                                    @php $address = '---' @endphp
                                                                @endif
                                                                <input  value="{{ $address }}" class="input-booking" readonly >
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label class="control-label">عنوان الرسالة</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input  value="{{ $booking->subject }}" class="input-booking" readonly >
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <textarea  class="input-booking" readonly >{{ $booking->message }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end modal -->
                                    </td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($booking->created_at)->translatedFormat('l j F Y H:i a') }}</td>
                                    <td class="text-center">
                                        <span class="switch switch-icon">
                                            <label>
                                                <input data-id="{{ $booking->id }}" class="status-class" type="checkbox"
                                                    data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                                                    data-on="On" data-width="40" data-height="30" data-off="Off"
                                                    {{ $booking->status == 1 ? 'checked' : '' }}>
                                                <span></span>
                                            </label>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div style="display: flex" class="text-center justify-content-between">
                                            @ability('superAdmin', 'manage_contactUs_messages,show_contactUs_messages')
                                            <a href="javascript:void(0)" onclick="
                                                                if (confirm('Are You Sure You Want To Delete This Record ?') )
                                                                    { document.getElementById('record_delete_{{ $booking->id }}').submit(); }
                                                                else
                                                                    { return false; }" class="btn btn-danger"><i
                                                    class="fa fa-trash"></i>
                                            </a>
                                            @endability
                                        </div>
                                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="post"
                                            id="record_delete_{{ $booking->id }}" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            {{-- @elseif ($booking->day == date('Y-m-d') && $booking->start > date('h:i A')) --}}
                            @elseif ( (date('h:i A', strtotime($booking->start))) > date('h:i A', strtotime('+2 hours')) )
                                <tr data-entry-id="{{ $booking->id }}">
                                    <td class="text-left">{{ $loop->index + 1 }}</td>
                                    <td class="text-center">{{ $booking->name }}</td>
                                    <td>
                                        <p class="text-gray-400"><b>{{ $booking->category->name }}</b></p>
                                        <a>{{ $booking->product_id != '' ? $booking->product->name : '' }}</a>
                                    </td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($booking->day)->translatedFormat('l j F Y') }} - {{ date('h:i A', strtotime($booking->start)) }}</td>
                                    <td class="text-center">
                                        @if ($booking->country_id != '')
                                            @if ($booking->city_id != '' && $booking->state_id != '')
                                                    {{ $booking->country->name .' - ' .$booking->state->name .' - ' .$booking->city->name }}
                                            @elseif ($booking->state_id != '')
                                                    {{ $booking->country->name . ' - ' . $booking->state->name }}
                                            @else
                                                {{ $booking->country->name }}
                                            @endif
                                        @else
                                            ---
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <p class="text-gray-400"><b>{{ $booking->mobile }}</b></p>
                                        <a>{{ $booking->email }}</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="nav-link" class="btn btn-info btn-lg" data-toggle="modal"
                                            data-target="#myModalMessage">عرض الرسالة</a>
                                        <!-- start modal -->
                                        <div class="modal fade" id="myModalMessage" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content text-center">
                                                    <div class="modal-header">
                                                        <div class="row" style="width: 100% !important">
                                                            <div class="col-9 text-left">
                                                                <h3>{{ \Carbon\Carbon::parse($booking->created_at)->translatedFormat('l j F Y H:i a') }}</h3>
                                                            </div>
                                                            <div class="col-3 text-right">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label class="control-label">اسم العميل</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input  value="{{ $booking->name }}" class="input-booking" readonly >
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label class="control-label">رقم الهاتف</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input  value="{{ $booking->mobile }}" class="input-booking" readonly >
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label class="control-label">البريد الالكتروني</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input  value="{{ $booking->email }}" class="input-booking" readonly >
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label class="control-label">ميعاد الحجز</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input  value="{{ \Carbon\Carbon::parse($booking->day)->translatedFormat('l j F Y') }} - {{ date('h:i A', strtotime($booking->start)) }}" class="input-booking" readonly style="color: orange;" >
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label class="control-label">نوع الخدمة</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input  value="{{ $booking->category->name }}" class="input-booking" readonly style="color: orange;"  >
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label class="control-label">الخدمة</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input  value="{{ $booking->product_id != '' ? $booking->product->name : '' }}" class="input-booking" readonly style="color: orange;"  >
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label class="control-label">عنوان المرسل</label>
                                                            </div>
                                                            <div class="col-9">
                                                                @if ($booking->country_id != '')
                                                                    @if ($booking->city_id != '' && $booking->state_id != '')
                                                                        @php $address = $booking->country->name .' - ' .$booking->state->name .' - ' .$booking->city->name @endphp
                                                                    @elseif ($booking->state_id != '')
                                                                        @php $address = $booking->country->name . ' - ' . $booking->state->name @endphp
                                                                    @else
                                                                        @php $address = $booking->country->name @endphp
                                                                    @endif
                                                                @else
                                                                    @php $address = '---' @endphp
                                                                @endif
                                                                <input  value="{{ $address }}" class="input-booking" readonly >
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label class="control-label">عنوان الرسالة</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input  value="{{ $booking->subject }}" class="input-booking" readonly >
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <textarea  class="input-booking" readonly >{{ $booking->message }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end modal -->
                                    </td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($booking->created_at)->translatedFormat('l j F Y H:i a') }}</td>
                                    <td class="text-center">
                                        <span class="switch switch-icon">
                                            <label>
                                                <input data-id="{{ $booking->id }}" class="status-class" type="checkbox"
                                                    data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                                                    data-on="On" data-width="40" data-height="30" data-off="Off"
                                                    {{ $booking->status == 1 ? 'checked' : '' }}>
                                                <span></span>
                                            </label>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div style="display: flex" class="text-center justify-content-between">
                                            @ability('superAdmin', 'manage_contactUs_messages,show_contactUs_messages')
                                            <a href="javascript:void(0)" onclick="
                                                                if (confirm('Are You Sure You Want To Delete This Record ?') )
                                                                    { document.getElementById('record_delete_{{ $booking->id }}').submit(); }
                                                                else
                                                                    { return false; }" class="btn btn-danger"><i
                                                    class="fa fa-trash"></i>
                                            </a>
                                            @endability
                                        </div>
                                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="post"
                                            id="record_delete_{{ $booking->id }}" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {!! $bookings->appends(request()->input())->links() !!}
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
                        url: "{{ route('admin.bookings.massDestroy') }}",
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
                    url: '{{ route('admin.bookings.changeStatus') }}',
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
