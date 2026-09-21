<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'channel_name' => $this->channel_name,
            'email' => $this->when(
                $request->user()?->id === $this->id,
                $this->email
            ),
            'videos_count' => $this->whenCounted('videos'),
            'subscribers_count' => $this->whenCounted('subscribers'),
            'subscriptions_count' => $this->whenCounted('subscriptions'),
            'liked_videos_count' => $this->whenCounted('likedVideos'),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
