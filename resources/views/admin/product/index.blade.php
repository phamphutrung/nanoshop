@extends('layouts.admin')
@section('title', 'Danh Sách Sản Phẩm')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection
@section('scripts')
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
              let urlRequest = $(this).attr('href');
              let that = $(this)
              Swal.fire({
                title: '?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                      type: 'GET',
                      url: url,
                      success: function (response) {
                          that.parent().parent().remove()
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
  <a style="{{ $countTrash<1?'pointer-events: none':"" }}" class="btn @php if(request()->input('status') == 'trash') { echo 'btn-primary'; } else{ echo 'btn-secondary'; } @endphp mb-3 float-right" href="{{ request()->fullUrlWithQuery(['status' => 'trash',  'page' => '1']) }}" role="button">Thùng rác ({{ $countTrash }})</a>
  
  <a class="btn @php if(request()->input('status') == 'active' || request()->input('status') != 'trash') { echo 'btn-primary'; } else{ echo 'btn-secondary'; } @endphp mb-3 mr-2 float-right" href="{{ request()->fullUrlWithQuery(['status' => 'active', 'page' => '1']) }}" role="button">Kích hoạt ({{ $countActive }})</a>
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
        <th scope="col" class="text-center">Category</th>
        <th scope="col" class="text-center">Xu hướng</th>
        <th scope="col" class="text-center">Kích hoạt</th>
        <th scope="col" class="text-center">Hành động</th>
      </tr>
    </thead>
    <tbody>
  
      @foreach ($products as $key => $product)
      <tr>
          <th class="text-center" scope="row">{{ $products->firstItem()+$key }}</th>
          <td class="text-center">
              <img style="width: 5rem" src="{{ asset('storage/'.$product->feature_image_path) }}" alt="">
          </td class="text-center">
          <td class="text-center">{{ $product->name }}</td>
          <td class="text-center"> {{ number_format($product->selling_price) }} </td>
          <td class="text-center">
             {{  $product->category?$product->category->name:"" }}
          </td>
          <td class="text-center">
             <div class="row">
              <div class="col-md-5">
                <select data-id="icon_trending_{{ $product->id }}" data-url="{{ route('admin-product-updatetrending', [$product->id]) }}" class="form-select action_trending">
                  <option value="1" class="bg-success" {{ $product->trending == 1 ?'selected':'' }}>Bật</option>
                  <option value="0" class="bg-secondary" {{ $product->trending == 0 ?'selected':'' }}>Tăt</option>
              </select>
            </div>
            <div class="col-md-3" id="icon_trending_{{ $product->id }}">
               {!! $product->trending == 1 ? " <i class='fa-solid fa-check text-success' style='font-size: 1.9rem'></i>" : "<i class='fa-solid fa-xmark text-danger' style='font-size: 1.7rem'></i>" !!}
            </div>
             </div>
          </td>
          <td class="text-center">
            <div class="row">
              <div class="col-md-5">
                <select data-id="icon_status_{{ $product->id }}" data-url="{{ route('admin-product-updatestatus', [$product->id]) }}" class="form-select action_status">
                  <option value="1" class="bg-success" {{ $product->status == 1 ?'selected':'' }}>Bật</option>
                  <option value="0" class="bg-secondary" {{ $product->status == 0 ?'selected':'' }}>Tăt</option>
              </select>
            </div>
            <div class="col-md-3" id="icon_status_{{ $product->id }}">
               {!! $product->status == 1 ? " <i class='fa-solid fa-check text-success' style='font-size: 1.9rem'></i>" : "<i class='fa-solid fa-xmark text-danger' style='font-size: 1.7rem'></i>" !!}
            </div>
             </div>
          </td>
          @if ($product->deleted_at != null)
            <td class="text-center">
              <a data-toggle="tooltip" data-placement="top" title="Khôi phục" class="btn btn-sm btn-warning" href="{{ route('admin-product-restore', [$product->id]) }}">
                <i class="fa-solid text-white fa-trash-can-arrow-up"></i>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Xóa vĩnh viễn" class="btn btn-sm btn-danger" href="{{ route('admin-product-force', [$product->id]) }}">
                <i class="fa-solid fa-trash"></i>
              </a>
            </td>
          @else
            <td class="text-center">
              <a data-toggle="tooltip" data-placement="top" title="Chỉnh sửa" class="btn btn-sm btn-primary" href="{{ route('admin-product-edit', [$product->id]) }}">
                  <i class="fa-solid fa-pen-to-square"></i>
              </a>
              <button data-toggle="tooltip" data-placement="top" title="Xóa" class="btn btn-sm btn-danger action_delete" href="{{ route('admin-product-delete', [$product->id]) }}">
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