<?php

namespace Database\Factories;

use App\Models\Comments;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inrandomOrder()->first()->id ?? 1,
            'video_id' => Video::inrandomOrder()->first()->id ?? 1,
            'body' => $this->faker->paragraph(),
        ];
    }
}
