<?php

namespace App\Http\Controllers\User;

use App\Enums\Authentication\VerifyCodeType;
use App\Enums\ResponseStatus;
use App\Enums\User\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SiginRequest;
use App\Services\User\AuthService;
use App\Services\User\UserService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $authService;
    private $userService;

    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
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
     * @return RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('homepage');
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Kiểm tra định dạng email
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
                        return;
                    }

                    // Kiểm tra số bắt đầu từ số 0 và có 10 chữ số
                    if (preg_match("/^0\d{9}$/", $value)) {
                        return;
                    }

                    // Nếu không hợp lệ, trả về thông báo lỗi
                    $fail('');
                },
            ],
        ]);
        $userAvailable = $this->userService->getByEmailOrPhone($request->get('account'));
        if ($validator->fails() || !$userAvailable) {
            // Xử lý khi validation không thành công
            return $this->showAlertAndRedirect([
                'status' => ResponseStatus::Error,
                'title'  => 'Tài khoản đăng nhập không chính xác'
            ]);
        }

        $this->authService->sendVerifyCode(VerifyCodeType::ForgotPassWord);

        return redirect()->route('verify_code');
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

    /**
     * Check exp verify code
     * @param Request $request
     * @return RedirectResponse
     */
    public function verifyCode(Request $request)
    {
        $user = session('user');
        $validation = $this->authService->validationVerifyCode($user, $request->all());

        if ($validation && Carbon::now()->diffInRealMinutes($validation->updated_at) <= 5) { //Mã xác thực có hạn 5p từ lúc gửi
            switch ($request['type']) {
                case VerifyCodeType::ReActiveAccount:
                   $response = $this->authService->activeUser($user);
                    Auth::login($user); // login user
                    session()->forget('user'); //delete user session
                    return $this->showAlertAndRedirect($response);
                case VerifyCodeType::ForgotPassWord:
                    return redirect()->route('change_password');
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

    /**
     * Change password for user forgot it
     * @return RedirectResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = session('user');
        $response = $this->authService->changePassword($user, $request->get('new-password'));
        Auth::login($user); // login user
        session()->forget('user'); //delete user session
        return $this->showAlertAndRedirect($response);
    }
}

