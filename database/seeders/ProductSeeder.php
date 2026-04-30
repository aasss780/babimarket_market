<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seller = User::where('role', 'seller')->first();
        if (! $seller) {
            return;
        }
        $category = Category::first();
        if (! $category) {
            return;
        }
        for ($i = 1; $i <= 12; $i++) {
            Product::create([
                'seller_id' => $seller->id,
                'category_id' => $category->id,
                'name' => "Sample Baby Product {$i}",
                'description' => 'Safe and quality baby item for marketplace demo.',
                'price' => rand(10, 120),
                'old_price' => rand(121, 180),
                'stock' => rand(5, 50),
                'status' => 'active',
            ]);
        }
    }
}
