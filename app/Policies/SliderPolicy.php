<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SliderPolicy
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
        return $user->checkPermissionAccess('Xem slider');
    }
    public function create(User $user) {
        return $user->checkPermissionAccess('Thêm slider');
    }
    public function update(User $user) {
        return $user->checkPermissionAccess('Sửa slider');
    }
    public function delete(User $user) {
        return $user->checkPermissionAccess('Xóa slider');
    }
}
