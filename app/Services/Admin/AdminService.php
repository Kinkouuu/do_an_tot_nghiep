<?php

namespace App\Services\Admin;

use App\Enums\UserStatus;
use App\Services\BaseService;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AdminService extends BaseService
{

    public function getModel()
    {
        return Admin::class;
    }

    /**
     * @param array $request
     * @return array
     */
    public function adminAuthenticate(array $request): array
    {
        if (Auth::guard('admins')->attempt([
            'account_name' => $request['account_name'],
            'password' => $request['password'],
            'status' => UserStatus::Active
            ])) {
            return $this->successResponse('Đăng nhập trang quản trị thành công',null,'admin.dashboard');
        } else {
           return $this->errorResponse('Tên đăng nhập hoặc mật khẩu sai','Vui lòng thử lại');
        }
    }
}
