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

    public function getCounties()
    {
        return response()->json(County::all());
    }

    public function getRegionsByCounty($county_id)
    {
        return response()->json(Region::where('county_id', $county_id)->with('county')->get());
    }

    public function getSubcountiesByRegion($region_id)
    {
        return response()->json(Subcounty::where('region_id', $region_id)->get());
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
