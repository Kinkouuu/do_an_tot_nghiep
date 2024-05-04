<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                'type_service_id' => 1,
                'name' => "Bữa sáng tại phòng",
            ],
            [
                'type_service_id' => 1,
                'name' => "Buffet sáng tại nhà hàng",
            ],
            [
                'type_service_id' => 1,
                'name' => "Bữa trưa tại phòng",
            ],
            [
                'type_service_id' => 1,
                'name' => "Buffet trưa tại nhà hàng",
            ],
            [
                'type_service_id' => 1,
                'name' => "Bữa tối tại phòng",
            ],            [
                'type_service_id' => 1,
                'name' => "Buffet tối tại phòng",
            ],
            [
                'type_service_id' => 1,
                'name' => "Bữa đêm tại phòng",
            ],
            [
                'type_service_id' => 2,
                'name' => "Xe đón tại sân bay về khách sạn",
            ],
            [
                'type_service_id' => 2,
                'name' => "Xe đưa ra sân bay từ khách sạn",
            ],
            [
                'type_service_id' => 2,
                'name' => "Xe đưa đón khứ hồi",
            ],
            [
                'type_service_id' => 2,
                'name' => "Phòng tập gym",
            ],
            [
                'type_service_id' => 2,
                'name' => "Phòng tập yoga",
            ],
            [
                'type_service_id' => 3,
                'name' => "Giặt sấy lấy ngay",
            ],
            [
                'type_service_id' => 3,
                'name' => "Giặt sấy hàng ngày",
            ],
            [
                'type_service_id' => 3,
                'name' => "Giặt là hơi",
            ],
            [
                'type_service_id' => 3,
                'name' => "Spa toàn thân",
            ],
            [
                'type_service_id' => 3,
                'name' => "Châm cứu, bấm huyệt đông y",
            ],
            [
                'type_service_id' => 4,
                'name' => "Khu vui chơi thiếu nhi",
            ],
            [
                'type_service_id' => 4,
                'name' => "Khu vui chơi mạo hiểm",
            ],
            [
                'type_service_id' => 5,
                'name' => "Bể bơi ngoài trời",
            ],
            [
                'type_service_id' => 5,
                'name' => "Bể bơi nước ngọt",
            ],
            [
                'type_service_id' => 5,
                'name' => "Biển nhân tạo",
            ],
            [
                'type_service_id' => 5,
                'name' => "Hội trường đám cưới",
            ],
            [
                'type_service_id' => 5,
                'name' => "Phòng họp",
            ],
        ];

        foreach ($services as $service) {
            $service['price'] = random_int(100000, 1000000);
            Service::create($service);
        }
    }
}
