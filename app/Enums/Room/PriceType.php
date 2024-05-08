<?php declare(strict_types=1);

namespace App\Enums\Room;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PriceType extends Enum
{
    const ListedHourPrice = [
        'value' => 0,
        'type' => 'giờ',
        'text' => 'Giá niêm yết (theo giờ)'
    ];
    const ListedDayPrice = [
        'value' => 1,
        'type' => 'ngày',
        'text' => 'Giá niêm yết (theo ngày)'
    ];
    const First2Hours = [
        'value' => 2,
        'type' => 'giờ',
        'text' => 'Giá 2 giờ đầu'
    ];
    const LateCheckOut = [
        'value' => 3,
        'type' => 'giờ',
        'text' => 'Phí trả phòng chậm'
    ];
    const EarlyCheckIn = [
        'value' => 4,
        'type' => 'giờ',
        'text' => 'Phí nhận phòng sớm'
    ];

    public static function getRoomPriceType(?string $key = 'value'): array
    {
        return [
            self::ListedHourPrice[$key],
            self::ListedDayPrice[$key],
            self::First2Hours[$key],
            self::LateCheckOut[$key],
            self::EarlyCheckIn[$key],
        ];
    }
}
