<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\County;
use App\Models\Region;
use App\Models\Subcounty;

class CountyApiController extends Controller
{
    public function index()
    {
        $counties = County::with('regions.subcounties')->get();
        return response()->json($counties);
    }

    // public function getCounties()
    // {
    //     return response()->json(County::all());
    // }
    public function getCounties(Request $request)
    {
        $query = County::query();

        // Check if a search term exists
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        // Get the results
        $counties = $query->get();

        return response()->json($counties);
    }

    public function getRegionsByCounty(Request $request, $county_id)
    {
        $query = Region::where('county_id', $county_id)->with('county');

        // Optional search term
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $regions = $query->get();

        return response()->json($regions);
    }

    public function getSubcountiesByRegion(Request $request, $region_id)
    {
        $query = Subcounty::where('region_id', $region_id);

        // Optional search by name
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $subcounties = $query->get();

        return response()->json($subcounties);
    }

    // app/Http/Controllers/LocationController.php
    public function saveUserLocation(Request $request)
    {
        $request->validate([
            'county_id' => 'required|exists:counties,id',
            'region_id' => 'required|exists:regions,id',
            'subcounty_id' => 'required|exists:subcounties,id',
        ]);

        $user = auth()->user();
        $user->update([
            'county_id' => $request->county_id,
            'region_id' => $request->region_id,
            'subcounty_id' => $request->subcounty_id,
        ]);

        return response()->json([
            'message' => 'Location saved successfully!',
            'user' => $user->load(['county', 'region', 'subcounty']),
        ]);
    }

}
