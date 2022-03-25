<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
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
        return $user->checkPermissionAccess('Xem đơn hàng');
    }
    public function create(User $user) {
        return $user->checkPermissionAccess('Thêm đơn hàng');
    }
    public function update(User $user) {
        return $user->checkPermissionAccess('Sửa đơn hàng');
    }
    public function delete(User $user) {
        return $user->checkPermissionAccess('Xóa đơn hàng');
    }
}
