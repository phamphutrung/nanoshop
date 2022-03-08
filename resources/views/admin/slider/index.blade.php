@extends('layouts.admin')
@section('title', 'Slider')
@section('css')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
    <style>
        img#image_show {
            max-width: 200px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
            min-height: 80px;
        }

    </style>
@endsection
@section('scripts')

    <script src="https://cdn.tiny.cloud/1/gvcgn9fcz3rvjlxqcknuy9kstzoabcuya4olq1idbnh25pg6/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
        var editor_config = {
            path_absolute: "/",
            entity_encoding: "raw",
            selector: 'textarea.editor',
            relative_urls: false,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table directionality",
                "emoticons template paste textpattern"
            ],

            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            file_picker_callback: function(callback, value, meta) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                    'body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document
                    .getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'filemanager?editor=' + meta.fieldname;
                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.openUrl({
                    url: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no",
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            }
        };

        tinymce.init(editor_config);

    </script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script> // cdn alert tify

    <script>
        // preview image
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

    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('submit', '#form', function(e) { //add slider
            e.preventDefault();
            var form = this
            $.ajax({
                url: "{{ route('admin-slider-add') }}",
                type: "post",
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(form).find('span.error-text').text('');
                    $(form).find('#submit-btn').prop('disabled', true)
                    $(form).find('#submit-btn i').removeClass('d-none')
                },
                success: function(response) {
                    $(form).find('#submit-btn').prop('disabled', false);
                    $(form).find('#submit-btn i').addClass('d-none')
                    if (response.code == 0) {
                        $.each(response.error, function(index, val) {
                            $(form).find('span.slider_' + index + '_error').text(val);
                        })
                    } else if (response.code == 1){
                        $("#exampleModal").slideUp(300, function() {
                            $("#exampleModal").modal('hide');
                        });
                        $('#output').prop('src', '')
                        $(form)[0].reset();
                        alertify.success(response.message);
                        $('#main_data').html(response.view);
                    }
                }
            })
        })

        $(document).on('submit', '.form_edit', function(e) { //update slider
            e.preventDefault();
            var id = $('.form_edit').find('input[name="id"]').val()

            var form = this
            $.ajax({
                url: "{{ route('admin-slider-update') }}",
                type: "post",
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(form).find('span.error-text').text('');
                    $(form).find('.submit_edit-btn').prop('disabled', true)
                    $(form).find('.submit_edit-btn i').removeClass('d-none')
                },
                success: function(response) {
                    $(form).find('.submit_edit-btn').prop('disabled', false);
                    $(form).find('.submit_edit-btn i').addClass('d-none')
                    if (response.code == 0) {
                        $.each(response.error, function(index, val) {
                            $(form).find('span.slider_' + index + '_error').text(val);
                        })
                    } else {
                        $("#modal_edit").slideUp(300, function() {
                            $("#modal_edit").modal('hide');
                        });
                        $(form)[0].reset();
                        alertify.success(response.message);
                        $('#main_data').html(response.view);
                    }
                }
            })
        })

        $(document).on('click', '.active_check', function() { // ON/OFF active button
            var id = $(this).data('id');
            if (this.checked) {
                var status = 'on';
            } else {
                var status = 'off';
            }
            $.ajax({
                url: "{{ route('admin-slider-action') }}",
                type: 'POST',
                data: {
                    status: status,
                    id: id,
                    action: 'update active',
                },
                dataType: 'json',
                success: function(response) {
                    if (response.code == 1) {
                        alertify.success(response.message)
                    }
                }
            })
        })

        $(document).on('click', '.btn-delete', function(e) { // delete slider
            e.preventDefault();
            var id = $(this).attr('data-id');
            Swal.fire({
                title: 'Bạn muốn xóa?',
                text: "Sản phẩm sẽ được đưa vào thùng rác",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin-slider-delete') }}",
                        type: "GET",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(response) {
                            $('#slider-' + id).fadeOut(800, function() {
                                $('#main_data').html(response.view);
                            })
                            alertify.success(response.message);

                        }
                    })
                }
            })
        })

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

        $(document).on('change', 'input[name="item_check"]', function() {
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

        $(document).on('click', '#deleteAllBtn', function() { // destroy all selected record
            var listCheck = [];
            $('input[name="item_check"]:checked').each(function() {
                listCheck.push($(this).data('id'));
            })
            var countCheck = listCheck.length;
            Swal.fire({
                title: 'Bạn muốn xóa?',
                text: countCheck + " slider được chọn để xóa",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin-slider-action') }}",
                        type: "POST",
                        data: {
                            ids: listCheck,
                            action: 'delete'
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.code == 1) {
                                $.each(listCheck, function(index, val) {
                                    $('#slider-' + val).fadeOut(800, function() {
                                        $('#main_data').html(response.view);
                                    })
                                })
                                alertify.success(response.message);
                                $('#deleteAllBtn').addClass('d-none');
                            }
                        }
                    })
                }
            })



        })

        $(document).on('click', '.btn-edit', function(e) { //show form edit record
            var id = $(this).data('id');
            $('.form_edit').find('input[name="id"]').val(id)
            // alert(id)
            $.ajax({
                url: "{{ route('admin-slider-action') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    id: id,
                    action: 'show form edit'
                },
                success: function(response) {
                    tinyMCE.get("tiny_title_edit").setContent(response.slider.title);
                    tinyMCE.get("tiny_description_edit").setContent(response.slider.description);
                    $('.image_edit').attr('src', "{{ asset('storage') }}/" + response.slider
                        .image_path)
                
                },
            })
        })

        $(document).on('keyup', '#search_input', function() {
            var key = $('#search_input').val();

            $.ajax({
                url: "slider-search?key=" + key,
                type: 'get',
                dataType: 'json',
                beforeSend: function() {
                    $('#ani_search').removeClass('d-none')
                    $('#ico_search').addClass('d-none')
                },
                success: function(response) {
                    $('#main_data').html(response.view);
                    $('#ani_search').addClass('d-none')
                    $('#ico_search').removeClass('d-none')
                }
            })
        })
        $(document).on('focus', '#search_input', function() {
            $('#area_search').addClass('col-md-5')
        })
        $(document).on('blur', '#search_input', function() {
            $('#area_search').removeClass('col-md-5')
            $('#area_search').addClass('col-md-2')
        })

    </script>
@endsection


@section('content')

    <div class="card">
        <div class="card-header bg-cyan-200 text-light">
            <h2>Danh Sách Slider</h2>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    <nav class="navbar navbar-expand navbar-light bg-light d-flex justify-content-between">
                        <div class="col-md-6">
                            <ul class="nav navbar-nav">
                                <li class="nav-item">
                                    <button id="add-btn" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"><i class="fa-regular fa-square-plus mr-2"></i>Thêm
                                        slider</button>
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
                    <table id="slider-table" class="table table-hover table-bordered">
                        <thead class="bg-cyan-200 text-light">
                            <tr>
                                <th class="text-center"><input name="main_checkbox" type="checkbox"></th>
                                <th class="text-center">Ảnh</th>
                                <th class="text-center">Tiêu đề</th>
                                <th class="text-center">Mô tả</th>
                                <th class="text-center">Kích hoạt</th>
                                <th class="text-center">hành động</th>
                            </tr>
                        </thead>
                        <tbody id="main_data">
                            @if ($sliders->count() > 0)
                                @foreach ($sliders as $slider)
                                    <tr id="slider-{{ $slider->id }}">
                                        <td class="text-center">
                                            <input data-id="{{ $slider->id }}" name="item_check" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <img id="image_show"
                                                src="{{ asset('storage/') . '/' . $slider->image_path }}">
                                        </td>
                                        <td>{!! $slider->title !!}</td>
                                        <td>{!! $slider->description !!}</td>
                                        <td class="text-center">
                                            <div class="form-check form-switch">
                                                <input {{ $slider->active == 'on' ? 'checked' : '' }}
                                                    class="form-check-input active_check" data-id="{{ $slider->id }}"
                                                    type="checkbox" id="flexSwitchCheckChecked">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <button data-id="{{ $slider->id }}" class="btn-primary btn btn-edit"
                                                data-bs-toggle="modal" data-bs-target="#modal_edit"><i
                                                    class="fas fa-edit"></i></button>
                                            <button data-id="{{ $slider->id }}" class="btn-danger btn btn-delete"><i
                                                    class="fas fa-ban"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">
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
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-cyan-200 text-light">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm slider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class='form' id="form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Ảnh:</label>
                            <input onchange="loadFile(event)" type="file" class="form-control" name="image" id="data_image">
                            <span class="text-danger error-text slider_image_error"></span>
                            <div class="text-center mt-3">
                                <img style="max-width: 500px; border-radius: 10px; box-shadow: 0 0 8px rgba(0,0,0,0.2);"
                                    id="output" src="" alt="">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Tiêu đề:</label>
                            <textarea class="form-control editor" name="title" id="data_title"></textarea>
                            <span class="text-danger error-text slider_title_error"></span>

                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Mô tả:</label>
                            <textarea class="form-control editor" name="description" id="data_description"></textarea>
                            <span class="text-danger error-text slider_description_error"></span>

                        </div>
                    </div>
                    <div class="modal-footer bg-cyan-100">
                        <button id="close-btn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button id="submit-btn" type="submit" class="btn btn-primary "><i
                                class="fas fa-spinner fa-spin d-none mr-2 pl-0"></i>Tạo mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header  bg-cyan-200 text-light">
                    <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa slider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class='form_edit' enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Ảnh:</label>
                            <input onchange="loadFileEdit(event)" type="file" class="form-control" name="image">
                            <span class="text-danger error-text slider_image_error"></span>
                            <div class="text-center mt-3">
                                <img class="image_edit"
                                    style="max-width: 500px; border-radius: 10px; box-shadow: 0 0 8px rgba(0,0,0,0.2);"
                                    id="output_edit" src="" alt="">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Tiêu đề:</label>
                            <textarea id="tiny_title_edit" class="form-control title_edit editor" name="title"></textarea>
                            <span class="text-danger error-text slider_title_error"></span>

                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Mô tả:</label>
                            <textarea id="tiny_description_edit" class="form-control description_edit editor"
                                name="description"></textarea>
                            <span class="text-danger error-text slider_description_error"></span>
                        </div>
                        <input type="hidden" name="id">
                    </div>
                    <div class="modal-footer bg-cyan-100">
                        <button id="close-btn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary submit_edit-btn"><i
                                class="fas fa-spinner fa-spin d-none mr-2 pl-0"></i>Cập nhật thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
