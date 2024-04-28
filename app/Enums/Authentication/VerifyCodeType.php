<?php declare(strict_types=1);

namespace App\Enums\Authentication;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class VerifyCodeType extends Enum
{
    const ForgotPassWord = 'forgot_password';
    const ReActiveAccount = 'reactive_account';
}
