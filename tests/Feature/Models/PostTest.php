<?php

use App\Models\Post;
use Illuminate\Support\Str;

it('should use Title Case for titles', function () {
    $post = Post::factory()->create([ 'title' => 'Hello, how are you?' ]);

    expect($post->title)->toBe('Hello, How Are You?');
});

it('should generate a route to the show page', function () {
    $post = Post::factory()->create();

    expect($post->showRoute())->toBe(route('posts.show', [$post, Str::slug($post->title)]));
});

it('should generate a route to the show page with additional parameters', function () {
    $post = Post::factory()->create();

    expect($post->showRoute(['page' => 2]))
        ->toBe(route('posts.show', [$post, Str::slug($post->title), 'page' => 2]));
});
