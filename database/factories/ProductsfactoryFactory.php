<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductsFactory extends Factory
{
    protected $model = Products::class;

    public function definition(): array
    {
        $colorIds = Color::pluck('id')->toArray();   
        $numberOfColorsToSelect = rand(1, min(4, count($colorIds)));  
        $colors = collect($colorIds)->random($numberOfColorsToSelect)->all();
        $colorString = implode(',', $colors);  

        $categoryIds = Category::pluck('id')->toArray();
        $categoryId = collect($categoryIds)->random();

        $brandIds = Brand::pluck('id')->toArray();   
        $brandId = collect($brandIds)->random(); 

        $currentTimestamp = Carbon::now()->toDateTimeString();  

        return [  
            "name" => $this->faker->text(20),  
            "price" => $this->faker->numberBetween(200, 1500),  
            "qty"   => $this->faker->numberBetween(5, 15),  
            "desc" => $this->faker->paragraph(3),  
            "category_id" => $categoryId,   
            "brand_id" => $brandId, 
            "color" => $colorString,  
            "user_id" => 1,  
            "created_at" => $currentTimestamp, 
            "updated_at" => $currentTimestamp, 
        ];
    }
}