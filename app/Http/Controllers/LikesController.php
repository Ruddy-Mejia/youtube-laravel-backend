<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function toggle(Request $request, Video $video): JsonResponse
    {
        try {
            $result = $request->user()
                ->likedVideos()
                ->toggle($video->id);

            return response()->json([
                'liked' => count($result['attached']) > 0,
                'likes_count' => $video->likedBy()->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
