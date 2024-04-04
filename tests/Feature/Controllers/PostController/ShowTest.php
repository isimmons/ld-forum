<?php

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;

use function Pest\Laravel\get;


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

it('should pass comments to the view', function () {
    $this->withoutExceptionHandling();
    $post = Post::factory()->create();
    $comments = Comment::factory(2)->for($post)->create();
    $comments->load('user');
    get(route('posts.show', $post))
        ->assertOk()
        ->assertHasPaginatedResource('comments', CommentResource::collection($comments->reverse()));
});
