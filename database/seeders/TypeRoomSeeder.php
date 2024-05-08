<?php

namespace Database\Seeders;

use App\Enums\Room\PriceType;
use App\Models\RoomPrice;
use App\Models\TypeRoom;
use Carbon\Carbon;
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
            TypeRoom::create([
                    'name' => $typeRoom,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
        }
    }
}
