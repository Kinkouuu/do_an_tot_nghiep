<?php

return [
    'max_room_img'  => 4,
    'item_per_page' => 15,
    'random_branch_number' => 3,
    'room_capacity' => [
        'family' => ['adults' => 2, 'children' => 2,],
        'double' => ['adults' => 2, 'children' => 1,],
        'twin'   => ['adults' => 1, 'children' => 2,],
        'single' => ['adults' => 1, 'children' => 1,]
    ],
    'title_booking_notification' => [
      'awaiting_confirm' => 'Đặt phòng thành công! Vui lòng để ý điện thoại, nhân viên tư vấn sẽ gọi điện cho bạn để xác nhận lại thông tin sau ít phút.',
      'approved' => 'Đơn đặt của bạn đã được xác nhận tự động bởi hệ thống!',
      'refuse'=> 'Thật tiếc quá, đơn đặt của bạn đã bị từ chối với lí do: ',
    ],
    'route_not_include_carousel' => ['booking.confirm', 'booking.list', 'booking.show'],
    'convert_time' => [
      'day' => 60 * 60 * 24,
      'hour' => 60 * 60,
      'min' => 60
    ],
];
