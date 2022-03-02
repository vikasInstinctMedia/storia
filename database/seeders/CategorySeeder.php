<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function __construct()
    {
        $this->data = [
            [
                'name'            => '100% Juice',
                'slug'            => 'storia-100-juice',
                'banner_image'    => "categories/wKsWJ7DQazuKmr0N5ZnhDFPnPNI7uq3ZwBoMbCqs.png",
                'thumbnail_image' => "categories/wKsWJ7DQazuKmr0N5ZnhDFPnPNI7uq3ZwBoMbCqs.png"
            ],
            [
                'name'            => 'Storia Shakes',
                'slug'            => 'storia-shakes-range',
                'banner_image'    => "categories/wKsWJ7DQazuKmr0N5ZnhDFPnPNI7uq3ZwBoMbCqs.png",
                'thumbnail_image' => "categories/wKsWJ7DQazuKmr0N5ZnhDFPnPNI7uq3ZwBoMbCqs.png"
            ],
            [
                'name'            => 'Coconut Water',
                'slug'            => 'coconut-water-range',
                'banner_image'    => "categories/wKsWJ7DQazuKmr0N5ZnhDFPnPNI7uq3ZwBoMbCqs.png",
                'thumbnail_image' => "categories/wKsWJ7DQazuKmr0N5ZnhDFPnPNI7uq3ZwBoMbCqs.png"
            ],
        ];
    }
    public function run()
    {
        // dd($this->data);
        foreach($this->data as $value) {
            Category::create($value);
        }
        
    }
}
