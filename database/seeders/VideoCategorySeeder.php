<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\VideoCategory;
use Illuminate\Database\Seeder;

class VideoCategorySeeder extends Seeder
{
    public function run(): void
    {
        VideoCategory::factory(100)->create();
    }
}
