<?php

namespace App\Services\Admin;

use App\Enums\UserStatus;
use App\Models\User;
use App\Services\BaseService;
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
}
