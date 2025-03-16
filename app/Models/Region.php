<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'county_id'];

    public function county()
    {
        return $this->belongsTo(County::class);
    }

    public function subcounties()
    {
        return $this->hasMany(Subcounty::class);
    }
}
