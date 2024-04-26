<?php

namespace App\Enums\User;

use Illuminate\Validation\Rules\Enum;

class UserStatus extends Enum
{
    const Cancelled = '0';
    const Active = '1';
    const Banned = '2';

    public static function DeActiveAccount(): array
    {
        return [self::Cancelled, self::Banned];
    }
}
