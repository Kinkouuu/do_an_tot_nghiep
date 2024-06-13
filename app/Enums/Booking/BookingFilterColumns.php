<?php declare(strict_types=1);

namespace App\Enums\Booking;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class BookingFilterColumns extends Enum
{
    const BookingId = [
        'key' => 'booking_id',
        'value' => 'Mã đơn đặt',
    ];
    const BranchName = [
        'key' => 'branch_name',
        'value' => 'Chi nhánh',
    ];
    const CustomerName = [
        'key' => 'name',
        'value' => 'Tên khách hàng',
    ];
    const Status = [
        'key' => 'status',
        'value' => 'Trạng thái',
    ];
    const PaymentType = [
        'key' => 'payment_type',
        'value' => 'Phương thức thanh toán',
    ];
    const Type = [
        'key' => 'type',
        'value' => 'Loại đơn đặt',
    ];
    const TotalRoom = [
        'key' => 'total_room',
        'value' => 'Số lượng phòng',
    ];
    const TotalPrice = [
        'key' => 'total_price',
        'value' => 'Tổng tiền',
    ];
    const CreatedAt = [
        'key' => 'created_at',
        'value' => 'Ngày đặt đơn',
    ];
}
