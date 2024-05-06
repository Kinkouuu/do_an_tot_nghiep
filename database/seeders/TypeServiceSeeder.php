<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $baseServiceTypes = [
            [
                'icon' => 'fa-solid fa-champagne-glasses',
                'name' => 'Ăn uống',
            ],
            [
                'icon' => 'fa-solid fa-taxi',
                'name' => 'Xe đưa đón',
            ],
            [
                'icon' => 'fa-solid fa-dumbbell',
                'name' => 'Fitness',
            ],
            [
                'icon' => 'fa-solid fa-shirt',
                'name' =>  'Giặt là',
            ],
            [
                'icon' => 'fa-solid fa-heart-pulse',
                'name' =>  'Spa',
            ],
            [
                'icon' => 'fa-solid fa-tents',
                'name' =>  'Khu vui chơi',
            ],
            [
                'icon' => 'fa-solid fa-umbrella-beach',
                'name' =>   'Bể bơi',
            ],
            [
                'icon' => 'fa-solid fa-handshake',
                'name' =>  'Thuê hội trường'
            ],
            [
                'icon' => 'fa-solid fa-microchip',
                'name' =>  'Thuê thiết bị/vật dụng',
            ],
        ];

        foreach ($baseServiceTypes as $serviceType)
        {
            DB::table('type_services')->insert([
                'icon' => $serviceType['icon'],
                'name'=>$serviceType['name'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
                ]);
        }
    }
}
