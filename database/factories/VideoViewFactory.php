<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoViewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'video_id' => Video::inRandomOrder()->first()?->id ?? Video::factory(),
            'viewed_at' => now(),
        ];
    }
}