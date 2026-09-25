<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\VideoView;
use Illuminate\Database\Seeder;

class VideoViewSeeder extends Seeder
{
    public function run(): void
    {
        VideoView::factory(100)->create();
    }
}
