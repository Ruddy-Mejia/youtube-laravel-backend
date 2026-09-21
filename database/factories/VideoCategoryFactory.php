<?php

namespace Database\Factories;

use App\Models\Video_category;
use App\Models\Video;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoCategoryFactory extends Factory
{
    public function definition(): array
    {
        //video_id, category_id
        return [
            'video_id' => Video::inRandomOrder()->first()?->id ?? 1,
            'category_id' => Category::inRandomOrder()->first()?->id ?? 1,
        ];
    }
}
