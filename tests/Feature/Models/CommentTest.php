<?php

use App\Models\Comment;

it('should generate html from new and updated comments', function () {
    $comment = Comment::factory()->make(['body' => '## Hello world']);

    $comment->save();

    expect($comment->html)->toEqual(str($comment->body)->markdown());
});
