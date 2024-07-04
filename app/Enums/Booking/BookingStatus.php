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
        'value' => 'Chờ thanh toán',
    ];
    const AwaitingConfirm = [
        'key' => '1',
        'value' => 'Chờ xác nhận',
    ];
    const Confirmed = [
        'key' => '2',
        'value' => 'Đã xác nhận',
    ];
    const Approved = [
        'key' => '3',
        'value' => 'Hệ thống tự động xác nhận',
    ];
    const Canceled = [
        'key' => '4',
        'value' => 'Đã bị hủy',
    ];
    const Refuse = [
        'key' => '5',
        'value' => 'Bị từ chối',
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

    public static function getAwaitingBooking()
    {
        return[
            self::AwaitingConfirm['key'],
            self::AwaitingPayment['key'],
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
