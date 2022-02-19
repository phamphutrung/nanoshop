@extends('layouts.admin')
@section('title', 'Thêm Danh Mục')
@section('content')
<form action="{{ route('admin-category-insert') }}"  method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="name">Tên danh mục</label>
      <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên danh mục">
      @error('name')
        <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
      @enderror
    </div>

    <div class="form-group">
      <label for="slug">Slug</label>
      <input type="text" class="form-control" id="slug" name="slug" placeholder="Nhập Slug">
    </div>
    <div class="form-group">
      <label>Danh mục cha</label>
      <select class="form-select" name="parent_id">
        <option value="0">Chọn danh mục cha</option>
       {!! $htmlSelectOptionCategory !!}
      </select>
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Ảnh đại diện</label>
      <input type="file" class="form-control" name="avt">
    </div>
    <button type="submit" class="btn btn-primary">Thêm danh mục</button>
    <a href="{{ route('admin-category') }}" class="btn btn-secondary ml-1">Hủy</a>
 </form>
 
@endsection