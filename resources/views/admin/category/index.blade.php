@extends('layouts.admin')
@section('title', 'Danh Sách Danh Mục')
@section('scripts')
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

    </script>
@endsection
@section('content')
    <div class="card">
        <div class="card-header bg-cyan-200 text-light">
            <h2>Danh Sách Danh Mục Sản Phẩm</h2>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    <nav class="navbar navbar-expand navbar-light bg-light">
                        <div class="col-md-6">
                            <ul class="nav navbar-nav">
                                <li class="nav-item">
                                    <a class="btn btn-success" href="{{ route('admin-category-add') }}" role="button"><i
                                            class="fa-regular fa-square-plus mr-2"></i>Thêm danh mục</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Nav 2</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-5" style="position: relative">
                            <input type="text" class="form-control ml-3" name="search" id="search_input"
                                placeholder="Nhập tìm kiếm" style="padding-right: 35px">
                        </div>
                        <div class="col-md-1">
                         
                        </div>
                    </nav>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="bg-cyan-200 text-light">
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
                                    <th scope="row">{{ $categories->firstItem() + $key }}</th>
                                    <td>
                                        <img style="width: 3.5rem;
                                              height: 3.5rem;
                                              border-radius: 10px;
                                              box-shadow: 0 0 8px rgba(0,0,0,0.2);"
                                            src="{{ asset('storage/' . $category->avt) }}" alt="">
                                    </td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        @php
                                            foreach ($categoriesArray as $item) {
                                                if ($category->parent_id == $item->id) {
                                                    echo $item->name;
                                                }
                                            }
                                            if ($category->parent_id == 0) {
                                                echo '<strong>Gốc</strong>';
                                            }
                                        @endphp
                                    </td>
                                    <td>
                                        <a data-toggle="tooltip" data-placement="top" title="Chỉnh sửa"
                                            class="btn btn-sm btn-primary"
                                            href="{{ route('admin-category-edit', [$category->id]) }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a data-toggle="tooltip" data-placement="top" title="Xóa"
                                            class="btn btn-sm btn-danger"
                                            href="{{ route('admin-category-delete', [$category->id]) }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
