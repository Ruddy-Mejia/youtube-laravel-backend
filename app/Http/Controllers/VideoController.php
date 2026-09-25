<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Http\Resources\VideoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Video::class);

        $videos = Video::withCount(['likedBy', 'comments'])
            ->with([
                'categories',
                'user',
                'comments.user',
                'comments.replies.user',
            ])
            ->latest()
            ->paginate(15);

        return VideoResource::collection($videos);
    }


    public function store(StoreVideoRequest $request): VideoResource
    {
        $data = $request->validated();

        $data['thumbnail_path'] = $request->file('thumbnail')
            ->store('thumbnails', 'public');

        $data['duration'] = $data['duration'] ?? '00:00:00';
        $data['user_id'] = $request->user()->id;

        unset($data['thumbnail']);

        $video = Video::create($data);

        return new VideoResource($video);
    }

    public function show(Request $request, Video $video): VideoResource
    {
        $user = $request->user('sanctum');
        if ($user) {
            $video->increment('views');
            $video->refresh();

            $user->watchedVideos()->syncWithoutDetaching([
                $video->id => ['viewed_at' => now()],
            ]);
        }

        $video->loadCount(['likedBy', 'comments'])
            ->load(['categories', 'user', 'comments.user', 'comments.replies.user']);

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
            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete video. ' . $e->getMessage()], 500);
        }
    }
}
