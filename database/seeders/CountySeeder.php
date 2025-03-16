<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\County;
use App\Models\Region;
use App\Models\Subcounty;

class CountySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $county = County::create(['name' => 'Nairobi']);
        $region = Region::create(['name' => 'Central', 'county_id' => $county->id]);
        Subcounty::create(['name' => 'Westlands', 'region_id' => $region->id]);
    }
}
