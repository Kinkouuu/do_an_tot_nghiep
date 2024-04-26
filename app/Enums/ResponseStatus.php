<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ResponseStatus extends Enum
{
    const Success = 'success';
    const Error = 'error';
    const Warning = 'warning';
    const Info = 'info';
    const Question = 'question';

}
