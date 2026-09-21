<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    // public function toggle(Request $request, Video $video): JsonResponse
    // {
    //     $like = $video->likes()
    //         ->where('user_id', $request->user()->id)
    //         ->first();

    //     if ($like) {
    //         $like->delete();
    //         $liked = false;
    //     } else {
    //         $video->likes()->create([
    //             'user_id' => $request->user()->id,
    //         ]);
    //         $liked = true;
    //     }
    //     return response()->json([
    //         'liked' => $liked,
    //         'likes_count' => $video->likes()->count(),
    //     ]);
    // }
    public function toggle(Request $request, Video $video): JsonResponse
    {
        $result = $request->user()
            ->likedVideos()
            ->toggle($video->id);

        return response()->json([
            'liked' => count($result['attached']) > 0,
            'likes_count' => $video->likedBy()->count(),
        ]);
    }
}
