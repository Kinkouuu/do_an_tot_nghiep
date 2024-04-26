<?php

namespace App\Http\Controllers\User;

use App\Enums\Authentication\VerifyCodeType;
use App\Enums\ResponseStatus;
use App\Enums\User\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SiginRequest;
use App\Services\User\AuthService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param RegisterRequest $request
     * @return RedirectResponse
     */
    public function register(RegisterRequest $request)
    {
        $response = $this->authService->register($request->except('re-password'));

        return $this->showAlertAndRedirect($response);
    }

    /**
     * @param SiginRequest $request
     * @return RedirectResponse
     */
    public function signin(SiginRequest $request)
    {
        $response = $this->authService->authenticate($request->all());
        $response['code'] = VerifyCodeType::ReActiveAccount;

        return $this->showAlertAndRedirect($response);
    }

    /**
     * @param $type
     * @return RedirectResponse
     */
    public function sendVerifyCode($type)
    {
        $this->authService->sendVerifyCode($type);

        return redirect()->route('verify_code');
    }

    public function verify(Request $request)
    {
        $user = Auth::user();
        $validation = $this->authService->validationVerifyCode($user, $request->all());

        if ($validation && Carbon::now()->diffInRealMinutes($validation->updated_at) <= 5) { //Mã xác thực có hạn 5p từ lúc gửi
            switch ($request['type']) {
                case VerifyCodeType::ReActiveAccount:
                    $user->status= UserStatus::Active;
                    $user->save();
                    return $this->showAlertAndRedirect([
                        'status' => ResponseStatus::Success,
                        'title' => 'Kích hoạt tài khoản thành công!',
                        'nextUrl' => 'homepage'
                    ]);
                case VerifyCodeType::ForgotPassWord:
                    $randomPass = $this->authService->generateCode(8);
                    $user->update(['password' => Hash::make($randomPass)]);
                    return $this->showAlertAndRedirect([
                        'status' => ResponseStatus::Success,
                        'title' => 'Mật khẩu mới đã được gửi đến email của bạn!',
                        'message' => 'Vui lòng đăng nhập lại bằng mật khẩu mới',
                        'nextUrl' => 'login'
                    ]);
                default:
                    return $this->showAlertAndRedirect([
                        'title' => 'Yêu cầu không chính xác',
                        'message' => 'Vui lòng thử lại',
                    ]);
            }
        } else {
            return $this->showAlertAndRedirect([
                'status' =>ResponseStatus::Warning,
                'title' => 'Mã xác thực không chính xác!',
                'message' => 'Vui lòng thử lại'
            ]);
        }
    }
}

