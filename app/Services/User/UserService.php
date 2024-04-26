<?php

namespace App\Services\User;

use App\Enums\Authentication\VerifyCodeType;
use App\Enums\User\UserStatus;
use App\Jobs\SendVerifyCodeJob;
use App\Mail\sendVerifyCodeMail;
use App\Models\User;
use App\Models\VerifyCode;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserService extends BaseService
{
    public function getModel()
    {
        return User::class;
    }

    public function showVerifyPage()
    {

        $email = Auth::user()->email;

        $data['email'] = $this->encodeEmailAddress($email);

        $data['type'] = VerifyCode::where('email', $email)->get()->last()->type;

        switch ($data['type']) {
            case VerifyCodeType::ForgotPassWord :
                $data['title'] = 'Cấp lại mật khẩu';
                break;
            case VerifyCodeType::ReActiveAccount :
                $data['title_page'] = 'Kích hoạt tài khoản';
                break;
            default:
                $data['title_page'] = null;
                break;
        }
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
