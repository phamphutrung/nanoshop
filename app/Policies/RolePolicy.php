<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(User $user) {
        return $user->checkPermissionAccess('Xem vai trò');
    }
    public function create(User $user) {
        return $user->checkPermissionAccess('Thêm vai trò');
    }
    public function update(User $user) {
        return $user->checkPermissionAccess('Sửa vai trò');
    }
    public function delete(User $user) {
        return $user->checkPermissionAccess('Xóa vai trò');
    }
}
