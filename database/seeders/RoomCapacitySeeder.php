<?php

namespace Database\Seeders;

use App\Models\RoomCapacity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomCapacitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roomCapacities = [
            [
                'name' => 'Single Bedroom (SGL)',
                'single_bed' => 1,
                'twin_bed' => 0,
            ],
            [
                'name' => 'Twin Bedroom (TWN)',
                'single_bed' => 2,
                'twin_bed' => 0,
            ],
            [
                'name' => 'Double Bedroom (DBL)',
                'single_bed' => 0,
                'twin_bed' => 1,
            ],
            [
                'name' => 'Triple Bedroom (TRPL)',
                'single_bed' => 1,
                'twin_bed' => 1,
            ],
            [
                'name' => 'Family Bedroom (FML)',
                'single_bed' => 0,
                'twin_bed' => 2,
            ],
        ];

        foreach ($roomCapacities as $roomCapacity)
        {
            RoomCapacity::create($roomCapacity);
        }
    }
}
