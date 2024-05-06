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
                'icon' => '<i class="fa-solid fa-champagne-glasses"></i>',
                'name' => 'Ăn uống',
            ],
            [
                'icon' => '<i class="fa-solid fa-taxi"></i>',
                'name' => 'Xe đưa đón',
            ],
            [
                'icon' => '<i class="fa-solid fa-dumbbell"></i>',
                'name' => 'Fitness',
            ],
            [
                'icon' => '<i class="fa-solid fa-shirt"></i>',
                'name' =>  'Giặt là',
            ],
            [
                'icon' => '<i class="fa-solid fa-heart-pulse"></i>',
                'name' =>  'Spa',
            ],
            [
                'icon' => '<i class="fa-solid fa-tents"></i>',
                'name' =>  'Khu vui chơi',
            ],
            [
                'icon' => '<i class="fa-solid fa-umbrella-beach"></i>',
                'name' =>   'Bể bơi',
            ],
            [
                'icon' => '<i class="fa-solid fa-handshake"></i>',
                'name' =>  'Thuê hội trường'
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
