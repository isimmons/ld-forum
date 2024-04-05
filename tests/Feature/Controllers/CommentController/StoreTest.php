<?php

use function Pest\Laravel\actingAs;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

it('should store a new comment', function () {
   $user = User::factory()->create();
   $post = Post::factory()->create();
   $comment = [
       'body' => 'This is a test comment',
       'post_id' => $post->id,
       'user_id' => $user->id,
   ];

   actingAs($user)->post(route('posts.comments.store', $post), [
       'body' => $comment['body'],
   ]);

   $this->assertDatabaseHas(Comment::class, $comment);
});

it('should redirect to the post show page', function () {
    $post = Post::factory()->create();

    actingAs(User::factory()->create())->post(route('posts.comments.store', $post), [
        'body' => 'This is a test',
    ])
        ->assertRedirect(route('posts.show', $post));
});

/**
 * A valid body property for a comment is required
 * and must be a string of min 3 and max 2500 characters
 */
it('should require a valid body property', function ($value) {
    $post = Post::factory()->create();

    actingAs(User::factory()->create())->post(route('posts.comments.store', $post), [
        'body' => $value,
    ])
        ->assertInvalid('body');
})->with([ null, 1, 2.5, true, false, 'aa', str_repeat('a', 2501)  ]);
