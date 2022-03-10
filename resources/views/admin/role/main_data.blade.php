@if ($roles->count() > 0)
    @foreach ($roles as $role)
        <tr>
            <td class="text-center"><strong>{{ $role->name }}</strong></td>
            <td class="">{{ $role->title }}</td>
            <td class="d-flex justify-content-center">
                <button data-id="{{ $role->id }}" class="btn-primary btn-sm btn btn-edit mr-2"
                    data-bs-toggle="modal" data-bs-target="#edit_user_modal"><i class="fas fa-edit"></i></button>
                <button data-id="{{ $role->id }}" class="btn-danger btn btn-sm btn-delete"><i
                        class="fas fa-ban"></i></button>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="3">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Không tìm thấy kết quả nào.</strong>
            </div>
        </td>
    </tr>
@endif
