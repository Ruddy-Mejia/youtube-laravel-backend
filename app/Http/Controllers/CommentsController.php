<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Video;
use App\Http\Requests\StoreCommentsRequest;
use App\Http\Requests\UpdateCommentsRequest;
use App\Http\Resources\CommentsResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class CommentsController extends Controller
{
    public function index(Video $video): AnonymousResourceCollection
    {
        $comments = $video->comments()
            ->with(['user', 'replies.user'])
            ->latest()
            ->paginate(20);

        return CommentsResource::collection($comments);
    }
    public function store(StoreCommentsRequest $request): CommentsResource
    {
        $data = $request->validated();
        if ($data['comment_id']) {
            $parent = Comments::find($data['comment_id']);
            if ($parent->comment_id !== null) {
                abort(422, 'Cannot reply to a reply');
            }
        }

        $comment = Comments::create([
            'user_id' => $request->user()->id,
            'video_id' => $data['video_id'] ?? null,
            'comment_id' => $data['comment_id'] ?? null,
            'body' => $data['body'],
        ]);

        $comment->load('user');

        return new CommentsResource($comment);
    }

    public function update(UpdateCommentsRequest $request, Comments $comment)
    {
        try {
            Gate::authorize('update', $comment);
            $data = $request->validated();
            $comment->update([
                'body' => $data['body']
            ]);

            return (new CommentsResource($comment))
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Comments $comment)
    {
        Gate::authorize('delete', $comment);
        try {
            $comment->replies()->delete();
            $comment->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete comment. ' . $e->getMessage()], 500);
        }
    }
}
