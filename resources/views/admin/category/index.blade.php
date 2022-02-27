@extends('layouts.admin')
@section('title', 'Danh Sách Danh Mục')
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
@endsection
@section('content')
<div class="row bg-white" style="position: sticky; top:58px; z-index: 1">
  <div class="col-md-12">
      <a class="btn btn-success mb-3 d-inline-block" href="{{ route('admin-product-add') }}" role="button"><i class="fa-regular fa-square-plus mr-2"></i>Thêm danh mục</a>
        
      <a  class="btn float-right d-inline-block @php if(request()->input('status') == 'trash') { echo 'btn-primary'; } else{ echo 'btn-secondary'; } @endphp mb-3 " href="{{ request()->fullUrlWithQuery(['status' => 'trash',  'page' => '1']) }}" role="button">Thùng rác <span id="count-trash">({{ $countTrash }})</span></a>

    <a class="btn float-right d-inline-block @php if(request()->input('status') == 'active' || request()->input('status') != 'trash') { echo 'btn-primary'; } else{ echo 'btn-secondary'; } @endphp mb-3 mr-2" href="{{ request()->fullUrlWithQuery(['status' => 'active', 'page' => '1']) }}" role="button">Kích hoạt <span id="count-active">({{ $countActive }})</span></a>

  </div>
</div>
    <div class="col-md-12 m-0 p-0" style="margin-top: 6px">
            
        @if ($categories->count() < 1)
            <div class="alert alert-danger" role="alert">
                Không có danh mục nào ở đây
            </div>
        @else
            <table class="table table-hover">
              <thead class="bg-dark" style="position: sticky; top: 115px; z-index: 2">
                <tr>
                  <th scope="col">STT</th>
                  <th scope="col">Ảnh</th>
                  <th scope="col">Tên</th>
                  <th scope="col">Danh mục cha</th>
                  <th scope="col">Hành động</th>
                </tr>
              </thead>
              <tbody>
            
                @foreach ($categories as $key => $category)
                <tr>
                    <th scope="row">{{ $categories->firstItem()+$key }}</th>
                    <td>
                        <img style="width: 3.5rem;
                        height: 3.5rem;
                        border-radius: 10px;
                        box-shadow: 0 0 8px rgba(0,0,0,0.2);" src="{{ asset('storage/'.$category->avt) }}" alt="">
                    </td>
                    <td>{{ $category->name }}</td>
                    <td>
                      @php
                        foreach ($categoriesArray as $item){
                          if($category->parent_id == $item->id) {
                            echo $item->name;
                          }
                        }
                        if ($category->parent_id == 0) {
                          echo "<strong>Gốc</strong>";
                        }
                      @endphp
                    </td>
                    @if ($category->deleted_at != null)
                      <td>
                        <a data-toggle="tooltip" data-placement="top" title="Khôi phục" class="btn btn-sm btn-warning" href="{{ route('admin-category-restore', [$category->id]) }}">
                          <i class="fa-solid text-white fa-trash-can-arrow-up"></i>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Xóa vĩnh viễn" class="btn btn-sm btn-danger" href="{{ route('admin-category-force', [$category->id]) }}">
                          <i class="fa-solid fa-trash"></i>
                        </a>
                      </td>
                    @else
                      <td>
                        <a data-toggle="tooltip" data-placement="top" title="Chỉnh sửa" class="btn btn-sm btn-primary" href="{{ route('admin-category-edit', [$category->id]) }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Xóa" class="btn btn-sm btn-danger" href="{{ route('admin-category-delete', [$category->id]) }}">
                          <i class="fa-solid fa-trash"></i>
                        </a>
                      </td>
                    @endif
                </tr>
                @endforeach
              </tbody>
            </table>
            
            {{ $categories->withQueryString()->links() }}
            @endif
          </div>
@endsection