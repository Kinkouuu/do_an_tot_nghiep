<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseService
{
    public function getModel()
    {
        return User::class;
    }

    /**
     * @param $data
     * @return array
     */
    public function register($data): array
    {
        $data['password'] = Hash::make($data['password']);

        try {
            DB::beginTransaction();
            User::create($data);
            DB::commit();
            return $this->successResponse('Đăng ký tài khoản thành công', 'Đăng nhập để sử dụng dịch vụ ngay nào!');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }

}
