<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\VideoResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class HistoryController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $videos = $request->user()
            ->watchedVideos()
            ->with('user')
            ->paginate(20);

        return VideoResource::collection($videos);
    }

    public function destroy(Request $request)
    {
        $request->user()->watchedVideos()->detach();

        return response()->noContent();
    }
}
