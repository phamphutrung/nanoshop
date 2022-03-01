@extends('layouts.admin')
@section('title', 'Danh Sách Sản Phẩm')
@section('css')
  {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>

      <style>
          .detail_image{
              display: flex;
              margin-top: 10px;
              flex-wrap: wrap;
              min-height: 85px;
          }
          .detail_image img{
              margin-right: 8px;
              margin-bottom: 8px;
              width: 150px;
              height: 150px;
              border-radius: 10px;
              box-shadow: 0 0 8px rgba(0,0,0,0.2);
          }
          .select2-selection__choice {
              background-color: #4b4645 !important;
          }
      </style>
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
  <script> // ajax
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
                        $('#count-trash').text('('+response.countTrash +')')
                        $('#count-active').text('('+response.countActive +')')
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
                        $('#count-trash').text('('+response.countTrash +')')
                        $('#count-active').text('('+response.countActive +')')
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
                        $('#count-trash').text('('+response.countTrash +')')
                        $('#count-active').text('('+response.countActive +')')
                      }
                    })
                }
              })
            })
            $(document).on('click', '.productItem', function(e) {
              let id = $(this).attr('data-id');
              $.ajax({
                url: "{{ route('view-product-detail') }}",
                type: "GET",
                dataType: "json",
                data: {id: id},
                success: function(response) {
                    let html = "";
                    response.image_detail_path.forEach(function(value, key){
                      html += "<img src='storage/"+value.image_path+"'>"
                    })
                    $('.detail_image').html(html)
                    $('.feature_image_detail').attr({
                      'src': "{{ asset('storage/') }}" +'/'+ response.avt_path,
                      'width': '150px'
                    })
                    $('span.name_detail').text(response.name)
                    $('span.category_detail').text(response.category)
                    $('span.original_price_detail').text(response.original_price)
                    $('span.selling_price_detail').text(response.selling_price)
                    $('div.description_detail').html(response.description)
                    $('div.content_detail').html(response.content)
                    
                }
              })
            })

  </script>
@endsection


@section('content')

<div class="card">
  <div class="card-header">
    <h1>Danh Sách Sản Phẩm</h1>
  </div>
  <div class="card-body">
    <div class="row bg-white" style="position: sticky; top:57px; z-index: 1;   padding-top: 15px">
      <div class="col-md-12">
          <a class="btn btn-success mb-3 d-inline-block" href="{{ route('admin-product-add') }}" role="button"><i class="fa-regular fa-square-plus mr-2"></i>Thêm danh mục</a>
            
          <a  class="btn float-right d-inline-block @php if(request()->input('status') == 'trash') { echo 'btn-primary'; } else{ echo 'btn-secondary'; } @endphp mb-3 " href="{{ request()->fullUrlWithQuery(['status' => 'trash',  'page' => '1']) }}" role="button">Thùng rác <span id="count-trash">({{ $countTrash }})</span></a>

        <a class="btn float-right d-inline-block @php if(request()->input('status') == 'active' || request()->input('status') != 'trash') { echo 'btn-primary'; } else{ echo 'btn-secondary'; } @endphp mb-3 mr-2" href="{{ request()->fullUrlWithQuery(['status' => 'active', 'page' => '1']) }}" role="button">Kích hoạt <span id="count-active">({{ $countActive }})</span></a>
    
      </div>
  </div>

    <div class="col-md-12 m-0 p-0" style="margin-top: 6px">
      @if ($products->count() < 1)
      <div class="alert alert-danger p-0 m-0" role="alert">
          Không có sản phẩm nào ở đây
      </div>
    @else
      <table class="table table-hover text-capitalize table-bordered">
        <thead class="bg-dark" style="position: sticky; top: 125px; z-index: 2">
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
          <tr id="product-{{ $product->id }}"  >

              <th class="text-center" scope="row">{{ $products->firstItem()+$key }}</th>

              <td class="text-center">
                  <img style="width: 5rem;
                  height: 5rem;
                  border-radius: 10px;
                  box-shadow: 0 0 8px rgba(0,0,0,0.2);" src="{{ asset('storage/'.$product->feature_image_path) }}" alt="">
              </td class="text-center">

              <td data-toggle="tooltip" data-placement="top" title="Xem chi tiết" class="text-center text-bold productItem" data-id="{{ $product->id }}" style="max-width: 17rem; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal">{{ $product->name }}</td>

              <td class="text-center"> {{ $product->selling_price }} </td>

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
                  <button data-id="{{ $product->id }} " data-toggle="tooltip" data-placement="top" title="Xóa" class="btn btn-sm btn-danger action_delete" href="{{ route('admin-product-delete', [$product->id]) }}">
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
  </div>
  <div class="card-footer">
  </div>
</div>



    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Chi Tiết Sản Phẩm</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="col-md-12">
                <p class="text-bold fs-4">Tên sản phẩm: <span class="name_detail fw-normal fs-4 ml-3 text-capitalize"></span></p>
              </div>
              <div class="col-md-12">
                <p class="text-bold fs-4">Danh mục: <span class="category_detail fw-normal fs-4 ml-3 text-capitalize"></span></p>
              </div>
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6">
                    <p class="text-bold fs-4">Giá gốc: <span class="original_price_detail fw-normal fs-4 ml-3 original_price_detail"></span></p>
                  </div>
                  <div class="col-md-6">
                    <p class="text-bold fs-4">Giá bán: <span class="fw-normal fs-4 ml-3 selling_price_detail"></span></p>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <p class="text-bold fs-4">Ảnh đại diện: </p>
                <img class="feature_image_detail" src="" alt="">
              </div>

              <div class="col-md-12">
                <p class="text-bold fs-4">Ảnh chi tiết: </p>
                <div class="detail_image">

                </div>
              </div>
              <div class="col-md-12">
                <p class="text-bold fs-4">Mô tả:</p>
                <div class="description_detail">
                </div>
              </div>
              <div class="col-md-12">
                <p class="text-bold fs-4">Nội dung:</p>
                <div class="content_detail">
                </div>
              </div>
          
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
@endsection