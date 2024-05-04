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
            'Ăn uống',
            'Xe đưa đón',
            'Fitness',
            'Giặt là',
            'Spa',
            'Khu vui chơi',
            'Bể bơi',
            'Thuê hội trường'
        ];

        foreach ($baseServiceTypes as $serviceType)
        {
            DB::table('type_services')->insert([
                'name'=>$serviceType,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
                ]);
        }
    }
}
