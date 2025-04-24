<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\User;
class NewsApiController extends Controller
{
    public function store(Request $request)
    {
        try {
            // ✅ Validate the request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|url',
                'type' => 'required|in:national,local',
                'county_id' => 'nullable|exists:counties,id',
                'region_id' => 'nullable|exists:regions,id',
                'subcounty_id' => 'nullable|exists:subcounties,id',
            ]);

            // ✅ Check if "local" news has at least one location
            if ($validated['type'] === 'local' && !$request->county_id && !$request->region_id && !$request->subcounty_id) {
                return response()->json(['message' => 'Local news must have a location!'], 400);
            }

            // ✅ Create the news article
            $news = News::create($validated);

            return response()->json([
                'message' => 'News created successfully!',
                'news' => $news,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create news', 'message' => $e->getMessage()], 500);
        }
    }

    public function getNewsByLocation($user_id)
    {
        // $user = auth()->user();
        $user = User::findOrfail($user_id);

        $news = News::where('type', 'national')->with('county', 'region', 'subcounty', 'bookmarkedBy')
            ->orWhere(function ($query) use ($user) {
                $query->where('type', 'local')
                    ->where(function ($q) use ($user) {
                        $q->where('county_id', $user->county_id)
                            ->orWhere('region_id', $user->region_id)
                            ->orWhere('subcounty_id', $user->subcounty_id);
                    });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($news);
    }


    public function addBookmark($userid, $newsId)
    {
        $user = User::where('id', $userid)->first();
        $news = News::findOrFail($newsId);

        if ($user->bookmarkedNews()->where('news_id', $newsId)->exists()) {
            $user->bookmarkedNews()->detach($newsId);
            return response()->json(['bookmarked' => false, 'message' => 'Removed from bookmarks']);
        } else {
            $user->bookmarkedNews()->attach($newsId);
            return response()->json(['bookmarked' => true, 'message' => 'Bookmarked successfully']);
        }
    }


    // public function getUserBookmarks($id)
    // {
    //     $user = User::where('id', $id)->first();
    //     return response()->json($user->bookmarkedNews()->with('county', 'region', 'subcounty')->get());
    // }

    public function getUserBookmarks($id)
    {
        // Find the user or return a 404 error
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }

        // Fetch bookmarks with related models
        $bookmarks = $user->bookmarkedNews()
            ->with(['county', 'region', 'subcounty'])
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Bookmarks retrieved successfully.',
            'data' => $bookmarks,
        ]);
    }
}
