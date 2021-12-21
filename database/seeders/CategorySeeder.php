<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Master\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert(
            [
                'name' => 'Part NG',
                'status' => true,
            ],
            [
                'name' => 'Part Habis',
                'status' => true,
            ],
            [
                'name' => 'Setting Miss',
                'status' => true,
            ],
            [
                'name' => 'Error Judgement',
                'status' => true,
            ],
            [
                'name' => 'Trouble Mesin',
                'status' => true,
            ],
            [
                'name' => 'Human Error',
                'status' => true,
            ]
        );
        
    }
}
