@extends('layouts.admin')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        #preview {
            display: flex;
            margin-top: 10px;
            flex-wrap: wrap;
            min-height: 85px
        }

        #preview img {
            margin-right: 8px;
            margin-bottom: 8px;
            width: 85px;
            height: 85px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
        }

        .select2-selection__choice {
            background-color: #4b4645 !important;
        }

        .select2-selection.select2-selection--single {
            padding-bottom: 28px;
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


    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(".tags_select2_choose").select2({
            tags: true,
            tokenSeparators: [',', '']
        })

        $(".category_select2_choose").select2({

        })

    </script>

    <script>
        function loadFile(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };

    </script>


    <script>
        $(document).ready(function() {
            function previewImages() {

                var $preview = $('#preview').empty();
                if (this.files) $.each(this.files, readAndPreview);

                function readAndPreview(i, file) {

                    if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
                        return alert(file.name + " is not an image");
                    } // else...

                    var reader = new FileReader();

                    $(reader).on("load", function() {
                        $preview.append($("<img/>", {
                            src: this.result
                        }));
                    });

                    reader.readAsDataURL(file);

                }

            }

            $('#image_path').on("change", previewImages);
        })

    </script>
    <script>
        function insertSlug(event) {
            var title = document.getElementById('name').value;
            var slug = title.toLowerCase();
            slug = slug.replace(/??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???/gi, 'a');

            slug = slug.replace(/??|??|???|???|???|??|???|???|???|???|???/gi, 'e');
            slug = slug.replace(/i|??|??|???|??|???/gi, 'i');
            slug = slug.replace(/??|??|???|??|???|??|???|???|???|???|???|??|???|???|???|???|???/gi, 'o');
            slug = slug.replace(/??|??|???|??|???|??|???|???|???|???|???/gi, 'u');
            slug = slug.replace(/??|???|???|???|???/gi, 'y');
            slug = slug.replace(/??/gi, 'd');
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
@endsection

@section('title', 'Ch???nh S???a S???m Ph???m ')

@section('content')

    <div class="card">
        <div class="card-header bg-cyan-200 text-light">
            <h2>Ch???nh s???a s???n ph???m</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin-product-update', [$product->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-5">
                        <div class="col-md-12 mb-4">
                            <label for="category">Danh m???c</label>
                            <select class="form-select category_select2_choose" name="category_id">
                                <option value="0">Ch???n danh m???c</option>
                                {!! $htmlSelectOptionCategory !!}
                            </select>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label for="name">T??n s???n ph???m</label>
                            <input id="name" class="form-control" type="text" name="name" placeholder="Nh???p t??n s???n ph???m"
                                value="{{ $product->name }}" onchange="insertSlug()">
                            @error('name')
                                <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-4">
                            <label for="slug">Slug</label>
                            <input id="slug" class="form-control" type="text" name="slug" value="{{ $product->slug }}">
                            @error('slug')
                                <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-4">
                            <label for="original_price">Gi?? g???c</label>
                            <input id="original_price" class="form-control" type="text" name="original_price"
                                placeholder="Nh???p gi?? g???c" value="{{ $product->original_price }}">
                            @error('original_price')
                                <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-4">
                            <label for="selling_price">Gi?? b??n</label>
                            <input id="selling_price" class="form-control" type="text" name="selling_price"
                                placeholder="Nh???p gi?? b??n hi???n t???i" value="{{ $product->selling_price }}">
                            @error('selling_price')
                                <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-4">
                            <label for="formFile" class="form-label">???nh ?????i di???n</label>
                            <input class="form-control" type="file" accept="image/*" id="feature_image_path"
                                name="feature_image_path" onchange="loadFile(event)">
                            <div class="mt-3" style="min-height: 85px">
                                <img style="width: 85px; border-radius: 10px; box-shadow: 0 0 8px rgba(0,0,0,0.2);"
                                    id="output" src="{{ asset('storage/' . $product->feature_image_path) }}">
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label for="formFile" class="form-label">???nh chi ti???t</label>
                            <input class="form-control" type="file" accept="image/*" id="image_path" name="image_path[]"
                                multiple>
                            <div id="preview">
                                @foreach ($product->product_images as $item)
                                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="">
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-12 d-flex align-items-center">
                            <div class="col-md-6 mb-4 ml-3">
                                <input class="form-check-input" type="checkbox" value="1" id="status" name="status"
                                    {{ $product->status ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">
                                    K??ch ho???t
                                </label>
                            </div>
                            <div class="col-md-6 mb-4 f-right">
                                <input class="form-check-input" type="checkbox" value="1" id="popular" name="trending"
                                    {{ $product->trending ? 'checked' : '' }}>
                                <label class="form-check-label" for="popular">
                                    Xu h?????ng
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label>Tags</label>
                            <select name="tags[]" class="form-control tags_select2_choose" multiple>
                                {!! $htmlSelectOptionTag !!}
                            </select>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="col-md-12 mb-4">
                            <label for="description">M?? t??? ng???n</label>
                            <textarea class="form-control editor" name="description" id="description" rows="5"
                                placeholder="Nh???p m?? t??? ng???n">
                                        {{ $product->description }}
                                    </textarea>
                        </div>

                        <div class="col-md-12 mb-4">
                            <label for="description">N???i dung</label>
                            <textarea class="form-control editor" name="content" id="description" rows="28"
                                placeholder="Nh???p n???i dung s???n ph???m">
                                        {{ $product->content }}
                                    </textarea>
                        </div>


                    </div>
                </div>
        </div>
        <div class="card-footer">
            <div>
                <button class="btn btn-success" type="submit"><i class="fa-solid fa-square-pen mr-1"></i></i>C???p
                    nh???t</button>
                <a href="{{ route('admin-product') }}" class="btn btn-secondary "><i
                        class="fa-solid fa-ban mr-1"></i>H???y</a>
                </form>
            </div>
        </div>
    </div>

@endsection
