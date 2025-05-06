<?php

namespace App\Http\Controllers;

use App\Models\County;
use App\Models\Region;
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

    public function writeNews()
    {
        return view('news.write');
    }
    public function dashboard(Request $request)
    {

        $news = News::all();
        $newsData = News::with('county', 'region', 'subcounty')->paginate(5); // 10 per page

        $newsPerCounty = News::selectRaw('county_id, COUNT(*) as total')
            ->groupBy('county_id')
            ->with('county')
            ->get();

        $newsPerRegion = News::selectRaw('region_id, COUNT(*) as total')
            ->groupBy('region_id')
            ->with('region')
            ->get();
        $totalBookmarks = News::withCount('bookmarkedBy')->get()->sum('bookmarked_by_count');

        $countyAnalytics = News::selectRaw('county_id, COUNT(*) as total')
            ->groupBy('county_id')
            ->with('county')
            ->get()
            ->map(function ($news) {
                return [
                    'county_name' => $news->county->name ?? 'Unknown',
                    'total_news' => $news->total,
                ];
            });

            $mostBookmarkedNews = News::withCount('bookmarkedBy')
            ->having('bookmarked_by_count', '>', 1) // filter where bookmarks > 1
            ->orderByDesc('bookmarked_by_count')
            ->take(10)
            ->get()
            ->map(function ($news) {
                return [
                    'title' => $news->title,
                    'bookmarks' => $news->bookmarked_by_count,
                ];
            });
// dd($mostBookmarkedNews);
        return view('dashboard', compact('news','newsData', 'newsPerCounty', 'newsPerRegion', 'totalBookmarks', 'countyAnalytics', 'mostBookmarkedNews'));
    }

    public function deleteNews($id){
        $news=News::findOrFail($id);
        $news->delete();
        return redirect()->back();
    }
}
