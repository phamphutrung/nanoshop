<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    public function view(User $user) {
        return $user->checkPermissionAccess('Xem thành viên');
        // return true;
    }
    public function create(User $user) {
        return $user->checkPermissionAccess('Thêm thành viên');
    }
    public function update(User $user) {
        return $user->checkPermissionAccess('Sửa thành viên');
    }
    public function delete(User $user) {
        return $user->checkPermissionAccess('Xóa thành viên');
    }

}
