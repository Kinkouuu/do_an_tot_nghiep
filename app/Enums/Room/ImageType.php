<?php declare(strict_types=1);

namespace App\Enums\Room;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ImageType extends Enum
{
    const ThumbNail = '0';
    const Detail = '1';
}
