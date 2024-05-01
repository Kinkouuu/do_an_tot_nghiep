<?php

namespace App\Services\Admin;

use App\Enums\UserStatus;
use App\Models\Admin;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;

class StaffService extends BaseService
{
    public function getModel()
    {
        return Admin::class;
    }

    /**
     * @param array $request
     * @return array
     */
    public function createStaffAccount(array $request): array
    {
        $request['status'] = UserStatus::Active;
        $request['password'] = Hash::make($request['password']);

        $this->create($request);

        return $this->successResponse(title: 'Thêm tài khoản thành công', nextUrl: 'admin.staffs.index');
    }
}
