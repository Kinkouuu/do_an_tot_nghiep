<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UserSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(TypeServiceSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(TypeDeviceSeeder::class);
        $this->call(DeviceSeeder::class);
        $this->call(TypeRoomSeeder::class);
        $this->call(RoomCapacitySeeder::class);
        $this->call(BranchSeeder::class);
    }
}
