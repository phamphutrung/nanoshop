@extends('layouts.admin')
@section('title', 'Chỉnh sửa danh mục')
@section('content')
<form action="{{ route('admin-category-update', [$category->id]) }}"  method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="name">Tên danh mục</label>
      <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên danh mục" value="{{ $category->name }}">
      @error('name')
        <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
      @enderror
    </div>

    <div class="form-group">
      <label for="slug">Slug</label>
      <input type="text" class="form-control" id="slug" name="slug" placeholder="Nhập Slug" value="{{ $category->slug }}">
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
      <div>
        <img class="ml-3" style="width: 7rem" src="{{ $category->avt }}" alt="">
      </div>
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Chọn ảnh đại diện mới</label>
      <input type="file" accept="image/*" class="form-control" name="avt" onchange="loadFile(event)">
      <img class="m-3" style="width: 15rem" id="output"> 
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật danh mục</button>
    <a href="{{ route('admin-category') }}" class="btn btn-secondary ml-1">Hủy</a>
 </form>
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
@endsection