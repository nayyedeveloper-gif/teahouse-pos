<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // Hot Coffee
            ['category' => 'Hot Coffee', 'name' => 'Espresso', 'name_mm' => 'အက်စ်ပရက်ဆို', 'price' => 2000],
            ['category' => 'Hot Coffee', 'name' => 'Americano', 'name_mm' => 'အမေရိကန်နို', 'price' => 2500],
            ['category' => 'Hot Coffee', 'name' => 'Cappuccino', 'name_mm' => 'ကက်ပူချီနို', 'price' => 3000],
            ['category' => 'Hot Coffee', 'name' => 'Latte', 'name_mm' => 'လာတေး', 'price' => 3000],
            ['category' => 'Hot Coffee', 'name' => 'Mocha', 'name_mm' => 'မိုကာ', 'price' => 3500],
            
            // Iced Coffee
            ['category' => 'Iced Coffee', 'name' => 'Iced Americano', 'name_mm' => 'အမေရိကန်နိုအေး', 'price' => 3000],
            ['category' => 'Iced Coffee', 'name' => 'Iced Latte', 'name_mm' => 'လာတေးအေး', 'price' => 3500],
            ['category' => 'Iced Coffee', 'name' => 'Iced Mocha', 'name_mm' => 'မိုကာအေး', 'price' => 4000],
            ['category' => 'Iced Coffee', 'name' => 'Iced Caramel Macchiato', 'name_mm' => 'ကာရာမယ်မက်ကီအာတိုအေး', 'price' => 4500],
            
            // Tea
            ['category' => 'Tea', 'name' => 'Green Tea', 'name_mm' => 'လက်ဖက်စိမ်း', 'price' => 1500],
            ['category' => 'Tea', 'name' => 'Black Tea', 'name_mm' => 'လက်ဖက်နက်', 'price' => 1500],
            ['category' => 'Tea', 'name' => 'Lemon Tea', 'name_mm' => 'သံပုရာလက်ဖက်', 'price' => 2000],
            ['category' => 'Tea', 'name' => 'Ginger Tea', 'name_mm' => 'ဂျင်းလက်ဖက်', 'price' => 2000],
            
            // Milk Tea
            ['category' => 'Milk Tea', 'name' => 'Myanmar Milk Tea', 'name_mm' => 'မြန်မာနို့လက်ဖက်', 'price' => 1500],
            ['category' => 'Milk Tea', 'name' => 'Thai Milk Tea', 'name_mm' => 'ထိုင်းနို့လက်ဖက်', 'price' => 2500],
            ['category' => 'Milk Tea', 'name' => 'Bubble Milk Tea', 'name_mm' => 'ပုလဲနို့လက်ဖက်', 'price' => 3000],
            
            // Juice
            ['category' => 'Juice', 'name' => 'Orange Juice', 'name_mm' => 'လိမ္မော်ရည်', 'price' => 2500],
            ['category' => 'Juice', 'name' => 'Lime Juice', 'name_mm' => 'သံပုရာရည်', 'price' => 2000],
            ['category' => 'Juice', 'name' => 'Watermelon Juice', 'name_mm' => 'ဖရဲသီးဖျော်ရည်', 'price' => 2500],
            ['category' => 'Juice', 'name' => 'Mango Juice', 'name_mm' => 'သရက်သီးဖျော်ရည်', 'price' => 3000],
            
            // Smoothies
            ['category' => 'Smoothies', 'name' => 'Strawberry Smoothie', 'name_mm' => 'စတော်ဘယ်ရီချောမွေ့', 'price' => 3500],
            ['category' => 'Smoothies', 'name' => 'Mango Smoothie', 'name_mm' => 'သရက်သီးချောမွေ့', 'price' => 3500],
            ['category' => 'Smoothies', 'name' => 'Avocado Smoothie', 'name_mm' => 'ထောပတ်သီးချောမွေ့', 'price' => 4000],
            
            // Snacks
            ['category' => 'Snacks', 'name' => 'French Fries', 'name_mm' => 'အာလူးကြော်', 'price' => 2500],
            ['category' => 'Snacks', 'name' => 'Spring Rolls', 'name_mm' => 'ကော်ပြန့်', 'price' => 3000],
            ['category' => 'Snacks', 'name' => 'Samosa', 'name_mm' => 'ဆမူဆာ', 'price' => 1500],
            ['category' => 'Snacks', 'name' => 'Chicken Wings', 'name_mm' => 'ကြက်သားတောင်ပံ', 'price' => 4000],
            
            // Breakfast
            ['category' => 'Breakfast', 'name' => 'Mohinga', 'name_mm' => 'မုန့်ဟင်းခါး', 'price' => 2000],
            ['category' => 'Breakfast', 'name' => 'Shan Noodles', 'name_mm' => 'ရှမ်းခေါက်ဆွဲ', 'price' => 2500],
            ['category' => 'Breakfast', 'name' => 'Nan Gyi Thoke', 'name_mm' => 'နန်းကြီးသုပ်', 'price' => 2500],
            
            // Noodles
            ['category' => 'Noodles', 'name' => 'Fried Noodles', 'name_mm' => 'ခေါက်ဆွဲကြော်', 'price' => 3000],
            ['category' => 'Noodles', 'name' => 'Soup Noodles', 'name_mm' => 'ခေါက်ဆွဲချို', 'price' => 3000],
            
            // Rice
            ['category' => 'Rice', 'name' => 'Fried Rice', 'name_mm' => 'ထမင်းကြော်', 'price' => 3500],
            ['category' => 'Rice', 'name' => 'Chicken Rice', 'name_mm' => 'ကြက်သားထမင်း', 'price' => 4000],
            
            // Desserts
            ['category' => 'Desserts', 'name' => 'Cake Slice', 'name_mm' => 'ကိတ်မုန့်', 'price' => 2500],
            ['category' => 'Desserts', 'name' => 'Ice Cream', 'name_mm' => 'ရေခဲမုန့်', 'price' => 2000],
            ['category' => 'Desserts', 'name' => 'Brownie', 'name_mm' => 'ဘရောင်နီ', 'price' => 3000],
        ];

        foreach ($items as $itemData) {
            $category = Category::where('name', $itemData['category'])->first();
            
            if ($category) {
                Item::create([
                    'category_id' => $category->id,
                    'name' => $itemData['name'],
                    'name_mm' => $itemData['name_mm'],
                    'price' => $itemData['price'],
                    'is_available' => true,
                    'is_active' => true,
                ]);
            }
        }
    }
}
