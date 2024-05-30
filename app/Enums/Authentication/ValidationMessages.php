<?php

namespace App\Enums\Authentication;

use App\Enums\ResponseStatus;
use Illuminate\Validation\Rules\Enum;

class ValidationMessages extends Enum
{
    const UserIsCancelled = [
        'status' => ResponseStatus::Question,
        'title' => 'Tài khoản đang bị tạm khóa',
        'message' => 'Tiến hành kích hoạt lại?',
        'nextUrl' => 'send_verify_code'
    ];

    const UserIsBanned = [
        'status' => ResponseStatus::Warning,
        'title' => 'Tài khoản đã bị cấm vĩnh viễn',
        'message' => 'Vui lòng liên hệ quản trị viên để được hỗ trợ'
    ];

    const WrongPassOrAccount = [
        'status' => ResponseStatus::Error,
        'title' => 'Tên đăng nhập hoặc mật khẩu sai',
        'message' => ''
    ];
}
