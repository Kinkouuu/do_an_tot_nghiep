<?php declare(strict_types=1);

namespace App\Enums\Booking;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class BookingType extends Enum
{
    const OnWebSite = '0';
    const OnSociety = '1';
    const OffLine = '2';
}
