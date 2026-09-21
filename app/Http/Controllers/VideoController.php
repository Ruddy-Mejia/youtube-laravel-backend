<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Http\Resources\VideoResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\JsonResponse;

class VideoController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Video::class);

        $videos = Video::withCount(['likedBy', 'comments'])
            ->with(['categories'])
            ->latest()
            ->paginate(15);

        return VideoResource::collection($videos);
    }


    public function store(StoreVideoRequest $request)
    {
        $data = $request->validated();
        $data['duration'] = $data['duration'] ?? "00:00:00";
        $data['user_id'] = $request->user()->id;
        $video = Video::create($data);

        return new VideoResource($video);
    }

    public function show(Video $video)
    {
        Gate::authorize('view', $video);

        $video->loadCount(['likedBy', 'comments'])
            ->load(['categories', 'user', 'comments.user']);

        return new VideoResource($video);
    }


    public function update(UpdateVideoRequest $request, Video $video)
    {
        Gate::authorize('update', $video);

        $data = $request->validated();
        $video->update($data);

        return new VideoResource($video);
    }

    public function destroy(Video $video)
    {
        Gate::authorize('delete', $video);
        
        try {
            $video->delete();
            return response()->json(['message' => 'Video deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete video. ' . $e->getMessage()], 500);
        }
    }
}
