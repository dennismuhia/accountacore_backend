<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Financial extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_id',
        'name',
        'amount',
        'description',
    ];

    /**
     * Get the news item that this financial belongs to.
     */
    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
