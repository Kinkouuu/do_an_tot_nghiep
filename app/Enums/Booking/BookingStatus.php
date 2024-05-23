<?php declare(strict_types=1);

namespace App\Enums\Booking;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class BookingStatus extends Enum
{
    const Awaiting = [
        'key' => '0',
        'value' => 'Đang chờ xác nhận',
    ];
    const Confirmed = [
        'key' => '1',
        'value' => 'Đã được xác nhận bởi quản trị viên',
    ];
    const Approved = [
        'key' => '2',
        'value' => 'Đã được hệ thống tự động xác nhận',
    ];
    const Canceled = [
        'key' => '3',
        'value' => 'Đơn đã bị hủy',
    ];
    const Refuse = [
        'key' => '4',
        'value' => 'Đơn đặt bị từ chối',
    ];

    public static function getDeActiveBooking()
    {
        return [
            self::Canceled['key'],
            self::Refuse['key']
        ];
    }
}
