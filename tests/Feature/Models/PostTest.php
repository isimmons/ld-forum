<?php

use App\Models\Post;

it('should use Title Case for titles', function () {
    $post = Post::factory()->create([ 'title' => 'Hello, how are you?' ]);

    expect($post->title)->toBe('Hello, How Are You?');
});
