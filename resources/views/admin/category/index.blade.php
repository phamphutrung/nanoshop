@extends('layouts.admin')
@section('title', 'Danh Sách Danh Mục')
@section('content')
    <div class="card">
      <div class="card-header">
          <a href="{{ route('admin-category-add') }}"><button class="btn btn-primary" type="button">Thêm Danh Mục</button></a>
      </div>
      <div class="card-body">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Responsive Hover Table</h3>

              <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 400px;">
                  <input type="text" name="table_search" class="form-control float-right" placeholder="Tìm kiếm">

                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Ảnh</th>
                    <th>Tên</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($categories as $category)
                  <tr>
                    <td>
                      <img style="width: 3rem" src="{{ $category->image }}" alt="">
                    </td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td><span class="tag tag-success">Approved</span></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
@endsection