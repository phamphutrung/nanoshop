@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
@endsection
@section('title', 'Danh sách vai trò')

@section('scripts')
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script> // cdn alert tify

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('keyup', '#search_input', function(event) {
            getRecords()
        })
        $(document).on('focus', '#search_input', function() {
            $('#area_search').addClass('col-md-4')
        })
        $(document).on('blur', '#search_input', function() {
            $('#area_search').removeClass('col-md-4')
            $('#area_search').addClass('col-md-2')
        })

        $(document).on('submit', '#form_add', function(e) { // add role
            e.preventDefault()
            var form = this
            $.ajax({
                url: "{{ route('admin-role-add') }}",
                type: 'post',
                processData: false,
                contentType: false,
                dataType: 'json',
                data: new FormData(form),
                beforeSend: function() {
                    $(form).find('small.text-error').text('');
                    $('#btn_add').find('i').removeClass('d-none');
                    $('#btn_add').prop('disabled', true)
                },
                success: function(response) {
                    $('#btn_add').find('i').addClass('d-none');
                    $('#btn_add').prop('disabled', false);
                    if (response.code == 0) {
                        $.each(response.errors, function(index, val) {
                            $(form).find('small.error_' + index).text(val);
                        })
                    } else {
                        if (response.code == -1) {
                            alertify.error(response.msg)
                        } else {
                            $('#main_data').html(response.view)
                            alertify.success(response.msg)
                            $("#add_role_model").slideUp(300, function() {
                                $("#add_role_model").modal('hide');
                            });
                            $(form)[0].reset();
                            $(form).find('small').text('')
                        }
                    }
                }
            })
        })

        $(document).on('click', '.btn_edit', function() { // show form edit
            var id = $(this).data('id');
            $('input[name="id"]').val(id);
            $.ajax({
                url: "{{ route('admin-role-edit') }}",
                type: 'get',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function(response) {
                    $('#name_edit').val(response.role.name);
                    $('#title_edit').val(response.role.title);
                    $('#permission_data').html(response.viewPermission_data)
                }
            })
        })

        $(document).on('submit', '#form_edit', function(e) { // update role
            e.preventDefault();
            var form = this;
            var id = $(this).find('input[name="id"]').val();
            $.ajax({
                url: "{{ route('admin-role-update') }}",
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
                        $.each(response.errors, function(index, val) {
                            $(form).find('small.error_' + index).text(val);
                        })
                    } else {
                        if (response.code == -1) {
                            alertify.error(response.msg)
                        } else {
                            $('#main_data').html(response.view);
                            $("#edit_role_model").slideUp(300, function() {
                                $("#edit_role_model").modal('hide');
                            });
                            alertify.success(response.msg)
                            $(form)[0].reset();
                            $(form).find('small').text('')
                        }
                    }
                }
            })
        })

        $(document).on('click', '.btn_delete', function() { // delete role
            var id = $(this).data('id');
            Swal.fire({
                title: 'Bạn muốn xóa?',
                text: "Vai trò sẽ được xóa",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin-role-delete') }}",
                        type: "get",
                        dataType: 'json',
                        data: {
                            id: id,
                        },
                        success: function(response) {
                            if (response.code == -1) {
                                alertify.error(response.msg)
                            } else {
                                $('#role_' + id).fadeOut('slow', function() {
                                    $('#main_data').html(response.view);
                                });
                                alertify.success(response.msg)
                            }
                        }
                    })
                }
            })
        })

        $('.check_main').on('click', function() {
            $(this).parents('.card').find('input').prop('checked', $(this).prop('checked'));
        })

    </script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-cyan-200 text-light">
            <h2>Danh sách vai trò</h2>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    <nav class="navbar navbar-expand navbar-light bg-light d-flex justify-content-between">
                        <div class="col-md-4">
                            <ul class="nav navbar-nav">
                                <li class="nav-item active">
                                    <button class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#add_role_model">Thêm
                                        vai trò</button>
                                </li>
                                <li class="nav-item">
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
                    <table class="table table-hover text-center">
                        <thead class="bg-cyan-200 text-light ">
                            <tr>
                                <th>Tên vai trò</th>
                                <th>Mô tả</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="main_data">
                            @if ($roles->count() > 0)
                                @foreach ($roles as $role)
                                    <tr id="role_{{ $role->id }}">
                                        <td class="text-center"><strong>{{ $role->name }}</strong></td>
                                        <td class="">{{ $role->title }}</td>
                                        <td class="d-flex justify-content-center">
                                            <button data-id="{{ $role->id }}"
                                                class="btn-primary btn-sm btn btn_edit mr-2" data-bs-toggle="modal"
                                                data-bs-target="#edit_role_model"><i class="fas fa-edit"></i></button>
                                            <button data-id="{{ $role->id }}"
                                                class="btn-danger btn btn-sm btn_delete"><i class="fas fa-ban"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3">
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                            <strong>Không tìm thấy kết quả nào.</strong>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="mt-2 d-flex justify-content-end">{{ $roles->links() }}</div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="add_role_model" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-cyan-200 text-light">
                    <h5 class="modal-title">Thêm vai trò</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_add">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Tên: </label>
                                <input type="text" name="name" id="" class="form-control" placeholder="Nhập tên vai trò">
                                <small id="" class="text-danger text-error error_name"></small>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Mô tả: </label>
                                <input type="text" name="title" id="" class="form-control"
                                    placeholder="Nhập mô tả của vai trò">
                            </div>
                        </div>

                        <div class="col-md-12">
                            @foreach ($permissionParents as $permissionParent)
                                <div class="card border-primary">
                                    <div class="card-header bg-cyan-200 text-light">
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input check_main" name=""
                                                id="{{ $permissionParent->name }}">
                                            <label class="form-check-label" for="{{ $permissionParent->name }}">
                                                Module {{ $permissionParent->name }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="card-body d-flex justify-content-between">
                                        @foreach ($permissionParent->permissionChilds as $permissionChild)
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input check_item"
                                                    name="permission_ids[]" id="{{ $permissionChild->name }}"
                                                    value="{{ $permissionChild->id }}">
                                                <label class="form-check-label" for="{{ $permissionChild->name }}">
                                                    {{ $permissionChild->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btn_add" type="submit" class="btn btn-primary"><i
                                class="fas fa-spinner fa-spin d-none mr-2 pl-0"></i>Thêm</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_role_model" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-cyan-200 text-light">
                    <h5 class="modal-title">Chỉnh sửa vai trò</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_edit">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Tên: </label>
                                <input type="text" name="name" id="name_edit" class="form-control"
                                    placeholder="Nhập tên vai trò">
                                <small id="" class="text-danger text-error error_name"></small>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Mô tả: </label>
                                <input type="text" name="title" id="title_edit" class="form-control"
                                    placeholder="Nhập mô tả của vai trò">
                            </div>
                            <input type="hidden" name="id">
                        </div>

                        <div class="col-md-12" id="permission_data">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btn_update" type="submit" class="btn btn-primary"><i
                                class="fas fa-spinner fa-spin d-none mr-2 pl-0"></i>Cập nhật</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
