<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Men Clothing', 'slug' => 'men-clothing', 'description' => 'Men\'s fashion and clothing items'],
            ['name' => 'Women Clothing', 'slug' => 'women-clothing', 'description' => 'Women\'s fashion and clothing items'],
            ['name' => 'Footwear', 'slug' => 'footwear', 'description' => 'Shoes and footwear for all'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'description' => 'Bags, belts, and other accessories'],
            ['name' => 'Electronics', 'slug' => 'electronics', 'description' => 'Electronic gadgets and devices'],
            ['name' => 'Home & Living', 'slug' => 'home-living', 'description' => 'Home decor and living essentials'],
        ];

        foreach ($categories as $category) {
            Category::create(array_merge($category, ['is_active' => true]));
        }
    }
}
