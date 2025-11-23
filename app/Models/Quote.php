<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Quote extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\QuoteFactory> */
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'movie_id',
        'description',
    ];

    protected $appends = [
        'image'
    ];

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class)->where('like', true);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getLastMediaUrl('quote/image'),
        );
    }
}
