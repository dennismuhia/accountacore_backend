<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
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

    public function writeNews(){
        return view('news.write');
    }
}
