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
    public function store(StoreCommentsRequest $request): JsonResponse
    {
        $data = Comments::create([
            'user_id' => $request->user()->id,
            'video_id' => $request->video_id,
            'body' => $request->body
        ]);

        return (new CommentsResource($data))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateCommentsRequest $request, Comments $comment)
    {
        Gate::authorize('update', $comment);
        $data = $request->validated();
        $comment->update([
            'body' => $data['body']
        ]);

        return (new CommentsResource($comment))
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Comments $comment)
    {
        Gate::authorize('delete', $comment);
        try {
            $comment->delete();
            return response()->json(['message' => 'Comment deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete comment. ' . $e->getMessage()], 500);
        }
    }
}
