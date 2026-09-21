<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //video_id, category_id
    public function up(): void
    {
        Schema::create('video_categories', function (Blueprint $table) {
            $table->foreignId('video_id')->constrained('videos')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('video_categories');
    }
};
