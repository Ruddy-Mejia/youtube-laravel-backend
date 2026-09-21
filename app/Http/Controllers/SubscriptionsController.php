<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function toggle(Request $request, User $channel): JsonResponse
{
    if ($request->user()->id === $channel->id) {
        return response()->json(['message' => 'Cannot subscribe to yourself'], 422);
    }

    $result = $request->user()
        ->subscriptions()
        ->toggle($channel->id);

    return response()->json([
        'subscribed' => count($result['attached']) > 0,
        'subscribers_count' => $channel->subscribers()->count(),
    ]);
}
}
