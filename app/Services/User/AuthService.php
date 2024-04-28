<?php

namespace App\Services\User;


use App\Enums\Authentication\ValidationMessages;
use App\Enums\Authentication\VerifyCodeType;
use App\Enums\ResponseStatus;
use App\Enums\User\UserStatus;
use App\Jobs\SendVerifyCodeJob;
use App\Mail\sendVerifyCodeMail;
use App\Models\User;
use App\Models\VerifyCode;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseService
{
    public function getModel(): string
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
    public function authenticate($data): array
    {
        if (Auth::attempt([
            'phone' => $data['phone'],
            'password' => $data['password'],
        ])) {
            $user = Auth::user();
            if ($user->status == UserStatus::Cancelled) {
                session(['user' => $user]);
                Auth::logout();
                return ValidationMessages::UserIsCancelled;
            } elseif ($user->status == UserStatus::Banned) {
                Auth::logout();
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

    /**
     * Send email include verify code
     * @param string $type
     * @return void
     */
    public function sendVerifyCode(string $type): void
    {
        $email = session('user')->email;
        $randomCode = $this->generateCode();

            VerifyCode::upsert([
                'email' => $email,
                'code' => $randomCode,
                'type' => $type
            ], uniqueBy: ['email'], update: ['code', 'type']);

        $this->sendEmail($email, $randomCode, $type);
    }

    /**
     * Resend email when user click re-send button at verify page
     * @return void
     */
    public function reSendVerifyCode(): void
    {
        $email = session('user')->email;
        $randomCode = $this->generateCode();

        $verifyCode = VerifyCode::where('email', $email)->first();
        $verifyCode->update(['code'=>$randomCode]);
        $this->sendEmail($email, $randomCode, $verifyCode->type);
    }

    /**
     * Queue Job send email verify code
     * @param string $email
     * @param string $randomCode
     * @param string $type
     * @return void
     */
    public function sendEmail(string$email, string $randomCode,string $type): void
    {
        $title = match ($type) {
            VerifyCodeType::ForgotPassWord => 'Cấp lại mật khẩu',
            VerifyCodeType::ReActiveAccount => 'Kích hoạt tài khoản',
            default => null,
        };

        SendVerifyCodeJob::dispatch($email, new sendVerifyCodeMail($title, $randomCode));
    }

    /**
     * Check verify code in database
     * @param User $user
     * @param array $request
     * @return mixed
     */
    public function validationVerifyCode(User $user,array $request)
    {
        $verifyCode = VerifyCode::where([
            "email" => $user->email,
            "code" => $request['code'],
            "type" => $request['type'],
        ])->first();
        return $verifyCode;
    }

    /**
     * Generate a random string code
     * @param int|null $length
     * @return string
     */
    public function generateCode(?int $length = 6): string
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    /**
     * User active account
     * @param User $user
     * @return array
     */
    public function activeUser(User $user): array
    {
         $this->update(['status' => UserStatus::Active],$user->id);
         return $this->successResponse('Kích hoạt tài khoản thành công!', null, 'homepage');
    }

    /**
     * User change password
     * @param User $user
     * @param string $newPassword
     * @return array
     */
    public function changePassword(User $user, string $newPassword): array
    {
        $this->update(['password' => Hash::make($newPassword)],$user->id);
        return $this->successResponse('Cập nhật mật khẩu thành công', null, 'homepage');
    }
}
