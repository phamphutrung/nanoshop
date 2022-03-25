<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
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
        return $user->checkPermissionAccess('Xem sản phẩm');
    }
    public function create(User $user) {
        return $user->checkPermissionAccess('Thêm sản phẩm');
    }
    public function update(User $user) {
        return $user->checkPermissionAccess('Sửa sản phẩm');
    }
    public function delete(User $user) {
        return $user->checkPermissionAccess('Xóa sản phẩm');
    }
}
