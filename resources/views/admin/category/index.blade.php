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
    <div class="col-md-12">
      <a class="btn btn-success mb-3" href="{{ route('admin-category-add') }}" role="button">Thêm danh mục</a>
      <a style="{{ $countTrash<1?'pointer-events: none':"" }}" class="btn @php if(request()->input('status') == 'trash') { echo 'btn-primary'; } else{ echo 'btn-secondary'; } @endphp mb-3 float-right" href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" role="button">Thùng rác ({{ $countTrash }})</a>
      <a class="btn @php if(request()->input('status') == 'active' || request()->input('status') != 'trash') { echo 'btn-primary'; } else{ echo 'btn-secondary'; } @endphp mb-3 mr-2 float-right" href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" role="button">Kích hoạt ({{ $countActive }})</a>
    </div>
    <div class="col-md-12">
            
        @if ($categories->count() < 1)
            <div class="alert alert-danger" role="alert">
                Không có danh mục nào ở đây
            </div>
        @else
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">STT</th>
                  <th scope="col">Ảnh</th>
                  <th scope="col">Tên</th>
                  <th scope="col">Danh mục cha</th>
                  <th scope="col">Hành động</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $stt = 1;
                @endphp
                @foreach ($categories as $category)
                <tr>
                    <th scope="row">{{ $stt  }}</th>
                    <td>
                        <img style="width: 3rem" src="{{ asset("$category->avt") }}" alt="">
                    </td>
                    <td>{{ $category->name }}</td>
                    <td>
                      @php
                        foreach ($categories as $item){
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
                        <a data-toggle="tooltip" data-placement="top" title="Xóa vĩnh viễn" class="btn btn-sm btn-danger" href="{{ route('force', [$category->id]) }}">
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
                  
                  @php
                  $stt ++;
                  @endphp
                </tr>
                @endforeach
              </tbody>
            </table>
          
        @endif
    </div>
@endsection