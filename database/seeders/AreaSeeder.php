<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Master\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::create([
            'code' => 'AR1',
            'name' => 'Area 1',
            'status' => true,
        ]);

        Area::create([
            'code' => 'AR2',
            'name' => 'Area 2',
            'status' => true,
        ]);

        Area::create([
            'code' => 'AR3',
            'name' => 'Area 3',
            'status' => true,
        ]);

        Area::create([
            'code' => 'AR4',
            'name' => 'Area 4',
            'status' => true,
        ]);
    }
}