<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Electronics', 'description' => 'Electronic devices and accessories', 'status' => 'active'],
            ['name' => 'Furniture', 'description' => 'Office and home furniture', 'status' => 'active'],
            ['name' => 'Stationery', 'description' => 'Office supplies and stationery items', 'status' => 'active'],
            ['name' => 'Food & Beverages', 'description' => 'Food products and drinks', 'status' => 'active'],
            ['name' => 'Clothing', 'description' => 'Apparel and accessories', 'status' => 'active'],
            ['name' => 'Books', 'description' => 'Books and publications', 'status' => 'active'],
            ['name' => 'Sports', 'description' => 'Sports equipment and gear', 'status' => 'active'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
