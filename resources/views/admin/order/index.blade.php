@extends('layouts.admin')
@section('title', 'Đơn hàng')
@section('content')
    <style>
        #kun {
            position: fixed;
            z-index: 200;
            top: 50%;
            right: 50%;
            font-size: 50px;
            display: none;
        }

    </style>

    <i id="kun" class="fas fa-spinner fa-pulse"></i>
    <div class="card">
        <div class="card-header  bg-cyan-200 text-light">
            <h2>Danh sách đơn hàng </h2>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    <nav class="navbar navbar-expand navbar-light bg-light">
                        <div class="col-md-2 me-auto">
                            {{-- <ul class="nav navbar-nav">
                                <li class="nav-item">
                                    <a data-bs-toggle="modal" data-bs-target="#modal_add_product"
                                        class="btn btn-success btn_add"><i class="fa-regular mr-2 fa-square-plus"></i>Thêm
                                        đơn hàng</a>
                                </li>
                            </ul> --}}
                        </div>
                        <div class="col-md-2">
                            <select id="select_status_filter" class="form-select">
                                <option value=0>Tất cả trạng thái</option>
                                <option class="text-bold text-warning" value="Mới">Đơn hàng mới</option>
                                <option class="text-bold text-primary" value="Đã xác nhận">Đã xác nhận</option>
                                <option class="text-bold text-info" value="Đã xử lý">Đã xử lý</option>
                                <option class="text-bold text-secondary" value="Đã gửi">Đã gửi</option>
                                <option class="text-bold text-success" value="Hoàn thành">Hoàn thành</option>
                                <option class="text-bold text-danger" value="Đã hủy">Đã hủy</option>
                            </select>
                        </div>
                        <div id="area_search" class="col-md-2" style="position: relative">
                            <input type="text" class="form-control ml-3" name="search" id="search_input"
                                placeholder="Nhập từ khóa" style="padding-right: 35px">
                            <i class="fa-solid fa-magnifying-glass text-muted" id="ico_search"
                                style="position: absolute; right: 0; top: 0.7rem;"></i>
                            <i class="fas fa-spinner fa-spin d-none text-muted" id="ani_search"
                                style="position: absolute; right: 0; top: 0.7rem;"></i>
                        </div>
                    </nav>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead class="bg-cyan-200 text-light">
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Thời gian</th>
                                <th>Tên khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody id="main_data">
                            @if ($orders->count() > 0)
                                @foreach ($orders as $order)
                                    <tr id="order-{{ $order->id }}">
                                        <td class="text-bold text-danger">{{ $order->code }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->name }}</td>
                                        <td class="text-bold">{{ $order->total }}đ</td>
                                        <td>
                                            <span class="badge 
                                                                @php
                                                                    if ($order->status == 'Mới') {
                                                                        echo 'bg-warning';
                                                                    } elseif ($order->status == 'Đã xác nhận') {
                                                                        echo 'bg-primary';
                                                                    } elseif ($order->status == 'Đã xử lý') {
                                                                        echo 'bg-info';
                                                                    } elseif ($order->status == 'Đã gửi') {
                                                                        echo 'bg-secondary';
                                                                    } elseif ($order->status == 'Hoàn thành') {
                                                                        echo 'bg-success';
                                                                    } elseif ($order->status == 'Đã hủy') {
                                                                        echo 'bg-danger';
                                                                    }
                                                                @endphp">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <button data-id="{{ $order->id }}"
                                                class="btn btn-sm btn-info mr-1 text-light btn_detail"
                                                data-bs-toggle="modal" data-bs-target="#model_detail_order"><i
                                                    class="fa-regular fa-eye"></i></button>
                                            <button data-id="{{ $order->id }}"
                                                class="btn btn-sm btn-danger btn_delete"><i
                                                    class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                            <strong>Không tìm thấy đơn hàng nào</strong>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    @include('admin.order.inc.detail_order')
@endsection
@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.btn_delete', function() {
            var id = $(this).data('id')
            Swal.fire({
                title: 'Bạn muốn đơn hàng?',
                text: "Đơn hàng sẽ không được khôi phục lại",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#049cbb7e',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin-order-delete') }}",
                        type: 'get',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.code == -1) {
                                alertify.error(response.msg)
                            } else {
                                $('#order-' + id).fadeOut('slow', function() {
                                    $('#main_data').html(response.view)
                                })
                                alertify.success(response.msg);
                            }
                        }
                    })
                }
            })
        })

        $(document).on('focus', '#search_input', function() { // focus search input
            $('#area_search').addClass('col-md-4')
        })
        $(document).on('blur', '#search_input', function() { // blur search input
            $('#area_search').removeClass('col-md-4')
            $('#area_search').addClass('col-md-2')
        })

        $(document).on('change', '#search_input', function(event) { // filter by status
            getRecords()
        })
        $('#select_status_filter').on('change', function() { // filter by keyword
            getRecords()
        })

        $(document).on('click', '.btn_detail', function() { // show order detail
            var id = $(this).data('id');
            $('#status').attr('data-id', id)
            $.ajax({
                url: "{{ route('admin-order-detail') }}",
                type: 'get',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#main_cart').html(res.viewMainCart)
                    $('#main_info_order').html(res.viewMainOrder)
                }
            })
        })

        $(document).on('change', '#status', function() {
            var id = $(this).data('id');
            var val = $(this).val();
            $.ajax({
                url: "{{ route('admin-order-update-status') }}",
                type: 'post',
                data: {
                    id: id,
                    val: val
                },
                dataType: 'json',
                success: function(res) {
                    alertify.success(res.msg)
                    $('#main_data').html(res.view)
                }
            })
        })

        $(document).on('change', '#date', function() {
            var time = $(this).val();
            // alert(time)
            $.ajax({
                url: "{{ route('admin-order-filter') }}",
                type: 'get',
                data: {
                    time: time
                },
                dataType: 'json',
                success: function() {

                }
            })
        })

        function getRecords() {
            var status = $('#select_status_filter').val()
            var search_string = $('#search_input').val()
            $.ajax({
                url: "{{ route('admin-order-filter') }}",
                type: 'get',
                dataType: 'json',
                data: {
                    status: status,
                    search_string: search_string
                },
                beforeSend: function() {
                    $('#ani_search').removeClass('d-none')
                    $('#ico_search').addClass('d-none')
                    $('#kun').css('display', 'block')
                    $('body').css('opacity', '0.6')
                },
                success: function(response) {
                    $('#kun').css('display', 'none')
                    $('body').css('opacity', '1')
                    $('#main_data').html(response.view)
                    $('#ani_search').addClass('d-none')
                    $('#ico_search').removeClass('d-none')
                }
            })
        }

    </script>
@endsection
