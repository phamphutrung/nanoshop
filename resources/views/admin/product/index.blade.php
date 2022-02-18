@extends('layouts.admin')
@section('title', 'Danh Sách Sản Phẩm')
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
          <a href="{{ route('admin-product-add') }}"><button class="btn btn-primary" type="button">Thêm Sản Phẩm</button></a>
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
                    <th>Giá bán</th>
                    <th>Danh mục</th>
                    <th>Hành động</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($products as $product)
             
                  <tr>
                    <td>
                      <img style="width: 3rem" src="{{ $product->product_images->first()->file_path }}" alt="">
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->small_description }}</td>
                    <td>{{ $product->selling_price }}</td>
                    <td>{{ $product->category?$product->category->name:'' }}</td>
                    <td>
                        <a href="{{ route('admin-category-edit', ["$product->id"]) }}" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Sửa"><i class="fas fa-edit text-white"></i></a>
                       
                        <a href="{{ route('admin-category-delete', ["$product->id"]) }}" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Xóa" onclick="confirm("Xóa danh mục?")"><i class="fas fa-trash"></i></a>
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