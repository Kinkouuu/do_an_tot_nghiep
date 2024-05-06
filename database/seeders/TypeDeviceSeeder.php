<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeDeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $baseDeviceTypes = [
            [
                'icon' => 'fa-solid fa-bed',
                'name' => 'Giường',
            ],
            [
                'icon' => 'fa-solid fa-fan',
                'name' => 'Điều hòa',
            ],
            [
                'icon' => 'fa-solid fa-bath',
                'name' => 'Thiết bị vệ sinh',
            ],
            [
                'icon' => 'fa-solid fa-tv',
                'name' =>  'Thiết bị điện tử',
            ],
            [
                'icon' => 'fa-solid fa-tents',
                'name' =>  'Các thiết bị khác',
            ],

        ];

        foreach ($baseDeviceTypes as $deviceType)
        {
            DB::table('type_devices')->insert([
                'icon' => $deviceType['icon'],
                'name'=>$deviceType['name'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
