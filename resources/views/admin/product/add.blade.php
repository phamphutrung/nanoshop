@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
         <h4>Thêm Sản Phẩm</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin-product-insert') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12 mb-4">
                        <label for="category">Danh mục</label>
                        <select class="form-select" name="category_id" aria-label="Default select example">
                            <option selected>---Chọn danh mục---</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                          </select>
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="name">Tên sản phẩm</label>
                        <input id="name" class="form-control" type="text" name="name">
                    </div>

                    <div class="col-md-12 mb-4">
                        <label for="description">Mô tả ngắn</label>
                        <textarea class="form-control" name="small_description" id="description" rows="5"></textarea>
                    </div>

                    <div class="col-md-12 mb-4">
                        <label for="description">Mô tả</label>
                        <textarea class="form-control" name="description" id="description" rows="15"></textarea>
                    </div>
                </div> 

                <div class="col-md-6">
                    <div class="col-md-12 mb-4">
                        <label for="slug">Slug</label>
                        <input id="slug" class="form-control" type="text" name="slug">
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
                    <div class="col-md-12 mb-4">
                        <label for="original_price">Giá gốc</label>
                        <input id="original_price" class="form-control" type="text" name="original_price">
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="selling_price">Giá bán</label>
                        <input id="selling_price" class="form-control" type="text" name="selling_price">
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="meta_title">Meta title</label>
                        <input id="meta_title" class="form-control" type="text" name="meta_title">
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="meta_descrip">Meta descrip</label>
                        <input id="meta_descrip" class="form-control" type="text" name="meta_description">
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="meta_keywords">Meta keywords</label>
                        <input id="meta_keywords" class="form-control" type="text" name="meta_keywords">
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="formFile" class="form-label">Ảnh</label>
                        <input class="form-control" type="file" id="formFile" name="images[]" multiple>
                    </div>

                </div>
            </div>    
          
            <button class="btn btn-success" type="submit">Tạo mới</button>
            <a href="{{ route('admin-product') }}" class="btn btn-secondary">Hủy</a>

        </form>
    </div>

</div>
@endsection