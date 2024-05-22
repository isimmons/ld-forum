<?php

use App\Http\Resources\{CommentResource, PostResource};
use App\Models\{Comment, Post};

use function Pest\Laravel\get;


it('should return the correct component', function () {
    $post = Post::factory()->create();

    get($post->showRoute())
        ->assertOk()
        ->assertComponent('Posts/Show');
});

it('should pass a post to the view', function () {
    $post = Post::factory()->create();
    $post->load('user', 'topic');

    get($post->showRoute())
        ->assertOk()
        ->assertHasResource('post', PostResource::make($post));
});

it('should pass comments to the view', function () {
    $post = Post::factory()->create();
    $comments = Comment::factory(2)->for($post)->create();
    $comments->load('user');
    get($post->showRoute())
        ->assertOk()
        ->assertHasPaginatedResource(
            'comments',
            CommentResource::collection($comments->reverse())
        );
});

it(
    'should redirect to correct url if the slug is incorrect',
    function (string $incorrectSlug) {
        $post = Post::factory()->create(['title' => 'Hello world']);

        get(route('posts.show', [$post, $incorrectSlug, 'page' => 2]))
            ->assertRedirect($post->showRoute(['page' => 2]));
    }
)->with(['foo-bar', 'hello']);
