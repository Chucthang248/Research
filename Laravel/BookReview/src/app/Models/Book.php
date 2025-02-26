<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
    use HasFactory;

    public function reviews()
    {
        return $this->hasMany(Review::class, 'book_id');
    }

    public function scopeTitle(Builder $query, string $title)
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }

    public function scopeWithReviewsCount(Builder $query, $from = null, $to = null)
    {
        return $query->withCount(['reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)]);
    }

    public function scopeWithAvgRating(Builder $query, $from = null, $to = null)
    {
        return $query->withAvg(['reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)], 'rating');
    }

    public function scopePopular(Builder $query, $from = null, $to = null)
    {
        return $query->withReviewsCount()->orderBy('reviews_count', 'desc');
    }

    public function scopeHighestRated(Builder $query, $from = null, $to = null)
    {
        return $query->withAvgRating()->orderBy('reviews_avg_rating', 'desc');
    }

    public function scopeMinReviews(Builder $query, int $minReviews) {
        return $query->having('reviews_count', '>=', $minReviews);
    }

    public function dateRangeFilter(Builder $query, $from = null, $to = null)
    {
        if ($from && !$to) {
            $query->where('created_at', '>=', $from);
        } elseif (!$from && $to) {
            $query->where('created_at', '<=', $to);
        } elseif ($from && $to) {
            $query->whereBetWeen('created_at', [$from, $to]);
        } 
    }

    public function scopePopularLastMonth(Builder $query) {
        return $query->popular(now()->subMonth(), now())
        ->highestRated(now()->subMonth(), now())
        ->minReviews(2);
    }

    public function scopePopularLast6Months(Builder $query) {
        return $query->popular(now()->subMonth(6), now())
        ->highestRated(now()->subMonth(6), now())
        ->minReviews(5);
    }

    public function scopeHighestRatedLastMonth(Builder $query) {
        return $query->highestRated(now()->subMonth(), now())
        ->popular(now()->subMonth(), now())
        ->minReviews(2);
    }

    public function scopeHighestRatedLast6Months(Builder $query) {
        return $query->highestRated(now()->subMonth(6), now())
        ->popular(now()->subMonth(6), now())
        ->minReviews(5);
    }

    
    protected static function booted() {
        static::updated(fn(Book $book) => cache()->forget('book:' . $book->book_id));
        static::deleted(fn(Book $book) => cache()->forget('book:' . $book->book_id));
    }
}
