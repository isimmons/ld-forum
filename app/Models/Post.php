<?php

namespace App\Models;

use App\Models\Concerns\ConvertsMarkdownToHtml;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;
    use ConvertsMarkdownToHtml;

    protected $guarded = [];

    /**
     * Relationship: A post belongs to a user.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: A post belongs to a topic.
     *
     * @return BelongsTo
     */
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Relationship: A post has many comments.
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Accessor: Convert the post title to proper title casing.
     *
     * @return Attribute
     */
    public function title(): Attribute
    {
        return Attribute::set(fn($value) => Str::title($value));
    }


    /**
     * Get the url for the posts.show route with or without query parameters
     *
     * @param array $parameters
     * @return string
     */
    public function showRoute(array $parameters = []): string
    {
        return route(
            'posts.show',
            [$this, Str::slug($this->title), ...$parameters]
        );
    }
}
