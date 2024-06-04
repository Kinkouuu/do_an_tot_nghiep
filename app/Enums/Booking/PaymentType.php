<?php declare(strict_types=1);

namespace App\Enums\Booking;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PaymentType extends Enum
{
    const Cash = 'Cash';
    const VNPay = 'VnMart';
    const DebitCard = 'Visa';

    public static function getPaymentType()
    {
        return [
            [
                'type' => self::Cash,
                'name' => 'Tiền mặt',
                'icon' => 'fa-solid fa-coins'
            ],
            [
                'type' => self::VNPay,
                'name' => 'Ví điện tử VNPay',
                'icon' => 'fa-solid fa-qrcode'
            ],
            [
                'type' => self::DebitCard,
                'name' => 'Thẻ Visa Debit',
                'icon' => 'fa-regular fa-credit-card'
            ],
        ];
    }
}
