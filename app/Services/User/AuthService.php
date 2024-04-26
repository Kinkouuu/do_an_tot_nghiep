<?php

namespace App\Services\User;


use App\Enums\Authentication\ValidationMessages;
use App\Enums\Authentication\VerifyCodeType;
use App\Enums\User\UserStatus;
use App\Jobs\SendVerifyCodeJob;
use App\Mail\sendVerifyCodeMail;
use App\Models\User;
use App\Models\VerifyCode;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
            return $this->successResponse(
                'Đăng ký tài khoản thành công',
                'Đăng nhập để sử dụng dịch vụ ngay nào!',
                'login'
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * @param $data
     * @return string[]
     */
    public function authenticate($data)
    {
        if (Auth::attempt([
            'phone' => $data['phone'],
            'password' => $data['password'],
        ])) {
            $user = Auth::user();
            if ($user->status == UserStatus::Cancelled) {
                return ValidationMessages::UserIsCancelled;
            } elseif ($user->status == UserStatus::Banned) {
                return ValidationMessages::UserIsBanned;
            } else {
                return $this->successResponse(
                    'Đăng nhập thành công',
                    null,
                    'homepage'
                );
            }
        }
        return ValidationMessages::WrongPassOrAccount;
    }

    public function sendVerifyCode(string $type)
    {
        $email = Auth::user()->email;
        $randomCode = $this->generateCode();

            VerifyCode::upsert([
                'email' => $email,
                'code' => $randomCode,
                'type' => $type
            ], uniqueBy: ['email'], update: ['code', 'type']);

        $this->sendEmail($email, $randomCode, $type);
    }

    public function reSendVerifyCode()
    {
        $email = Auth::user()->email;
        $randomCode = $this->generateCode();

        $verifyCode = VerifyCode::where('email', $email)->first();
        $verifyCode->update(['code'=>$randomCode]);
        $this->sendEmail($email, $randomCode, $verifyCode->type);
    }

    public function sendEmail(string$email, string $randomCode,string $type)
    {
        switch ($type) {
            case VerifyCodeType::ForgotPassWord :
                $title = 'Cấp lại mật khẩu';
                break;
            case VerifyCodeType::ReActiveAccount :
                $title = 'Kích hoạt tài khoản';
                break;
            default:
                $title = null;
                break;
        }

        SendVerifyCodeJob::dispatch($email, new sendVerifyCodeMail($title, $randomCode))->delay(2);
    }

    public function validationVerifyCode(User $user,array $request)
    {
        $verifyCode = VerifyCode::where([
            "email" => $user->email,
            "code" => $request['code'],
            "type" => $request['type'],
        ])->first();
        return $verifyCode;
    }

    public function generateCode(?int $length = 6): string
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
}
