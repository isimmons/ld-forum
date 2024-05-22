<?php

use App\Models\{Comment, User};

use function Pest\Laravel\{actingAs, delete};

it('requires authentication', function () {
    delete(route('comments.destroy', Comment::factory()->create()))
        ->assertRedirect(route('login'));
});

it('should delete a comment', function () {
    $comment = Comment::factory()->create();

    actingAs($comment->user)->delete(route('comments.destroy', $comment));

    $this->assertModelMissing($comment);
});

it('should not delete a comment by another user', function () {
    $comment = Comment::factory()->create();
    $unRelatedUser = User::factory()->create();

    actingAs($unRelatedUser)->delete(route('comments.destroy', $comment))
        ->assertForbidden();

    $this->assertModelExists($comment);
});

it('should not delete a comment if it is more than 1 hour old', function () {
    $this->freezeTime();

    $comment = Comment::factory()->create();

    $this->travel(1)->hour();

    actingAs($comment->user)->delete(route('comments.destroy', $comment))
        ->assertForbidden();

    $this->assertModelExists($comment);
});

it('should redirect to the posts show page', function () {
    $comment = Comment::factory()->create();

    actingAs($comment->user)
        ->delete(route('comments.destroy', $comment))
        ->assertRedirect($comment->post->showRoute());
});

it(
    'should redirect to the posts show page with the page query parameter',
    function () {
        $comment = Comment::factory()->create();

        actingAs($comment->user)
            ->delete(
                route('comments.destroy', ['comment' => $comment, 'page' => 2])
            )
            ->assertRedirect($comment->post->showRoute(['page' => 2]));
    }
);
