<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['Baby Clothing', 'Toys & Games', 'Feeding', 'Nursery', 'Health & Safety', 'Strollers'] as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
    }
}
