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
                    } else {
                        $("#exampleModal").slideUp(300, function() {
                            $("#exampleModal").modal('hide');
                        });
                        $('#output').prop('src', '')
                        $(form)[0].reset();
                        alertify.success(response.message);
                        var html = "";
                        html += "<tr id='slider-" + response.slider.id + "'>";
                        html += "<td class='text-center'>" + '<input data-id="' + response.slider.id +
                            '" type="checkbox" name="item_check">' + "</td>";
                        html += "<td class='text-center'>" + "<img id='image_show' src='" + "storage/" +
                            response.slider.image_path + "'>" + "</td>";
                        html += "<td>" + response.slider.title + "</td>";
                        html += "<td>" + response.slider.description + "</td>";
                        html += '<td class="text-center">';
                        html += '<div class="form-check form-switch">';
                        html += '<input class="form-check-input active_check" data-id="' + response
                            .slider.id + '" type="checkbox" id="flexSwitchCheckChecked">';
                        html += '</div>';
                        html += '</td>';
                        html += "<td class='text-center'>";
                        html += "<button data-id='" + response.slider.id +
                            "' class='btn-primary btn btn-edit' data-bs-toggle='modal' data-bs-target='#modal_edit'><i class='fas fa-edit'></i></button> ";
                        html += "<button data-id='" + response.slider.id +
                            "' class='btn-danger btn btn-delete'><i class='fas fa-ban'></i></button>";
                        html += "</td>";
                        html += "</tr>";
                        $('#data_main').prepend(html)
                    }
                }
            })
        })

        $(document).on('submit', '.form_edit', function(e) { //edit slider
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
                        var html = "";
                        html += "<td class='text-center'>" + '<input data-id="' + response.slider.id +
                            '" type="checkbox" name="item_check">' + "</td>";
                        html += "<td class='text-center'>" + "<img id='image_show' src='" + "storage/" +
                            response.slider.image_path + "'>" + "</td>";
                        html += "<td>" + response.slider.title + "</td>";
                        html += "<td>" + response.slider.description + "</td>";
                        html += '<td class="text-center">';
                        html += '<div class="form-check form-switch">';
                        html += '<input class="form-check-input active_check" data-id="' + response
                            .slider.id + '" type="checkbox" id="flexSwitchCheckChecked">';
                        html += '</div>';
                        html += '</td>';
                        html += "<td class='text-center'>";
                        html += "<button data-id='" + response.slider.id +
                            "' class='btn-primary btn btn-edit' data-bs-toggle='modal' data-bs-target='#modal_edit'><i class='fas fa-edit'></i></button> ";
                        html += "<button data-id='" + response.slider.id +
                            "' class='btn-danger btn btn-delete'><i class='fas fa-ban'></i></button>";
                        html += "</td>";
                        $('#slider-' + id).html(html);



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
                                $(this).remove();
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
                                        $(this).remove()
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
            $.ajax({
                url: "{{ route('admin-slider-action') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    id,
                    action: 'show form edit'
                },
                success: function(response) {
                    $('.title_edit').val(response.slider.title)
                    $('.description_edit').val(response.slider.description)
                    $('.image_edit').attr('src', "{{ asset('storage') }}/" + response.slider
                        .image_path)
                }
            })
        })

    </script>
@endsection


@section('content')

    <div class="card">
        <div class="card-header">
            <h1>Danh Sách Slider</h1>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 bg-white" style="position: sticky; top: 57px; z-index: 1; padding-top: 15px">
                    <button id="add-btn" class="btn btn-success mb-3" data-bs-toggle="modal"
                        data-bs-target="#exampleModal"><i class="fa-regular fa-square-plus mr-2"></i>Thêm slider</button>
                </div>
                <div class="col-md-12">
                    <table id="slider-table" class="table table-hover table-bordered">
                        <thead class="bg-dark" style="position: sticky; z-index: 200; top: 125px">
                            <tr>
                                <th class="text-center"><input name="main_checkbox" type="checkbox"></th>
                                <th class="text-center" style="min-width: 350px">Ảnh</th>
                                <th class="text-center">Tiêu đề</th>
                                <th class="text-center" style="min-width: 400px">Mô tả</th>
                                <th class="text-center" style="min-width: 100px">Kích hoạt</th>
                                <th class="text-center" style="min-width: 200px">hành động <button id="deleteAllBtn"
                                        class="btn btn-danger btn-sm ml-2 d-none"></button> </th>
                            </tr>
                        </thead>
                        <tbody id="data_main">
                            @foreach ($sliders as $slider)
                                <tr id="slider-{{ $slider->id }}">
                                    <td class="text-center">
                                        <input data-id="{{ $slider->id }}" name="item_check" type="checkbox">
                                    </td>
                                    <td class="text-center">
                                        <img id="image_show" src="{{ asset('storage/') . '/' . $slider->image_path }}">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
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
                    <div class="modal-footer">
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
                <div class="modal-header">
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
                            <textarea class="form-control title_edit editor" name="title"></textarea>
                            <span class="text-danger error-text slider_title_error"></span>

                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Mô tả:</label>
                            <textarea class="form-control description_edit editor" name="description"></textarea>
                            <span class="text-danger error-text slider_description_error"></span>
                        </div>
                        <input type="hidden" name="id">
                    </div>
                    <div class="modal-footer">
                        <button id="close-btn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary submit_edit-btn"><i
                                class="fas fa-spinner fa-spin d-none mr-2 pl-0"></i>Cập nhật thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
