<?php

use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\get;


it('should return the correct component', function () {
    get(route('posts.index'))
        ->assertOk()
        ->assertInertia(fn(AssertableInertia $inertia) => $inertia
            ->component('Posts/Index', true)
        );
});

it('should pass posts to the view', function () {
    get(route('posts.index'))
        ->assertOk()
        ->assertInertia(fn(AssertableInertia $inertia) => $inertia
            ->has('posts')
        );
});
