@extends('layouts.admin')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        #preview{
            display: flex;
            margin-top: 10px;
            flex-wrap: wrap;
        }
        #preview img{
            margin-right: 8px;
            margin-bottom: 8px;
            width: 85px;
            height: 85px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.2);
        }
    </style>
@endsection

@section('scripts')
    // select2 cdn 
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $ ( ".tags_select2_choose" ). select2 ({ 
            tags : true , 
            tokenSeparators : [ ',' , '' ] 
        })  
            
        $ ( ".category_select2_choose" ). select2 ({ 
  
        })  
    </script>

    // preview avt product.
    <script>
        function loadFile (event) {
            var reader = new FileReader();
            reader.onload = function(){
              var output = document.getElementById('output');
              output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
          };
    </script>

    //preview images detail product.
    <script>
        $(document).ready(function() {
            function previewImages() {

                var $preview = $('#preview').empty();
                if (this.files) $.each(this.files, readAndPreview);
              
                function readAndPreview(i, file) {
                  
                  if (!/\.(jpe?g|png|gif)$/i.test(file.name)){
                    return alert(file.name +" is not an image");
                  } // else...
                  
                  var reader = new FileReader();
              
                  $(reader).on("load", function() {
                    $preview.append($("<img/>", {src:this.result}));
                  });
              
                  reader.readAsDataURL(file);
                  
                }
              
              }
              
              $('#image_path').on("change", previewImages);
        })
    </script>
@endsection

@section('title', 'Thêm Sảm Phẩm ')

@section('content')
<form action="{{ route('admin-product-insert') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-5">
            <div class="col-md-12 mb-4">
                <label for="category">Danh mục</label>
                <select class="form-select category_select2_choose" name="category_id">
                    <option selected>Chọn danh mục</option>
                   {!! $htmlSelectOptionCategory !!}
                  </select>
            </div>
            <div class="col-md-12 mb-4">
                <label for="name">Tên sản phẩm</label>
                <input id="name" class="form-control" type="text" name="name" placeholder="Nhập tên sản phẩm">
            </div>

            <div class="col-md-12 mb-4">
                <label for="slug">Slug</label>
                <input id="slug" class="form-control" type="text" name="slug">
            </div> 
            <div class="col-md-12 mb-4">
                <label for="original_price">Giá gốc</label>
                <input id="original_price" class="form-control" type="text" name="original_price" placeholder="Nhập giá gốc">
            </div>
            <div class="col-md-12 mb-4">
                <label for="selling_price">Giá bán</label>
                <input id="selling_price" class="form-control" type="text" name="selling_price" placeholder="Nhập giá bán hiện tại">
            </div>
      
            <div class="col-md-12 mb-4">
                <label for="formFile" class="form-label">Ảnh đại diện</label>
                <input class="form-control" type="file" accept="image/*" id="feature_image_path" name="feature_image_path" onchange="loadFile(event)">
                <div class="text-center mt-3">
                    <img style="width: 85px; border-radius: 10px;" id="output">
                </div>
            </div>
            <div class="col-md-12 mb-4">
                <label for="formFile" class="form-label">Ảnh chi tiết</label>
                <input class="form-control" type="file" id="image_path" name="image_path[]" multiple>
                <div id="preview"></div>
            </div>
            <div class="col-md-12 mb-4">
                <label>Tags</label>
                <select class="form-control tags_select2_choose" multiple>
                    
                </select>
            </div>
        </div> 

        <div class="col-md-7">
            <div class="col-md-12 mb-4">
                <label for="description">Mô tả ngắn</label>
                <textarea class="form-control" name="description" id="description" rows="5" placeholder="Nhập mô tả ngắn"></textarea>
            </div>

            <div class="col-md-12 mb-4">
                <label for="description">Nội dung</label>
                <textarea class="form-control" name="content" id="description" rows="15" placeholder="Nhập nội dung sản phẩm"></textarea>
            </div>
            <div class="col-md-12 d-flex align-items-center">
                <div class="col-md-6 mb-4">
                    <input class="form-check-input" type="checkbox" value="1" id="status" name="status">
                    <label class="form-check-label" for="status">
                        Kích hoạt
                    </label>
                </div>
                <div class="col-md-6 mb-4 f-right">
                    <input class="form-check-input" type="checkbox" value="1" id="popular" name="trending">
                    <label class="form-check-label" for="popular">
                        Xu hướng
                    </label>
                </div>
            </div>

        </div>
    </div>    

    <button class="btn btn-success" type="submit">Tạo mới</button>
    <a href="{{ route('admin-product') }}" class="btn btn-secondary">Hủy</a>
</form>

@endsection
