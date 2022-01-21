@extends('layouts.admin')
@section('title', 'Danh Sách Danh Mục')
@section('scripts')
  <script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
  </script>
@endsection
@section('content')
    <div class="card">
      <div class="card-header">
          <a href="{{ route('admin-category-add') }}"><button class="btn btn-primary" type="button">Thêm Danh Mục</button></a>
      </div>
      <div class="card-body">
        <div class="col-12">
          @if (session('status'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Thông báo!</strong> {{ session('status') }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif
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
                    <td>
                        <a href="{{ route('admin-category-edit', ["$category->id"]) }}" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Sửa"><i class="fas fa-edit"></i></a>
                       
                        <a href="" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Xóa"><i class="fas fa-trash"></i></a>
                    </td>
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