<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\County;

class CountyController extends Controller
{
    public function index()
    {
        $counties = County::with('regions.subcounties')->get();
        return response()->json($counties);
    }

    public function store(Request $request)
    {
        try {
            // ✅ Add input validation
            $validated = $request->validate([
                'county_name' => 'required|string|max:255|unique:counties,name',
                'region_name' => 'required|string|max:255|unique:regions,name',
                'subcounty_name' => 'required|string|max:255|unique:subcounties,name',
            ]);

            // ✅ Create County, Region, Subcounty
            $county = County::create(['name' => $validated['county_name']]);
            $region = $county->regions()->create(['name' => $validated['region_name']]);
            $region->subcounties()->create(['name' => $validated['subcounty_name']]);

            // ✅ Return success response
            return response()->json([
                'message' => 'County with region and subcounty created successfully!',
                'county' => $county->name,
                'region' => $region->name,
                'subcounty' => $region->subcounties()->first()->name,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // 🛑 Handle validation errors specifically
            return response()->json([
                'message' => 'Validation failed!',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            // 🛑 Catch any unexpected errors
            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function counties(){
        return view('region.county');
    }
}
