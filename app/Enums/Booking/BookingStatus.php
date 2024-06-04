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
    const AwaitingPayment = [
        'key' => '0',
        'value' => 'Đang chờ thanh toán',
    ];
    const AwaitingConfirm = [
        'key' => '1',
        'value' => 'Đang chờ xác nhận',
    ];
    const Confirmed = [
        'key' => '2',
        'value' => 'Đã được xác nhận bởi quản trị viên',
    ];
    const Approved = [
        'key' => '3',
        'value' => 'Đã được hệ thống tự động xác nhận',
    ];
    const Canceled = [
        'key' => '4',
        'value' => 'Đơn đã bị hủy',
    ];
    const Refuse = [
        'key' => '5',
        'value' => 'Đơn đặt bị từ chối',
    ];
    const Completed = [
      'key' => '6',
      'value' => 'Đã hoàn thành',
    ];

    public static function getDeActiveBooking()
    {
        return [
            self::Canceled['key'],
            self::Refuse['key']
        ];
    }

    public static function getConfirmedBooking()
    {
        return [
            self::Confirmed['key'],
            self::Approved['key'],
            self::Completed['key'],
        ];
    }
}
