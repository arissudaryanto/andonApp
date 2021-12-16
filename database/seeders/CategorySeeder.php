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
        Category::create([
            'name' => 'Kategori 1',
            'status' => true,
        ]);

        Category::create([
            'name' => 'Kategori 2',
            'status' => true,
        ]);
    }
}
