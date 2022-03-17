@extends('layouts.admin')
@section('title', 'Danh Sách Danh Mục')
@section('css')
    <style>
        #avt {
            width: 2rem;
            height: 2rem;
            border-radius: 5px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
        }

    </style>
@endsection
@section('scripts')
    <script>
        function loadFile(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };

        function loadFileEdit(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('output_edit');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };

        function insertSlugEdit(event) {
            var title = document.getElementById('name_edit').value;
            var slug = title.toLowerCase();
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');

            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            slug = slug.replace(/ /gi, "-")
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            var el = document.getElementById('slug_edit');
            el.value = slug;
        }

        function insertSlug(event) {
            var title = document.getElementById('name').value;
            var slug = title.toLowerCase();
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');

            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            slug = slug.replace(/ /gi, "-")
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            var el = document.getElementById('slug');
            el.value = slug;
        }

    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('submit', '#form_add', function(e) { // add category
            e.preventDefault();
            var form = this;
            $.ajax({
                url: "{{ route('admin-category-insert') }}",
                type: "post",
                processData: false,
                dataType: 'json',
                contentType: false,
                data: new FormData(form),
                beforeSend: function() {
                    $('#btn_add').find('i').removeClass('d-none')
                    $(form).find('small.text-danger').text('');
                    $('#btn_add').prop('disabled', true)
                },
                success: function(response) {
                    $('#btn_add').find('i').addClass('d-none');
                    $('#btn_add').prop('disabled', false);
                    if (response.code == 0) {
                        $.each(response.error, function(index, val) {
                            $('small.error_' + index).html(val);
                        })
                    } else {
                        $('#main_data').html(response.view)
                        $('#category_parent').html("<option value='0'>Chọn danh mục cha</option>" +
                            response.htmlSelectOptionCategory)
                        alertify.success(response.msg)
                        $('#add_category_modal').slideUp('fast', function() {
                            $(this).modal('hide');
                        })
                        $(form)[0].reset()
                        $('#output').attr('src', '')
                    }
                }
            })
        })

        $(document).on('click', '.btn_delete', function(e) { // delete category
            // e.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: 'Bạn muốn xóa danh mục này?',
                text: "Điều này có thể gây lỗi cho hệ thống nếu sản phẩm trong danh mục này chưa tắt kích hoạt",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin-category-delete') }}",
                        type: "get",
                        dataType: 'json',
                        data: {
                            id: id,
                        },
                        success: function(response) {
                            if (response.code == 0) {
                                alertify.error(response.msg)
                            } else {
                                $('#category_' + id).fadeOut('slow', function() {
                                    $('#main_data').html(response.view);
                                });
                                alertify.warning(response.msg)
                            }
                        }
                    })
                }
            })
        })


        $(document).on('click', '.btn_edit', function(e) { // show form edit
            e.preventDefault();
            var id = $(this).data('id');
            $('input[name="id"]').val(id);
            $.ajax({
                url: "{{ route('admin-category-edit') }}",
                type: 'get',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function(response) {
                    $('.name_edit').val(response.category.name);
                    $('.slug_edit').val(response.category.slug);
                    $('#output_edit').attr('src', 'storage/' + response.category.avt)
                    $('.category_edit').html("<option value='0'>Chọn danh mục cha</option>" + response
                        .htmlSelectOptionCategoryEdit)
                }
            })
        })

        $(document).on('submit', '#form_edit', function(e) { //update category
            e.preventDefault();
            var form = this;
            $.ajax({
                url: "{{ route('admin-category-update') }}",
                type: 'POST',
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(form).find('small.text-danger').text('');
                    $('#btn_update').find('i').removeClass('d-none');
                    $('#btn_update').prop('disabled', true)
                },
                success: function(response) {
                    $('#btn_update').find('i').addClass('d-none');
                    $('#btn_update').prop('disabled', false)
                    if (response.code == 0) {
                        $.each(response.error, function(index, val) {
                            $(form).find('small.error_edit_' + index).text(val);
                        })
                    } else {
                        $('#main_data').html(response.view);
                        $("#edit_category_modal").slideUp(300, function() {
                            $("#edit_category_modal").modal('hide');
                        });
                        alertify.success(response.msg)
                        $(form)[0].reset();
                    }
                }
            })
        })

    </script>
@endsection
@section('content')
    <div class="card">
        <div class="card-header bg-cyan-200 text-light">
            <h2>Danh Sách Danh Mục Sản Phẩm</h2>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    <nav class="navbar navbar-expand navbar-light bg-light">
                        <div class="col-md-6">
                            <ul class="nav navbar-nav">
                                <li class="nav-item">
                                    <a data-bs-toggle="modal" data-bs-target="#add_category_modal"
                                        class="btn btn-success"><i class="fa-regular fa-square-plus mr-2"></i>Thêm danh
                                        mục</a>
                                </li>
                                <li class="nav-item">
                                </li>
                            </ul>
                        </div>

                    </nav>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="bg-cyan-200 text-light">
                            <tr>
                                <th scope="col">Tên</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="main_data">
                            {!! $htmlCategoryView !!}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->

    @include('admin.category.inc.edit_category')

    @include('admin.category.inc.add_category')

@endsection
