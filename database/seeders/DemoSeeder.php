<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Electronics' => ['Smartphones', 'Laptops', 'Tablets', 'Accessories'],
            'Clothing' => ['Men', 'Women', 'Kids', 'Sports'],
            'Food & Beverage' => ['Snacks', 'Drinks', 'Fresh', 'Frozen'],
            'Home & Living' => ['Furniture', 'Kitchen', 'Decor', 'Lighting'],
        ];

        foreach ($categories as $catName => $subs) {
            $catId = DB::table('categories')->insertGetId([
                'name' => $catName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($subs as $subName) {
                DB::table('subcategories')->insert([
                    'category_id' => $catId,
                    'name' => $subName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $products = [
            ['iPhone 15 Pro', 'ELC-001', 1, 1, 18999000, 25, 'active', 'Latest Apple smartphone with A17 Pro chip'],
            ['Samsung Galaxy S24', 'ELC-002', 1, 1, 14999000, 40, 'active', 'Samsung flagship with AI features'],
            ['MacBook Air M3', 'ELC-003', 1, 2, 19499000, 15, 'active', '13-inch laptop with M3 chip'],
            ['iPad Pro 12.9"', 'ELC-004', 1, 3, 17999000, 10, 'active', 'Pro tablet with M2 chip'],
            ['AirPods Pro 2', 'ELC-005', 1, 4, 3999000, 100, 'active', 'Active noise cancellation earbuds'],
            ['USB-C Hub 7in1', 'ELC-006', 1, 4, 499000, 200, 'active', 'Multi-port adapter for laptops'],
            ['Lenovo ThinkPad X1', 'ELC-007', 1, 2, 22999000, 8, 'active', 'Business ultrabook'],
            ['Google Pixel 8', 'ELC-008', 1, 1, 10999000, 30, 'inactive', 'Google phone with Tensor G3'],

            ['Polo Shirt Classic', 'CLT-001', 2, 5, 299000, 150, 'active', 'Premium cotton polo shirt'],
            ['Denim Jacket', 'CLT-002', 2, 5, 599000, 45, 'active', 'Classic blue denim jacket'],
            ['Summer Dress', 'CLT-003', 2, 6, 449000, 60, 'active', 'Floral pattern summer dress'],
            ['Kids T-Shirt Pack', 'CLT-004', 2, 7, 199000, 200, 'active', 'Pack of 3 cotton t-shirts'],
            ['Running Shoes', 'CLT-005', 2, 8, 899000, 80, 'active', 'Lightweight running shoes'],
            ['Yoga Pants', 'CLT-006', 2, 8, 349000, 120, 'inactive', 'High-waist stretch yoga pants'],

            ['Chocolate Cookies', 'FNB-001', 3, 9, 45000, 500, 'active', 'Premium chocolate chip cookies'],
            ['Green Tea Matcha', 'FNB-002', 3, 10, 35000, 300, 'active', 'Japanese matcha green tea'],
            ['Fresh Salmon 500g', 'FNB-003', 3, 11, 120000, 20, 'active', 'Norwegian fresh salmon fillet'],
            ['Frozen Pizza', 'FNB-004', 3, 12, 65000, 150, 'active', 'Italian-style frozen pizza'],
            ['Energy Drink 6-Pack', 'FNB-005', 3, 10, 89000, 400, 'active', 'Sugar-free energy drink'],
            ['Organic Granola', 'FNB-006', 3, 9, 78000, 180, 'inactive', 'Organic oat granola with nuts'],

            ['Sofa 3-Seater', 'HML-001', 4, 13, 5999000, 5, 'active', 'Modern minimalist 3-seater sofa'],
            ['Knife Set 8pcs', 'HML-002', 4, 14, 899000, 35, 'active', 'Professional kitchen knife set'],
            ['Wall Art Canvas', 'HML-003', 4, 15, 299000, 50, 'active', 'Abstract wall art canvas print'],
            ['LED Desk Lamp', 'HML-004', 4, 16, 459000, 75, 'active', 'Adjustable LED desk lamp with USB'],
            ['Bookshelf Oak', 'HML-005', 4, 13, 2499000, 10, 'inactive', '5-tier oak wood bookshelf'],
        ];

        foreach ($products as $p) {
            DB::table('products')->insert([
                'name' => $p[0],
                'sku' => $p[1],
                'category_id' => $p[2],
                'subcategory_id' => $p[3],
                'price' => $p[4],
                'stock' => $p[5],
                'status' => $p[6],
                'description' => $p[7],
                'created_at' => now()->subDays(rand(1, 90)),
                'updated_at' => now()->subDays(rand(0, 30)),
            ]);
        }
    }
}
