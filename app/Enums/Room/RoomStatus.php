<?php declare(strict_types=1);

namespace App\Enums\Room;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class RoomStatus extends Enum
{
    const Vacating = [
        'key' => '0',
        'value' => 'Đang trống'
    ];
    const UnUsed = [
        'key' => '1',
        'value' => 'Ngừng hoạt động'
    ];
    const Using  = [
        'key' => '2',
        'value' => 'Đang sử dụng'
    ];
    const Cleaning = [
        'key' => '3',
        'value' => 'Đang dọn dẹp'
    ];
    const Fixing = [
        'key' => '4',
        'value' => 'Đang bảo trì'
    ];

    public static function getRoomStatus(?string $key = 'key'): array
    {
        return [
            self::Vacating[$key],
            self::Booking[$key],
            self::Using[$key],
            self::Cleaning[$key],
            self::Fixing[$key],
        ];
    }

    public static function getValue(string $key): mixed
    {
        foreach (self::asArray() as $enumData) {
            if ($enumData['key'] == $key) {
                return $enumData['value'];
            }
        }

        return null;
    }
}
