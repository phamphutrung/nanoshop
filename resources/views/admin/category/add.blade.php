@extends('layouts.admin')
@section('title', 'Thêm Danh Mục')
@section('content')
<form>
    <div class="form-group">
      <label for="name">Tên danh mục</label>
      <input type="text" class="form-control" id="name" placeholder="Nhập tên danh mục">
    </div>
    <div class="form-group">
      <label for="parent_category">Danh mục cha</label>
      <select class="form-select" aria-label="Default select example">
        <option value="0">Chọn danh mục cha</option>
       {!! $htmlSelectOptionCategory !!}
      </select>
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Ảnh đại diện</label>
      <input type="file" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{ route('admin-category') }}" class="btn btn-secondary ml-1">Hủy</a>
 </form>
@endsection