@extends('layouts.admin')

@section('title', 'Cài đặt')
@section('css')
    <style>
    </style>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
@endsection

@section('scripts')
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script> // cdn alert tify
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

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('submit', '#form_add', function(e) { // add setting
            e.preventDefault();
            var form = this;
            $.ajax({
                url: "{{ route('admin-setting-add') }}",
                type: 'POST',
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(form).find('small.text-danger').text('');
                    $('#btn_add').find('i').removeClass('d-none');
                    $('#btn_add').prop('disabled', true)
                },
                success: function(response) {
                    $('#btn_add').find('i').addClass('d-none');
                    $('#btn_add').prop('disabled', false);
                    if (response.code == 0) {
                        $.each(response.error, function(index, val) {
                            $(form).find('small.error_' + index).text(val);
                        })
                    } else {
                        $('#main_data').html(response.view);
                        $("#add_config").slideUp(300, function() {
                            $("#add_config").modal('hide');
                        });
                        alertify.success(response.msg)
                        $(form)[0].reset();
                        $(form).find('small').text('')
                    }
                }
            })

        })

        $(document).on('click', '.btn_edit', function() {
            var id = $(this).data('id');
            $('#form_edit').find('input[name="id"]').val(id);
            $.ajax({
                url: "{{ route('admin-setting-edit') }}",
                type: "get",
                dataType: "json",
                data: {
                    id: id
                },
                success: function(response) {
                    $('.config_key_edit').val(response.setting.config_key);
                    tinyMCE.get("tiny_config_value_edit").setContent(response.setting.config_value);
                }
            })


        })

        $(document).on('submit', '#form_edit', function(e) {
            e.preventDefault();
            var id = $('#form_edit').find('input[name="id"]').val()
            var form = this;
            $.ajax({
                url: "{{ route('admin-setting-update') }}",
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
                            $(form).find('small.error_' + index).text(val);
                        })
                    } else {
                        $('#main_data').html(response.view);
                        $("#edit_config").slideUp(300, function() {
                            $("#edit_config").modal('hide');
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
            <h2>Cài Đặt</h2>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    <nav class="navbar navbar-expand navbar-light bg-light">
                        <ul class="nav navbar-nav">
                            <li class="nav-item active">
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_config">Thêm cài
                                    đặt</button>
                            </li>
                            <li class="nav-item">

                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-bordered">
                        <thead class="thead-inverse thead-default bg-cyan-200 text-light">
                            <tr>
                                <th class="text-center"><input name="main_checkbox" type="checkbox"></th>
                                <th>Thiết lập</th>
                                <th>Giá trị</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="main_data">
                            @foreach ($settings as $setting)
                                <tr>
                                    <td class="text-center">
                                        <input data-id="{{ $setting->id }}" name="item_check" type="checkbox">
                                    </td>
                                    <td>{!! $setting->config_key !!}</td>
                                    <td>{!! $setting->config_value !!}</td>
                                    <td class="d-flex">
                                        <button data-id="{{ $setting->id }}" class="btn-primary btn btn_edit mr-2"
                                            data-bs-toggle="modal" data-bs-target="#edit_config"><i
                                                class="fas fa-edit"></i></button>
                                        <button data-id="{{ $setting->id }}" class="btn-danger btn btn-delete"><i
                                                class="fas fa-ban"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            {{ $settings->links() }}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="add_config" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-cyan-200 text-light">
                    <h5 class="modal-title">Thêm cài đặt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form_add">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Config key</label>
                            <input type="text" class="form-control" name="config_key">
                            <small id="helpId" class="form-text text-danger error_config_key"></small>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Config value</label>
                            <textarea class="form-control editor" name="config_value"></textarea>
                            <small id="helpId" class="form-text text-danger error_config_value"></small>
                        </div>
                </div>
                <div class="modal-footer bg-cyan-100 text-light">
                    <button id="btn_add" type="submit" class="btn btn-primary"><i
                            class="fas fa-spinner fa-spin d-none mr-2 pl-0"></i> Tạo mới</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_config" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-cyan-200 text-light">
                    <h5 class="modal-title">Chỉnh sửa cài đặt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form_edit">
                        @csrf
                        <input name="id" type="hidden">
                        <div class="mb-3">
                            <label for="" class="form-label">Config key</label>
                            <input type="text" class="form-control config_key_edit" name="config_key">
                            <small id="helpId" class="form-text text-danger error_config_key"></small>

                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Config value</label>
                            <textarea class="editor" name="config_value" id="tiny_config_value_edit"></textarea>
                            <small id="helpId" class="form-text text-danger error_config_value"></small>

                        </div>
                </div>
                <div class="modal-footer bg-cyan-100">
                    <button id="btn_update" type="submit" class="btn btn-primary"><i
                            class="fas fa-spinner fa-spin d-none mr-2 pl-0"></i>Cập nhật</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
