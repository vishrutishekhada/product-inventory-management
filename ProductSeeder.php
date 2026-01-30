<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['name' => 'Laptop HP EliteBook', 'sku' => 'ELEC-001', 'category' => 'Electronics', 'brand' => 'HP', 'cost_price' => 45000, 'selling_price' => 55000, 'quantity' => 15],
            ['name' => 'Wireless Mouse', 'sku' => 'ELEC-002', 'category' => 'Electronics', 'brand' => 'Logitech', 'cost_price' => 800, 'selling_price' => 1200, 'quantity' => 50],
            ['name' => 'Office Desk', 'sku' => 'FURN-001', 'category' => 'Furniture', 'brand' => 'IKEA', 'cost_price' => 8000, 'selling_price' => 12000, 'quantity' => 10],
            ['name' => 'Office Chair', 'sku' => 'FURN-002', 'category' => 'Furniture', 'brand' => 'HermanMiller', 'cost_price' => 15000, 'selling_price' => 20000, 'quantity' => 8],
            ['name' => 'A4 Paper Pack', 'sku' => 'STAT-001', 'category' => 'Stationery', 'brand' => 'JK', 'cost_price' => 200, 'selling_price' => 280, 'quantity' => 100],
            ['name' => 'Ballpoint Pen', 'sku' => 'STAT-002', 'category' => 'Stationery', 'brand' => 'Parker', 'cost_price' => 50, 'selling_price' => 80, 'quantity' => 200],
            ['name' => 'Coffee Beans 1kg', 'sku' => 'FOOD-001', 'category' => 'Food & Beverages', 'brand' => 'Starbucks', 'cost_price' => 600, 'selling_price' => 900, 'quantity' => 30],
            ['name' => 'Green Tea Pack', 'sku' => 'FOOD-002', 'category' => 'Food & Beverages', 'brand' => 'Lipton', 'cost_price' => 120, 'selling_price' => 180, 'quantity' => 60],
            ['name' => 'T-Shirt Cotton', 'sku' => 'CLOT-001', 'category' => 'Clothing', 'brand' => 'Nike', 'cost_price' => 400, 'selling_price' => 699, 'quantity' => 40],
            ['name' => 'Jeans Denim', 'sku' => 'CLOT-002', 'category' => 'Clothing', 'brand' => 'Levis', 'cost_price' => 1200, 'selling_price' => 1899, 'quantity' => 25],
            ['name' => 'Programming Python', 'sku' => 'BOOK-001', 'category' => 'Books', 'brand' => 'OReilly', 'cost_price' => 400, 'selling_price' => 599, 'quantity' => 20],
            ['name' => 'Clean Code', 'sku' => 'BOOK-002', 'category' => 'Books', 'brand' => 'Prentice Hall', 'cost_price' => 500, 'selling_price' => 750, 'quantity' => 15],
            ['name' => 'Football Size 5', 'sku' => 'SPRT-001', 'category' => 'Sports', 'brand' => 'Adidas', 'cost_price' => 800, 'selling_price' => 1299, 'quantity' => 20],
            ['name' => 'Tennis Racket', 'sku' => 'SPRT-002', 'category' => 'Sports', 'brand' => 'Wilson', 'cost_price' => 2000, 'selling_price' => 3000, 'quantity' => 12],
            ['name' => 'Yoga Mat', 'sku' => 'SPRT-003', 'category' => 'Sports', 'brand' => 'Liforme', 'cost_price' => 600, 'selling_price' => 999, 'quantity' => 18],
            ['name' => 'LED Monitor 24"', 'sku' => 'ELEC-003', 'category' => 'Electronics', 'brand' => 'Dell', 'cost_price' => 8000, 'selling_price' => 11000, 'quantity' => 12],
            ['name' => 'Keyboard Mechanical', 'sku' => 'ELEC-004', 'category' => 'Electronics', 'brand' => 'Corsair', 'cost_price' => 3000, 'selling_price' => 4500, 'quantity' => 20],
            ['name' => 'USB Flash Drive 32GB', 'sku' => 'ELEC-005', 'category' => 'Electronics', 'brand' => 'SanDisk', 'cost_price' => 300, 'selling_price' => 499, 'quantity' => 80],
            ['name' => 'Notebook A5', 'sku' => 'STAT-003', 'category' => 'Stationery', 'brand' => 'Classmate', 'cost_price' => 40, 'selling_price' => 70, 'quantity' => 150],
            ['name' => 'Whiteboard Marker', 'sku' => 'STAT-004', 'category' => 'Stationery', 'brand' => 'Camlin', 'cost_price' => 30, 'selling_price' => 50, 'quantity' => 120],
        ];

        foreach ($products as $product) {
            $category = Category::where('name', $product['category'])->first();

            Product::create([
                'name' => $product['name'],
                'sku' => $product['sku'],
                'category_id' => $category->id,
                'brand' => $product['brand'],
                'description' => 'High quality ' . $product['name'],
                'cost_price' => $product['cost_price'],
                'selling_price' => $product['selling_price'],
                'quantity' => $product['quantity'],
                'reorder_level' => 10,
                'status' => 'active',
            ]);
        }
    }
}
