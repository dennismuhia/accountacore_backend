<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'content', 'image', 'type', 'county_id', 'region_id', 'subcounty_id'];

    public function county()
    {
        return $this->belongsTo(County::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function subcounty()
    {
        return $this->belongsTo(Subcounty::class);
    }
    public function bookmarkedBy()
    {
        return $this->belongsToMany(User::class, 'news_user')->withTimestamps();
    }

    // In County.php
    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function views()
    {
        return $this->hasMany(NewsView::class);
    }

    public static function getMostBookmarked($limit = 10)
{
    return self::withCount('bookmarkedBy')
        ->having('bookmarked_by_count', '>', 1)
        ->orderByDesc('bookmarked_by_count')
        ->take($limit)
        ->get()
        ->map(function ($news) {
            return [
                'title' => $news->title,
                'bookmarks' => $news->bookmarked_by_count,
            ];
        });
}
}
