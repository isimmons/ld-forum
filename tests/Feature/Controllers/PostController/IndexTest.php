<?php

use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\get;

use App\Http\Resources\PostResource;
use App\Models\Post;

it('should return the correct component', function () {
    get(route('posts.index'))
        ->assertOk()
        ->assertComponent('Posts/Index');
});

it('should pass posts to the view', function () {
    $posts = Post::factory(3)->create();

    $posts->load('user');

    get(route('posts.index'))
        ->assertOk()
        ->assertHasPaginatedResource('posts', PostResource::collection($posts->reverse()));
});
