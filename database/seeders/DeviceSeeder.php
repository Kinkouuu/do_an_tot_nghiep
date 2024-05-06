<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $devices = [
            [
                'type_device_id' => 1,
                'name' => 'Giường đơn',
            ],
            [
                'type_device_id' => 1,
                'name' => 'Giường đôi',
            ],
            [
                'type_device_id' => 1,
                'name' => 'Giường gia đình',
            ],
            [
                'type_device_id' => 1,
                'name' => 'Nôi trẻ em',
                'for_rent' => 1
            ],
            [
                'type_device_id' => 2,
                'name' => 'Điều hòa 1 chiều',
            ],
            [
                'type_device_id' => 2,
                'name' => 'Điều hòa 2 chiều',
            ],
            [
                'type_device_id' => 2,
                'name' => 'Quạt trần',
            ],
            [
                'type_device_id' => 2,
                'name' => 'Máy lọc không khí',
                'brand' => 'Xiaomi',
                'for_rent' => '1'
            ],
            [
                'type_device_id' => 3,
                'name' => 'Bồn tắm',
            ],
            [
                'type_device_id' => 4,
                'name' => 'TV',
            ],
            [
                'type_device_id' => 4,
                'name' => 'Máy tính xách tay',
                'brand' => 'Dell',
                'for_rent' => '1'
            ],
            [
                'type_device_id' => 4,
                'name' => 'Máy tính để bàn',
                'brand' => 'Asus',
                'for_rent' => '1'
            ],
            [
                'type_device_id' => 5,
                'name' => 'Két bảo mật',
                'brand' => 'Lock&Lock',
                'for_rent' => '1'
            ],
        ];

        foreach ($devices as $device) {
            $device['rental_price'] = random_int(0, 1000000);
            $device['quantity'] = random_int(0, 100);
            Device::create($device);
        }
    }
}
