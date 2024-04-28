<?php

namespace App\Enums\Authentication;

use Illuminate\Validation\Rules\Enum;

class ValidationMessages extends Enum
{
    const UserIsCancelled = [
        'status' => 'question',
        'title' => 'Tài khoản đang bị tạm khóa',
        'message' => 'Tiến hành kích hoạt lại?',
        'nextUrl' => 'send_verify_code'
    ];

    const UserIsBanned = [
        'status' => 'warning',
        'title' => 'Tài khoản đã bị cấm vĩnh viễn',
        'message' => 'Vui lòng liên hệ quản trị viên để được hỗ trợ'
    ];

    const WrongPassOrAccount = [
        'status' => 'error',
        'title' => 'Tên đăng nhập hoặc mật khẩu sai',
        'message' => ''
    ];
}
