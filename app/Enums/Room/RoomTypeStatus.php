<?php declare(strict_types=1);

namespace App\Enums\Room;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class RoomTypeStatus extends Enum
{
    const DeActive = '0';
    const Active = '1';
}


