<?php

namespace App\Services\Admin;

use App\Enums\UserStatus;
use App\Models\User;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService extends BaseService
{
    public function getModel()
    {
        return User::class;
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function adminCreateOrUpdateUserAccount(array $request): mixed
    {
        $user = User::where('email', $request['email'])->orWhere('phone', $request['phone'])->first();
        if($user) {
             $this->update([
                'email' => $request['email'],
                'phone' => $request['phone'],
                'status' => $request['status']
            ], $user->id);
             return $user;
        } else {
            $password = Hash::make(Str::random(6));
            return $this->create([
                'email' => $request['email'],
                'phone' => $request['phone'],
                'password' => $password,
                'status' => UserStatus::Active
            ]);
        }
    }

    /**
     * Lấy danh sách tài khoản người dùng đang active
     * @return Collection
     */
    public function getActiveUserAccount(): Collection
    {
        return  $this->model->where('status', UserStatus::Active)->with('customer')->get();
    }

    public function verifyUser(User $user)
    {
        $user->verified_at = Carbon::now();
        $user->save();
    }
}
