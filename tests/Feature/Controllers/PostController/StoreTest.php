<?php

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

use App\Models\User;
use App\Models\Post;

beforeEach(function () {
    $this->validPost = [
        'title' => 'Hello World',
        'body' => "to be, or not to be, that is the question In faith, I will. let me peruse this face. Making a famine where abundance lies, But that the dread of something after death, In the deep bosom of the ocean buried."
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
