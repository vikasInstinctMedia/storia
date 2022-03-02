<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {   
        $name = $this->faker->name();
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'sku'  => Str::slug($name),
            'description' => $this->faker->text(),
            'amount'      => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 50, $max = 600),
            'banner_image'    =>'',
            'thumbnail_image' =>'',
            'quantity'      => $this->faker->numberBetween(20,50),
            'is_active'     => 1
        ];
    }

}
