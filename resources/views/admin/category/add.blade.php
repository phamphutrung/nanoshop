@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
         <h4>Thêm Danh Mục</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin-category-insert') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12 mb-4">
                        <label for="name">Tên Danh mục</label>
                        <input id="name" class="form-control" type="text" name="name">
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="description">Mô tả</label>
                        <textarea class="form-control" name="description" id="description" rows="7"></textarea>
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="meta_keywords">Meta keywords</label>
                        <input id="meta_keywords" class="form-control" type="text" name="meta_keywords">
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
                            <input class="form-check-input" type="checkbox" value="1" id="popular" name="popular">
                            <label class="form-check-label" for="popular">
                                Phổ biến
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="meta_title">Meta title</label>
                        <input id="meta_title" class="form-control" type="text" name="meta_title">
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="meta_descrip">Meta descrip</label>
                        <input id="meta_descrip" class="form-control" type="text" name="meta_descrip">
                    </div>

                    <div class="col-md-12 mb-4">
                        <label for="formFile" class="form-label">Image</label>
                        <input class="form-control" type="file" id="formFile" name="image">
                    </div>

                </div>
            </div>    
          
            <button class="btn btn-primary" type="submit">Tạo mới</button>
        </form>
    </div>

</div>
@endsection