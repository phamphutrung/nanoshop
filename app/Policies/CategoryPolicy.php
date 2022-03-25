<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
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
        return $user->checkPermissionAccess('Xem danh mục');
    }
    public function create(User $user) {
        return $user->checkPermissionAccess('Thêm danh mục');
    }
    public function update(User $user) {
        return $user->checkPermissionAccess('Sửa danh mục');
    }
    public function delete(User $user) {
        return $user->checkPermissionAccess('Xóa danh mục');
    }
}
