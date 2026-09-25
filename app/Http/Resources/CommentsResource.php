<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'author' => new UserResource($this->whenLoaded('user')),
            'replies' => CommentsResource::collection($this->whenLoaded('replies')),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
