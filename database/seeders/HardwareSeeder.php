<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Master\Hardware;

class HardwareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hardware::insert(
        [
            [
                'device_id' => 'line1',
                'type'      => 'line',
                'name'      => 'Line 1',
                'status'    => true,
            ],
            [
                'device_id' => 'line2',
                'type'      => 'line',
                'name'      => 'Line 2',
                'status'    => true,
            ],
            [
                'device_id' => 'line3',
                'type'      => 'line',
                'name'      => 'Line 3',
                'status'    => true,
            ],
        ]

        );
        
    }
}
