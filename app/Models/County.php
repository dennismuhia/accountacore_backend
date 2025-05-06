<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function regions()
    {
        return $this->hasMany(Region::class);
    }
    public function news()
    {
        return $this->hasMany(News::class);
    }
}
