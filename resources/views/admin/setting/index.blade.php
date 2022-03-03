@extends('layouts.admin')

@section('title', 'Cài đặt')
@section('css')
    <style>
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
                    <table class="table table-hover table-bordered table-inverse">
                        <thead class="thead-inverse thead-default bg-cyan-200 text-light">
                            <tr>
                                <th>Thiết lập</th>
                                <th>Giá trị</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="row">1</td>
                                <td>slider_description_error</td>
                                <td>sdsd</td>
                            </tr>
                            <tr>
                                <td scope="row">2</td>
                                <td>ds</td>
                                <td>dsđ</td>
                            </tr>
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
                <div class="modal-header">
                    <h5 class="modal-title">Thêm cài đặt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                      <label for="" class="form-label"></label>
                      <input type="text" class="form-control" name="" >
                      <small id="helpId" class="form-text text-danger"></small>
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label"></label>
                      <textarea class="form-control editor" name="" id=""></textarea>
                      <small id="helpId" class="form-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Tạo mới</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
