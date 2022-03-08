@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-selection__choice {
            background-color: #048eaaa9 !important;
        }

        span.select2-container.select2-container--default {
            width: 100% !important;
        }

        span.select2-selection.select2-selection--single {
            padding-bottom: 27px;
        }

    </style>
@endsection
@section('title', 'Danh sách thành viên')
@section('scripts')
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script> // cdn alert
    tify
    <script script script script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            $("#role").select2({
                dropdownParent: $("#add_user_modal"),
                // tokenSeparators: [',', ''],
                placeholder: "Chọn vai trò cho thành viên",
            });
            $("#role_edit").select2({
                dropdownParent: $("#edit_user_modal"),
                // tokenSeparators: [',', ''],
                placeholder: "Chọn vai trò cho thành viên",
            });
        })

    </script>

    <script>
        $.ajaxSetup({ //setting ajax
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', 'input[name="main_checkbox"]', function(e) { // select all input
            $('input[name="item_check"]').prop('checked', false);

            if (this.checked) {
                $('input[name="item_check"]').each(function() {
                    $(this).prop('checked', true);
                })
                toggleDelAllBtn()

            } else {
                $('input[name="item_check"]').each(function() {
                    $(this).prop('checked', false);
                    toggleDelAllBtn()
                })
            }
        })

        $(document).on('change', 'input[name="item_check"]', function() { // chosse multiple record
            toggleDelAllBtn()
        })

        function toggleDelAllBtn() { //show button delete all selected
            var lengthCheck = $('input[name="item_check"]:checked').length;
            if (lengthCheck > 1) {
                $('#deleteAllBtn').removeClass('d-none').text('Xóa (' + lengthCheck + ')')
            } else {
                $('#deleteAllBtn').addClass('d-none');
            }
        }

        $(document).on('submit', '#form_add', function(e) { // add user
            e.preventDefault();

            var form = this;
            $.ajax({
                url: "{{ route('admin-user-add') }}",
                type: 'POST',
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(form).find('span.text-danger').text('');
                    $('#btn_add').find('i').removeClass('d-none');
                    $('#btn_add').prop('disabled', true)
                },
                success: function(response) {
                    $('#btn_add').find('i').addClass('d-none');
                    $('#btn_add').prop('disabled', false);
                    if (response.code == 0) {
                        $.each(response.error, function(index, val) {
                            $(form).find('span.error_' + index).text(val);
                        })
                    } else {
                        $('#main_data').html(response.view);
                        $("#add_user_modal").slideUp(300, function() {
                            $("#add_user_modal").modal('hide');
                        });
                        alertify.success(response.msg)
                    }
                }
            })
        })

        $(document).on('click', '#add-btn', function() { // reset form add
            $('#form_add').find('input').val('')
            $('#form_add').find('span.error-text').text('')
            $('#form_add').find('select').prop('selected', false)
        })

        $(document).on('click', '.btn-edit', function() { // show form edit
            var id = $(this).data('id');
            $('input[name="id"]').val(id);
            $.ajax({
                url: "{{ route('admin-user-edit') }}",
                type: 'get',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    $('#name_edit').val(response.user.name);
                    $('#email_edit').val(response.user.email);
                    $('#password_edit').val(response.user.password);
                    $('#role_edit').html(response.htmlSelectOptionRoles)
                }
            })
        })

        $(document).on('submit', '#form_edit', function(e) { // update user
            e.preventDefault();
            var form = this;
            var id = $(this).find('input[name="id"]').val();
            $.ajax({
                url: "{{ route('admin-user-update') }}",
                type: 'POST',
                dataType: 'json',
                data: new FormData(form),
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $(form).find('span.text-danger').text('');
                    $('#btn_update').find('i').removeClass('d-none');
                    $('#btn_update').prop('disabled', true)
                },
                success: function(response) {
                    $('#btn_update').find('i').addClass('d-none');
                    $('#btn_update').prop('disabled', false)
                    if (response.code == 0) {

                    } else {
                        $('#main_data').html(response.view);
                        $("#edit_user_modal").slideUp(300, function() {
                            $("#edit_user_modal").modal('hide');
                        });
                        alertify.success(response.msg)
                    }
                }
            })
        })

        $(document).on('click', '.btn-delete', function(e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Bạn muốn xóa?',
                text: "Thành viên sẽ được đưa vào thùng rác",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin-user-action') }}",
                        type: "get",
                        dataType: 'json',
                        data: {
                            id: id,
                            action: 'delete single'
                        },
                        success: function(response) {
                            $('#user_' + id).fadeOut('slow', function() {
                                $('#main_data').html(response.view);
                            });
                            alertify.success(response.msg)
                        }
                    })
                }
            })

        })

    </script>
@endsection
@section('content')
    <div class="card">
        <div class="card-header bg-cyan-200 text-light">
            <h1>Danh sách thành viên</h1>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    <nav class="navbar navbar-expand navbar-light bg-light d-flex justify-content-between">
                        <div class="col-md-6">
                            <ul class="nav navbar-nav">
                                <li class="nav-item">
                                    <button id="add-btn" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#add_user_modal"><i class="fa-regular fa-square-plus mr-2"></i>Thêm
                                        thành viên</button>
                                </li>
                                <li class="nav-item">
                                    <button id="deleteAllBtn" class="btn btn-danger ml-2 d-none"></button>
                                </li>
                            </ul>
                        </div>
                        <div id="area_search" class="col-md-2" style="position: relative">
                            <input type="text" class="form-control ml-3" name="search" id="search_input"
                                placeholder="Nhập tìm kiếm" style="padding-right: 35px">
                            <i class="fa-solid fa-magnifying-glass text-muted" id="ico_search"
                                style="position: absolute; right: 0; top: 0.7rem;"></i>
                            <i class="fas fa-spinner fa-spin d-none text-muted" id="ani_search"
                                style="position: absolute; right: 0; top: 0.7rem;"></i>
                        </div>
                    </nav>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-bordered">
                        <thead class="bg-cyan-200 text-light">
                            <tr>
                                <th class="text-center">
                                    <input type="checkbox" name="main_checkbox">
                                </th>
                                <th class="text-center">Tên</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Vai trò</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="main_data">
                            @if ($users->count() > 0)
                                @foreach ($users as $user)
                                    <tr id="user_{{ $user->id }}">
                                        <td class="text-center">
                                            <input type="checkbox" name="item_check">
                                        </td>
                                        <td class="text-primary text-bold">{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach ($user->roles as $role)
                                                <span class="badge rounded-pill bg-info">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td class="d-flex justify-content-center">
                                            <button data-id="{{ $user->id }}" class="btn-primary btn btn-edit mr-2"
                                                data-bs-toggle="modal" data-bs-target="#edit_user_modal"><i
                                                    class="fas fa-edit"></i></button>
                                            <button data-id="{{ $user->id }}" class="btn-danger btn btn-delete"><i
                                                    class="fas fa-ban"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                            <strong>Không tìm thấy kết quả nào.</strong>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            <div class="mt-2 d-flex justify-content-end">{{ $users->links() }}</div>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add_user_modal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-cyan-200 text-light">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm thành viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_add">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="" class="col-form-label">Tên:</label>
                            <input class="form-control" type="text" placeholder="Nhập tên thành viên" name="name" id="">
                            <span class="text-danger error-text error_name"></span>

                        </div>
                        <div class="mb-3">
                            <label for="" class="col-form-label">Email: <span
                                    style="font-size:10px; position:relative; bottom: 5px;left: -4px; color:red;">(*)</span></label>
                            <input class="form-control" type="email" placeholder="Nhập email thành viên" name="email" id="">
                            <span class="text-danger error-text error_email"></span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-form-label">Mật khẩu: <span
                                    style="font-size:10px; position:relative; bottom: 5px;left: -4px; color:red;">(*)</span></label>
                            <input class="form-control" type="text" placeholder="Nhập mật khẩu cho tài khoản"
                                name="password" id="">
                            <span class="text-danger error-text error_password"></span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-form-label">Vài trò: <span
                                    style="font-size:10px; position:relative; bottom: 5px;left: -4px; color:red;">(*)</span></label>
                            <select class="d-block" name="roles[]" id="role" multiple>
                                <option value="">Chọn vai trò cho thành viên</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text error_roles"></span>
                        </div>

                    </div>
                    <div class="modal-footer bg-cyan-100">
                        <button id="btn_add" type="submit" class="btn btn-primary btn_add"><i
                                class="fas fa-spinner fa-spin d-none mr-2 pl-0"></i>Tạo mới</button>
                        <button id="close-btn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_user_modal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-cyan-200 text-light">
                    <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa thành viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_edit">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="" class="col-form-label">Tên:</label>
                            <input class="form-control" type="text" placeholder="Nhập tên thành viên" name="name"
                                id="name_edit">
                            <span class="text-danger error-text error_name"></span>

                        </div>
                        <div class="mb-3">
                            <label for="" class="col-form-label">Email: <span
                                    style="font-size:10px; position:relative; bottom: 5px;left: -4px; color:red;">(*)</span></label>
                            <input class="form-control" type="email" placeholder="Nhập email thành viên" name="email"
                                id="email_edit">
                            <span class="text-danger error-text error_email"></span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-form-label">Mật khẩu: </label>
                            <input class="form-control" type="text" placeholder="Nhập mật khẩu cho tài khoản"
                                name="password" id="password_edit">
                            <span class="text-danger error-text error_password"></span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-form-label">Vài trò: <span
                                    style="font-size:10px; position:relative; bottom: 5px;left: -4px; color:red;">(*)</span></label>
                            <select class="d-block" name="roles[]" id="role_edit" multiple>


                            </select>
                            <span class="text-danger error-text error_roles"></span>
                        </div>
                        <input type="hidden" name="id">
                    </div>
                    <div class="modal-footer bg-cyan-100">
                        <button id="btn_update" type="submit" class="btn btn-primary btn_add"><i
                                class="fas fa-spinner fa-spin d-none mr-2 pl-0"></i>Cập nhật</button>
                        <button id="close-btn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
