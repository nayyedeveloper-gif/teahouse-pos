<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Hot Coffee',
                'name_mm' => 'ကော်ဖီပူ',
                'printer_type' => 'bar',
                'sort_order' => 1,
            ],
            [
                'name' => 'Iced Coffee',
                'name_mm' => 'ကော်ဖီအေး',
                'printer_type' => 'bar',
                'sort_order' => 2,
            ],
            [
                'name' => 'Tea',
                'name_mm' => 'လက်ဖက်ရည်',
                'printer_type' => 'bar',
                'sort_order' => 3,
            ],
            [
                'name' => 'Milk Tea',
                'name_mm' => 'နို့လက်ဖက်',
                'printer_type' => 'bar',
                'sort_order' => 4,
            ],
            [
                'name' => 'Juice',
                'name_mm' => 'ဖျော်ရည်',
                'printer_type' => 'bar',
                'sort_order' => 5,
            ],
            [
                'name' => 'Smoothies',
                'name_mm' => 'ချောမွေ့သောအချိုရည်',
                'printer_type' => 'bar',
                'sort_order' => 6,
            ],
            [
                'name' => 'Snacks',
                'name_mm' => 'အစားအစာ',
                'printer_type' => 'kitchen',
                'sort_order' => 7,
            ],
            [
                'name' => 'Breakfast',
                'name_mm' => 'မနက်စာ',
                'printer_type' => 'kitchen',
                'sort_order' => 8,
            ],
            [
                'name' => 'Noodles',
                'name_mm' => 'ခေါက်ဆွဲ',
                'printer_type' => 'kitchen',
                'sort_order' => 9,
            ],
            [
                'name' => 'Rice',
                'name_mm' => 'ထမင်း',
                'printer_type' => 'kitchen',
                'sort_order' => 10,
            ],
            [
                'name' => 'Desserts',
                'name_mm' => 'အချိုပွဲ',
                'printer_type' => 'kitchen',
                'sort_order' => 11,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
