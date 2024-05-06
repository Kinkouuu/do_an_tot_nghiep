<?php

namespace Database\Seeders;

use App\Models\TypeRoom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $typeRooms = [
            'Standard',
            'Superior',
            'Deluxe',
            'Suite'
        ];

        foreach ($typeRooms as $typeRoom) {
            TypeRoom::create(
                [
                    'name' => $typeRoom,
                ]
            );
        }
    }
}
