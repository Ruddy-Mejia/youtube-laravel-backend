<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Seeder;

class InteractionSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'rmejiam.dev@gmail.com',
            'channel_name' => 'admin',
            'status' => true,
            'password' => bcrypt('password'),
        ]);
        $users = User::factory(99)->create();
        $videos = Video::factory(100)->create();
        //  Video::all();

        foreach ($users as $user) {
            $otherUsers = User::where('id', '!=', $user->id)->pluck('id');

            if ($videos->isNotEmpty()) {
                $likeCount = min(rand(0, 5), $videos->count());
                $user->likedVideos()->syncWithoutDetaching(
                    $videos->random($likeCount)->pluck('id')
                );
            }

            if ($otherUsers->isNotEmpty()) {
                $subCount = min(rand(0, 3), $otherUsers->count());
                $user->subscriptions()->syncWithoutDetaching(
                    $otherUsers->random($subCount)
                );
            }
        }
    }
}