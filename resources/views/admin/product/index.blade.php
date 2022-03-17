@extends('layouts.admin')
@section('title', 'Danh Sách Sản Phẩm')
@section('css')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
    {{-- cdn select2 css --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .detail_image {
            display: flex;
            margin-top: 10px;
            flex-wrap: wrap;
            min-height: 85px;
        }

        .detail_image img {
            margin-right: 8px;
            margin-bottom: 8px;
            width: 150px;
            height: 150px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
        }

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
            background-color: #048eaaa9 !important;
        }

        .select2-selection.select2-selection--single {
            padding-bottom: 28px;
        }

        .col-md-12 span.select2-container.select2-container--default {
            width: 100% !important;
            font-size: 1rem !important;
        }

    </style>
@endsection

@section('scripts')
    {{-- tinimce --}}
    <script src="https://cdn.tiny.cloud/1/gvcgn9fcz3rvjlxqcknuy9kstzoabcuya4olq1idbnh25pg6/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        document.addEventListener('focusin', (e) => {
            if (e.target.closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
                e.stopImmediatePropagation();
            }
        });
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
    {{-- end tinimce --}}

    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    {{-- select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('#select_category_filter').select2();
        $('#select_category_chosse').select2({
            dropdownParent: $("#modal_add_product"),
        });
        $("#tags_select2_choose").select2({
            dropdownParent: $("#modal_add_product"),
            tags: true,
            tokenSeparators: [',', ''],
            placeholder: "Thêm tags",
            allowClear: true
        })

    </script>
    {{-- end select2 --}}

    {{-- preview avt and image detail --}}
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
    {{-- end preview avt and image detail --}}

    {{-- auto enter slug --}}
    <script>
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
    {{-- end auto enter slug --}}

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

    </script>

    <script>
        // ajax
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('change', '.trending_check', function(e) { // ON/OFF trending
            var id = $(this).data('id');
            var isTrending = this.checked ? 1 : 0;
            $.ajax({
                url: "{{ route('admin-product-updatetrending') }}",
                type: 'get',
                data: {
                    id: id,
                    isTrending: isTrending
                },
                dataType: 'json',
                success: function(response) {
                    alertify.success(response.msg)
                }
            })
        })

        $(document).on('change', '.status_check', function(e) { // ON/OFF status
            var id = $(this).data('id');
            var isStatus = this.checked ? 1 : 0;
            $.ajax({
                url: "{{ route('admin-product-updatestatus') }}",
                type: 'get',
                data: {
                    id: id,
                    isStatus: isStatus
                },
                dataType: 'json',
                success: function(response) {
                    alertify.success(response.msg)
                }
            })
        })

        $(document).on('click', '.btn_delete', function(e) { // delete 
            var id = $(this).data('id');
            Swal.fire({
                title: 'Bạn muốn xóa?',
                text: "Sản phẩm sẽ được đưa vào thùng rác",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#049cbb7e',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin-product-delete') }}",
                        type: 'get',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(response) {
                            $('#product-' + id).fadeOut('slow', function() {
                                $('#main_data').html(response.view)
                            })
                            alertify.success(response.msg);
                        }
                    })
                }
            })
        })

        $(document).on('click', '.action_force', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let id = $(this).attr('data-id');
            Swal.fire({
                title: 'Bạn muốn xóa vĩnh viễn?',
                text: "Sản phẩm sẽ được xóa vĩnh viễn, không thể khôi phục.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, I do'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        url: url,
                        success: function(response) {
                            $('#product-' + id).remove()
                            $('#count-trash').text('(' + response.countTrash + ')')
                            $('#count-active').text('(' + response.countActive + ')')
                        }
                    })
                }
            })
        })
        $(document).on('click', '.productItem', function(e) { // view detail 
            let id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('admin-product-detail') }}",
                type: "GET",
                dataType: "json",
                data: {
                    id: id
                },
                success: function(response) {
                    let html = "";
                    response.image_detail_path.forEach(function(value, key) {
                        html += "<img src='storage/" + value.image_path + "'>"
                    })
                    $('.detail_image').html(html)
                    $('.feature_image_detail').attr({
                        'src': "{{ asset('storage/') }}" + '/' + response.avt_path,
                        'width': '150px'
                    })
                    $('span.name_detail').text(response.name)
                    $('span.category_detail').text(response.category)
                    $('span.original_price_detail').text(response.original_price)
                    $('span.selling_price_detail').text(response.selling_price)
                    $('div.description_detail').html(response.description)
                    $('div.content_detail').html(response.content)

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

        function getRecords() {
            var idCat = $('#select_category_filter').val()
            var search_string = $('#search_input').val()
            $.ajax({
                url: "{{ route('admin-product-filter') }}",
                type: 'get',
                dataType: 'json',
                data: {
                    idCat: idCat,
                    search_string: search_string
                },
                beforeSend: function() {
                    $('#ani_search').removeClass('d-none')
                    $('#ico_search').addClass('d-none')
                },
                success: function(response) {
                    $('#main_data').html(response.view)
                    $('#ani_search').addClass('d-none')
                    $('#ico_search').removeClass('d-none')
                }
            })
        }

        $(document).on('change', '#search_input', function(event) {
            getRecords()
        })
        $('#select_category_filter').on('change', function() {
            getRecords()
        })

        $(document).on('submit', '#form_add', function(event) {
            event.preventDefault();
            var form = this;
            $.ajax({
                url: "{{ route('admin-product-insert') }}",
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
                    $('#btn_add').prop('disabled', false)
                    if (response.code == 0) {
                        $.each(response.error, function(index, val) {
                                $(form).find('small.text_error_' + index).text(val);
                            })
                    } else {
                        $('#main_data').html(response.view);
                        $("#modal_add_product").slideUp(300, function() {
                            $("#modal_add_product").modal('hide');
                        });
                        alertify.success(response.msg)
                        $(form)[0].reset();
                        $(form).find('small').text('')
                        $('#preview').html('');
                        $('#output').attr('src', '');
                    }
                }
            })
        })

    </script>
@endsection


@section('content')

    <div class="card">
        <div class="card-header bg-cyan-200 text-light">
            <h2>Danh Sách Sản Phẩm</h2>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    <nav class="navbar navbar-expand navbar-light bg-light d-flex ">
                        <div class="col-md-2 me-auto">
                            <ul class="nav navbar-nav">
                                <li class="nav-item">
                                    <a data-bs-toggle="modal" data-bs-target="#modal_add_product" class="btn btn-success btn_add"><i class="fa-regular mr-2 fa-square-plus"></i>Thêm sản phẩm</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-2">
                            <select name="" id="select_category_filter" class="form-control">
                                <option value=0>Tất cả danh mục</option>
                                {!! $htmlSelectOptionCategory !!}
                            </select>
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
                    <table class="table table-hover">
                        <thead class="bg-cyan-200 text-light">
                            <tr>
                                <th scope="col" class="text-center">Ảnh</th>
                                <th scope="col" class="text-center">Tên</th>
                                <th scope="col" class="text-center">Giá</th>
                                <th scope="col" class="text-center">Danh mục</th>
                                <th scope="col" class="text-center">Xu hướng</th>
                                <th scope="col" class="text-center">Kích hoạt</th>
                                <th scope="col" class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="main_data">
                            @if ($products->count() > 0)
                                @foreach ($products as $key => $product)
                                    <tr id="product-{{ $product->id }}">

                                        <td class="text-center">
                                            <img style="width: 5rem; height: 5rem; border-radius: 10px; box-shadow: 0 0 8px rgba(0,0,0,0.2);"
                                                src="{{ asset('storage/' . $product->feature_image_path) }}"
                                                alt="ảnh đại diện">
                                        </td class="text-center">

                                        <td data-toggle="tooltip" data-placement="top" title="Xem chi tiết"
                                            class="text-center text-bold text-capitalize productItem text-primary"
                                            data-id="{{ $product->id }}" style="cursor: pointer;" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">
                                            {{ $product->name }}</td>

                                        <td class="text-center"> {{ number_format($product->selling_price) }}đ </td>

                                        <td class="text-center">
                                            {{-- {{ $product->category ? $product->category->name : '' }} --}}
                                            <span
                                                class="badge bg-warning text-dark">{{ optional($product->category)->name }}</span>

                                        </td>

                                        <td class="text-center">
                                            <div class="form-check form-switch">
                                                <input {{ $product->trending == 1 ? 'checked' : '' }}
                                                    class="form-check-input trending_check" data-id="{{ $product->id }}"
                                                    type="checkbox" id="flexSwitchCheckChecked">
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <div class="form-check form-switch">
                                                <input {{ $product->status == 1 ? 'checked' : '' }}
                                                    class="form-check-input status_check" data-id="{{ $product->id }}"
                                                    type="checkbox" id="flexSwitchCheckChecked">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a data-toggle="tooltip" data-placement="top" title="Chỉnh sửa"
                                                class="btn btn-primary btn-sm"
                                                href="{{ route('admin-product-edit', [$product->id]) }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button data-id="{{ $product->id }} " data-toggle="tooltip"
                                                data-placement="top" title="Xóa" class="btn btn-danger btn-sm btn_delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8">
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                            <strong>Không tìm thấy sản phẩm nào</strong>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                             {{-- <div class="mt-2 d-flex justify-content-end">{{ $products->links() }}</div> --}}
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    
    @include('admin.product.inc.add_product')
    <!-- Modal -->
    @include('admin.product.inc.product_detail')
@endsection
