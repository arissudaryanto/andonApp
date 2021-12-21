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
                'device_id' => 'line1',
                'area_id'   => 1,
                'name'      => 'Line 1',
                'status'    => true,
            ],
        );
        
    }
}
