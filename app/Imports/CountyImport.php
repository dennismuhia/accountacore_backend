<?php

namespace App\Imports;

use App\Models\County;
use Maatwebsite\Excel\Concerns\ToModel;

class CountyImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        dd($row);
        return new County([
            'name' => $row['name']
        ]);
    }
}
