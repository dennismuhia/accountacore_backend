<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CountyImport;
use Illuminate\Support\Facades\Log;
use App\Models\County;
use App\Models\Region;
use App\Models\Subcounty;
class RegionController extends Controller
{
    public function index()
    {
        $counties = County::with('regions')->paginate(10);
        return view('regions.counties.index', compact('counties'));
    }

    public function uploadCounties(Request $request)
    {
   
        try {
            $file = $request->file('upload');
            $path = $file->getRealPath();
            $data = array_map('str_getcsv', file($path));
             // Example: loop through data
        foreach ($data as $row) {
            County::create([
                'name' => $row[0]
            ]);
        }
            // Excel::import(new CountyImport, $request->file('upload'));
            return back()->with('success', 'Counties imported successfully!');
        } catch (\Exception $e) {
            Log::error('CSV Import Error: ' . $e->getMessage(), [
                'file' => $request->file('upload')->getClientOriginalName(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'There was an error importing the file. Please check the logs.');
        }

    }

    public function uploadConstituencies(Request $request){
        try {
            $file = $request->file('upload');
            $path = $file->getRealPath();
            $data = array_map('str_getcsv', file($path));
         
             // Example: loop through data
        foreach ($data as $row) {
            Region::create([
                'county_id' => $request->county_id,
                'name' => $row[0]
            ]);
        }
            // Excel::import(new CountyImport, $request->file('upload'));
            return back()->with('success', 'Constituencies imported successfully!');
        } catch (\Exception $e) {
            Log::error('CSV Import Error: ' . $e->getMessage(), [
                'file' => $request->file('upload')->getClientOriginalName(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'There was an error importing the file. Please check the logs.');
        }
    }

    public function viewConstituencies($id){
        $constituencies=Region::where('county_id',$id)->paginate(10); 
        return view('regions.constituencies.index',compact('constituencies'));
    }

    public function deleteConstituency($id){
        $constituency=Region::findOrFail($id);
        $constituency->delete();
        return back()->with('success', 'Counties deleted successfully!');
    }

    public function uploadSubcounties(Request $request){
        
        try {
            $file = $request->file('upload');
            $path = $file->getRealPath();
            $data = array_map('str_getcsv', file($path));
      
             // Example: loop through data
        foreach ($data as $row) {
            Subcounty::create([
                'region_id' => $request->county_id,
                'name' => $row[0]
            ]);
        }
            // Excel::import(new CountyImport, $request->file('upload'));
            return back()->with('success', 'Constituencies imported successfully!');
        } catch (\Exception $e) {
            Log::error('CSV Import Error: ' . $e->getMessage(), [
                'file' => $request->file('upload')->getClientOriginalName(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'There was an error importing the file. Please check the logs.');
        }
    }

    public function viewSubcounties($id){
        $subcounties=Subcounty::where('region_id',$id)->paginate(10); 
        return view('regions.subcounties.index',compact('subcounties'));
    }

    public function deleteSubcounties($id){
        $constituency=Subcounty::findOrFail($id);
        $constituency->delete();
        return back()->with('success', 'Subcounty deleted successfully!');
    }
}
