<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DataType extends Enum
{
    const All = 0;
    const Booking = 1;
    const Revenue = 2;
    const Customer = 3;
}
