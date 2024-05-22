<?php

use App\Models\{Comment, User};

use function Pest\Laravel\{actingAs, put};


it('should authenticate the user', function () {
    put(route('comments.update', Comment::factory()->create()))
        ->assertRedirect(route('login'));
});

it('should update a comment', function () {
    $oldBody = 'This is the old body';
    $newBody = 'This is the new body';

    $comment = Comment::factory()->create(['body' => $oldBody]);
    $this->assertDatabaseHas(
        'comments',
        ['id' => $comment->id, 'body' => $oldBody]
    );

    actingAs($comment->user)
        ->put(route('comments.update', $comment), ['body' => $newBody]);

    $this->assertDatabaseHas(
        'comments',
        ['id' => $comment->id, 'body' => $newBody]
    );
});

it('should not update a comment from another user', function () {
    $comment = Comment::factory()->create();

    actingAs(User::factory()->create())
        ->put(
            route('comments.update', ['comment' => $comment, 'page' => 2]),
            ['body' => 'updated body']
        )
        ->assertForbidden();
});

it('should require a valid body property', function ($value) {
    $comment = Comment::factory()->create();

    actingAs($comment->user)
        ->put(route('comments.update', $comment), ['body' => $value])
        ->assertInvalid('body');
})->with([null, 1, 2.5, true, false, 'aa', str_repeat('a', 2501)]);

it('should redirect to the posts show page', function () {
    $comment = Comment::factory()->create();

    actingAs($comment->user)
        ->put(route('comments.update', $comment), ['body' => 'updated body'])
        ->assertRedirect($comment->post->showRoute());
});

it('should redirect to the correct page of comments', function () {
    $comment = Comment::factory()->create();

    actingAs($comment->user)
        ->put(
            route('comments.update', ['comment' => $comment, 'page' => 2]),
            ['body' => 'updated body']
        )
        ->assertRedirect($comment->post->showRoute(['page' => 2]));
});
