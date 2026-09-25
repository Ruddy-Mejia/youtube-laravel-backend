<?php

namespace Database\Factories;

use App\Models\Video;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    
    //id, user_id (FK), title, description, thumbnail_path, views (default 0), duration, timestamps
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'thumbnail_path' => $this->faker->imageUrl(640, 480, 'video'),
            'views' => $this->faker->numberBetween(0, 10000),
            'duration' => $this->faker->time('H:i:s'),
        ];
    }
}
