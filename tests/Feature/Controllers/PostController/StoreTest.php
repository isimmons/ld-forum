<?php

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

use App\Models\User;
use App\Models\Post;

beforeEach(function () {
    $this->validPost = [
        'title' => 'Hello World',
        'body' => 'This is my first post.'
    ];
});

it('requires authentication', function() {
    post(route('posts.store'))
        ->assertRedirect(route('login'));
});

it('should store a post', function() {
    $user = User::factory()->create();

    actingAs($user)->post(route('posts.store'), $this->validPost );

    $this->assertDatabaseHas(Post::class, [
        ...$this->validPost,
        'user_id' => $user->id
    ]);
});

it('should redirect to the post show page', function () {
    $user = User::factory()->create();

    actingAs($user)->post(route('posts.store'), $this->validPost)
        ->assertRedirect(route('posts.show', Post::latest('id')->first()));
});

/**
 * A valid title property for a post is required
 * and must be a string of min 3 and max 120 characters
 */
it('should require a valid title property', function ($value) {
    $user = User::factory()->create();

    actingAs($user)->post(route('posts.store'), [...$this->validPost, 'title' => $value])
        ->assertInvalid('title');
})->with([ null, 1, 2.5, true, false, str_repeat('a', 9), str_repeat('a', 121)  ]);
