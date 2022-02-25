@extends('layouts.admin')
@section('title', 'Danh Sách Sản Phẩm')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
@endsection
@section('scripts')
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

  <script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
  </script>
  <script>
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
                
        $(document).on('change', '.action_trending', function(e) {
            let url = $(this).attr('data-url');
            let selector = $(this).attr('data-id');
            $.ajax({
              type: "get",
              url: url,
              data: {
                'trending': $(this).val()
              },
              dataType: 'json',
              success: function(response) {
                alertify.success('Đã cập nhật trạng thái xu hướng.'); 
                if (response.value == 0) {
                  $('#'+selector).html("<i class='fa-solid fa-xmark text-danger' style='font-size: 1.7rem'></i>");
                } else {
                  $('#'+selector).html("<i class='fa-solid fa-check text-success' style='font-size: 1.9rem'></i>");
                }
              }
            })
        })
        $(document).on('change', '.action_status', function(e) {
            let url = $(this).attr('data-url');
            let selector = $(this).attr('data-id');

            $.ajax({
              type: "get",
              url: url,
              data: {
                'status': $(this).val()
              },
              dataType: 'json',
              success: function(response) {
                alertify.success('Đã cập nhật trạng thái kích hoạt.'); 
                if (response.value == 0) {
                  $('#'+selector).html("<i class='fa-solid fa-xmark text-danger' style='font-size: 1.7rem'></i>");
                } else {
                  $('#'+selector).html("<i class='fa-solid fa-check text-success' style='font-size: 1.9rem'></i>");
                }
              }
            })
        })
        
            $(document).on('click', '.action_delete', function (e) {
              e.preventDefault();
              let url = $(this).attr('href');
              let id = $(this).attr('data-id');
              Swal.fire({
                title: 'Bạn muốn xóa?',
                text: "Sản phẩm sẽ được đưa vào thùng rác",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                      type: 'GET',
                      url: url,
                      success: function (response) {
                        $('#product-'+id).remove()
                        $('#count-trash').text(response.countTrash)
                        $('#count-active').text(response.countActive)
                      }
                    })
                }
              })
            })
            $(document).on('click', '.action_restore', function (e) {
              e.preventDefault();
              let url = $(this).attr('href');
              let id = $(this).attr('data-id');
              Swal.fire({
                title: 'Bạn muốn khôi phục?',
                text: "Sản phẩm sẽ được khôi phục lại.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Restore'
              }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                      type: 'GET',
                      url: url,
                      success: function (response) {
                        $('#product-'+id).remove()
                        $('#count-trash').text(response.countTrash)
                        $('#count-active').text(response.countActive)
                      }
                    })
                }
              })
            })
            $(document).on('click', '.action_force', function (e) {
              e.preventDefault();
              let url = $(this).attr('href');
              let id = $(this).attr('data-id');
              Swal.fire({
                title: 'Bạn muốn xóa vĩnh viễn?',
                text: "Sản phẩm sẽ được xóa vĩnh viễn, không thể khôi phục.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, I do'
              }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                      type: 'GET',
                      url: url,
                      success: function (response) {
                        $('#product-'+id).remove()
                        $('#count-trash').text(response.countTrash)
                        $('#count-active').text(response.countActive)
                      }
                    })
                }
              })
            })

  </script>
@endsection
@section('content')
<div class="col-md-12">
  <a class="btn btn-success mb-3" href="{{ route('admin-product-add') }}" role="button"><i class="fa-regular fa-square-plus mr-2"></i>Thêm danh mục</a>
  <a  class="btn @php if(request()->input('status') == 'trash') { echo 'btn-primary'; } else{ echo 'btn-secondary'; } @endphp mb-3 float-right" href="{{ request()->fullUrlWithQuery(['status' => 'trash',  'page' => '1']) }}" role="button">Thùng rác <span id="count-trash">({{ $countTrash }})</span></a>
  
  <a class="btn @php if(request()->input('status') == 'active' || request()->input('status') != 'trash') { echo 'btn-primary'; } else{ echo 'btn-secondary'; } @endphp mb-3 mr-2 float-right" href="{{ request()->fullUrlWithQuery(['status' => 'active', 'page' => '1']) }}" role="button">Kích hoạt <span id="count-active">({{ $countActive }})</span></a>
</div>


<div class="col-md-12">
  @if ($products->count() < 1)
  <div class="alert alert-danger" role="alert">
      Không có sản phẩm nào ở đây
  </div>
@else
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col" class="text-center">STT</th>
        <th scope="col" class="text-center">Ảnh</th>
        <th scope="col" class="text-center">Tên</th>
        <th scope="col" class="text-center">Giá</th>
        <th scope="col" class="text-center">Danh mục</th>
        <th scope="col" class="text-center">Xu hướng</th>
        <th scope="col" class="text-center">Kích hoạt</th>
        <th scope="col" class="text-center">Hành động</th>
      </tr>
    </thead>
    <tbody>
  
      @foreach ($products as $key => $product)
      <tr id="product-{{ $product->id }}">
          <th class="text-center" scope="row">{{ $products->firstItem()+$key }}</th>
          <td class="text-center">
              <img style="width: 5rem" src="{{ asset('storage/'.$product->feature_image_path) }}" alt="">
          </td class="text-center">
          <td class="text-center"  style="max-width: 17rem;">{{ $product->name }}</td>
          <td class="text-center"> {{ number_format($product->selling_price) }} </td>
          <td class="text-center">
             {{  $product->category?$product->category->name:"" }}
          </td>
          <td class="text-center">
             <div class="row">
              <div class="col-md-3">
                <select data-id="icon_trending_{{ $product->id }}" data-url="{{ route('admin-product-updatetrending', [$product->id]) }}" class="form-select action_trending">
                  <option value="1" class="bg-success" {{ $product->trending == 1 ?'selected':'' }}>Bật</option>
                  <option value="0" class="bg-secondary" {{ $product->trending == 0 ?'selected':'' }}>Tăt</option>
              </select>
            </div>
            <div class="col-md-5" id="icon_trending_{{ $product->id }}">
               {!! $product->trending == 1 ? " <i class='fa-solid fa-check text-success' style='font-size: 1.9rem'></i>" : "<i class='fa-solid fa-xmark text-danger' style='font-size: 1.7rem'></i>" !!}
            </div>
             </div>
          </td>
          <td class="text-center">
            <div class="row">
              <div class="col-md-3">
                <select data-id="icon_status_{{ $product->id }}" data-url="{{ route('admin-product-updatestatus', [$product->id]) }}" class="form-select action_status">
                  <option value="1" class="bg-success" {{ $product->status == 1 ?'selected':'' }}>Bật</option>
                  <option value="0" class="bg-secondary" {{ $product->status == 0 ?'selected':'' }}>Tăt</option>
              </select>
            </div>
            <div class="col-md-5" id="icon_status_{{ $product->id }}">
               {!! $product->status == 1 ? " <i class='fa-solid fa-check text-success' style='font-size: 1.9rem'></i>" : "<i class='fa-solid fa-xmark text-danger' style='font-size: 1.7rem'></i>" !!}
            </div>
             </div>
          </td>
          @if ($product->deleted_at != null)
            <td class="text-center">
              <a data-id={{ $product->id }} data-toggle="tooltip" data-placement="top" title="Khôi phục" class="btn btn-sm btn-warning action_restore" href="{{ route('admin-product-restore', [$product->id]) }}">
                <i class="fa-solid text-white fa-trash-can-arrow-up"></i>
              </a>
              <a data-id={{ $product->id }} data-toggle="tooltip" data-placement="top" title="Xóa vĩnh viễn" class="btn btn-sm btn-danger action_force" href="{{ route('admin-product-force', [$product->id]) }}">
                <i class="fa-solid fa-trash"></i>
              </a>
            </td>
          @else
            <td class="text-center">
              <a data-toggle="tooltip" data-placement="top" title="Chỉnh sửa" class="btn btn-sm btn-primary" href="{{ route('admin-product-edit', [$product->id]) }}">
                  <i class="fa-solid fa-pen-to-square"></i>
              </a>
              <button data-id="{{ $product->id }} "data-toggle="tooltip" data-placement="top" title="Xóa" class="btn btn-sm btn-danger action_delete" href="{{ route('admin-product-delete', [$product->id]) }}">
                <i class="fa-solid fa-trash"></i>
              </button>
            </td>
          @endif
      </tr>
      @endforeach
    </tbody>
  </table>
  {{ $products->withQueryString()->links() }}
  @endif
</div>

@endsection