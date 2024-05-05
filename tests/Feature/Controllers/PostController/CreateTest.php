<?php

use App\Http\Resources\TopicResource;
use App\Models\Topic;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;
use function Pest\Laravel\get;

use App\Models\User;

it('requires authentication', function() {
    get(route('posts.create'))
        ->assertRedirect(route('login'));
});

it('should return the correct component', function () {
    actingAs(User::factory()->create())
        ->get(route('posts.create'))
        ->assertComponent('Posts/Create');
});

it('should pass topics to the view', function () {
    $topics = Topic::factory()->count(2)->create();

    actingAs(User::factory()->create())
        ->get(route('posts.create'))
        ->assertHasResource('topics', TopicResource::collection($topics));
});
