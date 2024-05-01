<?php

use App\Http\Resources\TopicResource;
use App\Models\Topic;
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

    $posts->load(['user', 'topic']);

    get(route('posts.index'))
        ->assertOk()
        ->assertHasPaginatedResource('posts', PostResource::collection($posts->reverse()));
});

it('should filter posts by topic', function () {
    $general = Topic::factory()->create();

    $posts = Post::factory(2)->for($general)->create();
    $otherPosts = Post::factory(3)->create();

    $posts->load(['user', 'topic']);

    get(route('posts.index', ['topic' => $general]))
        ->assertHasPaginatedResource('posts', PostResource::collection($posts->reverse()));
});

it('should pass the selected topic to the view', function () {
    $topic = Topic::factory()->create();

    get(route('posts.index', ['topic' => $topic]))
        ->assertHasResource('selectedTopic', TopicResource::make($topic));
});
