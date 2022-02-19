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
    <div class="col-md-12">
        <a class="btn btn-success mb-3  " href="{{ route('admin-category-add') }}" role="button">Thêm danh mục</a>
    </div>
    <div class="col-md-12">
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
                  @endphp
                </td>
                <td>
                  <a class="btn btn-sm btn-primary" href="{{ route('admin-category-edit', [$category->id]) }}">
                      <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                  <a class="btn btn-sm btn-danger" href="{{ route('admin-category-delete', [$category->id]) }}">
                     <i class="fa-solid fa-trash"></i>
                  </a>
                </td>
              @php
              $stt ++;
              @endphp
            </tr>
            @endforeach
          </tbody>
        </table>
    </div>
@endsection