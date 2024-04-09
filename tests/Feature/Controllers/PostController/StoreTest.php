<?php

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

use App\Models\User;
use App\Models\Post;

beforeEach(function () {
    $this->validPost = [
        'title' => 'Hello World',
        'body' => str_repeat('a', 100)
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


it('should require valid data', function (array $badData, array|string $errors ) {
    actingAs(User::factory()->create())->post(route('posts.store'), [ ...$this->validPost, ...$badData ] )
        ->assertInvalid($errors);
})->with('invalid_post_data');
