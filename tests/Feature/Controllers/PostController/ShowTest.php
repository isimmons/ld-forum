<?php

use function Pest\Laravel\get;

use App\Http\Resources\PostResource;
use App\Models\Post;


it('should return the correct component', function () {
    $post = Post::factory()->create();

    get(route('posts.show', $post))
        ->assertOk()
        ->assertComponent('Posts/Show');
});

it('should pass a post to the view', function () {
    $post = Post::factory()->create();
    $post->load('user');

    get(route('posts.show', $post))
        ->assertOk()
        ->assertHasResource('post', PostResource::make($post));
});
