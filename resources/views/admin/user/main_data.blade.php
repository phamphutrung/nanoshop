@if ($users->count() > 0)
    @foreach ($users as $user)
        <tr id="user_{{ $user->id }}">
            <td class="text-center">
                <input value="{{ $user->id }}" type="checkbox" name="item_check">
            </td>
            <td class="text-primary text-capitalize text-bold">{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            <td>
                @foreach ($user->roles as $role)
                    <span class="badge rounded-pill bg-warning">{{ $role->name }}</span>
                @endforeach
            </td>
            <td class="d-flex justify-content-center">
                <button data-id="{{ $user->id }}" class="btn-primary btn-sm btn btn-edit mr-2"
                    data-bs-toggle="modal" data-bs-target="#edit_user_modal"><i class="fas fa-edit"></i></button>
                <button data-id="{{ $user->id }}" class="btn-danger btn btn-sm btn-delete"><i
                        class="fas fa-ban"></i></button>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="6">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Không tìm thấy kết quả nào.</strong>
            </div>
        </td>
    </tr>
@endif
