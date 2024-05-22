<?php

use App\Http\Resources\{PostResource, TopicResource};
use App\Models\{Post, Topic};

use function Pest\Laravel\get;

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
        ->assertHasPaginatedResource(
            'posts',
            PostResource::collection($posts->reverse())
        );
});

it('should pass topics to the view', function () {
    $topics = Topic::factory(3)->create();

    get(route('posts.index'))
        ->assertOk()
        ->assertHasResource('topics', TopicResource::collection($topics));
});

it('should filter posts by topic', function () {
    $general = Topic::factory()->create();

    $posts = Post::factory(2)->for($general)->create();
    $otherPosts = Post::factory(3)->create();

    $posts->load(['user', 'topic']);

    get(route('posts.index', ['topic' => $general]))
        ->assertHasPaginatedResource(
            'posts',
            PostResource::collection($posts->reverse())
        );
});

it('should pass the selected topic to the view', function () {
    $topic = Topic::factory()->create();

    get(route('posts.index', ['topic' => $topic]))
        ->assertHasResource('selectedTopic', TopicResource::make($topic));
});
