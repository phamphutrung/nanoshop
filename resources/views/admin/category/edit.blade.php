@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
         <h4>Chỉnh Sửa Danh Mục</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin-category-update', ["$category->id"]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- @method('PUT') --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12 mb-4">
                        <label for="name">Tên Danh mục</label>
                        <input id="name" class="form-control" type="text" name="name" value="{{ $category->name }}">
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="description">Mô tả</label>
                        <textarea class="form-control" name="description" id="description" rows="7">{{ $category->description }}
                        </textarea>
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="meta_keywords">Meta keywords</label>
                        <input id="meta_keywords" class="form-control" type="text" name="meta_keywords" value="{{ $category->meta_keywords }}">
                    </div>
                </div> 

                <div class="col-md-6">
                    <div class="col-md-12 mb-4">
                        <label for="slug">Slug</label>
                        <input id="slug" class="form-control" type="text" name="slug" value="{{ $category->slug }}">
                    </div> 
                    <div class="col-md-12 d-flex align-items-center">
                        <div class="col-md-6 mb-4">
                            <input class="form-check-input" type="checkbox" {{ $category->status=='1'?"checked":"" }} value="1" id="status" name="status">
                            <label class="form-check-label" for="status">
                                Kích hoạt
                            </label>
                        </div>
                        <div class="col-md-6 mb-4 f-right">
                            <input class="form-check-input" type="checkbox" {{ $category->status=='1'?"checked":"" }} value="1" id="popular" name="popular">
                            <label class="form-check-label" for="popular">
                                Phổ biến
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="meta_title">Meta title</label>
                        <input id="meta_title" class="form-control" type="text" name="meta_title" value="{{ $category->meta_title }}">
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="meta_descrip">Meta descrip</label>
                        <input id="meta_descrip" class="form-control" type="text" name="meta_descrip" value="{{ $category->meta_descript }}">
                    </div>
                  
                    <div class="col-md-12 mb-4">
                        <label for="formFile" class="form-label">Ảnh</label>
                        @if ($category->image)
                            <img src="{{ asset("$category->image") }}" alt="" style="width: 8rem; display: block; margin-bottom: 1rem">
                        @endif
                        <input class="form-control" type="file" id="formFile" name="image">
                    </div>

                </div>
            </div>    
          
            <button class="btn btn-success" type="submit">Cập nhật danh mục</button>
            <a href="{{ route('admin-category') }}" class="btn btn-secondary">Hủy</a>

        </form>
    </div>

</div>
@endsection