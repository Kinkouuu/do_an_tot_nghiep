<?php

namespace App\Services\User;

use App\Enums\Authentication\VerifyCodeType;
use App\Enums\UserStatus;
use App\Models\User;
use App\Models\VerifyCode;
use App\Services\BaseService;

class UserService extends BaseService
{
    public function getModel()
    {
        return User::class;
    }

    /**
     * Validate account available
     * @param $account
     * @return bool
     */
    public function getByEmailOrPhone($account): bool
    {
        $user = User::where('email', $account)->orWhere('phone', $account)->where('status', UserStatus::Active)->first();
        if (!$user) {
            return false;
        }
        session(['user' => $user]);
        return true;
    }

    public function showVerifyPage(): array
    {
        $email = session('user')->email;
        $data['email'] = $this->encodeEmailAddress($email);

        $data['type'] = VerifyCode::where('email', $email)->get()->last()->type;

        $data['title_page'] = match ($data['type']) {
            VerifyCodeType::ForgotPassWord => 'Cấp lại mật khẩu',
            VerifyCodeType::ReActiveAccount => 'Kích hoạt tài khoản'
        };
        return $data;
    }
    public function reActiveUser(User $user)
    {
        $user->status = UserStatus::Active;
        $user->save();

        return $this->successResponse(
            'Kích hoạt tài khoản thành công',
            null,
            'homepage'
        );
    }

    private function encodeEmailAddress(string $email)
    {
        $splitEmail = explode("@", $email);
        $username = $splitEmail[0];
        $domain = $splitEmail[1];
        $hiddenUsername = substr_replace($username, str_repeat("*", strlen($username)-5), 3, -2);

        return $hiddenUsername . "@" . $domain;
    }

}
