@if ($users->count() > 0)
@foreach ($users as $user)
    <tr>
        <td class="text-center">
            <input type="checkbox" name="item_check">
        </td>
        <td class="text-primary text-bold">{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>phạm trung</td>
        <td class="d-flex justify-content-center">
            <button data-id="{{ $user->id }}" class="btn-primary btn btn-edit mr-2" data-bs-toggle="modal"
                data-bs-target="#edit_user_modal"><i class="fas fa-edit"></i></button>
            <button data-id="{{ $user->id }}" class="btn-danger btn btn-delete"><i
                    class="fas fa-ban"></i></button>
        </td>
    </tr>
@endforeach
@else
<tr>
    <td colspan="5">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert"
                aria-label="Close"></button>
            <strong>Không tìm thấy kết quả nào.</strong>
        </div>
    </td>
</tr>
@endif
<div class="mt-2 d-flex justify-content-end">{{ $users->links() }}</div>