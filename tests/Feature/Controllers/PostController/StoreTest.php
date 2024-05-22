<?php

use App\Models\{Post, Topic, User};

use function Pest\Laravel\{actingAs, post};

beforeEach(function () {
    $this->validPost = fn() => [
        'title' => 'Hello World',
        'body' => "to be, or not to be, that is the question In faith, I will. let me peruse this face. Making a famine where abundance lies, But that the dread of something after death, In the deep bosom of the ocean buried.",
        'topic_id' => Topic::factory()->create()->getKey(),
    ];
});

it('requires authentication', function () {
    post(route('posts.store'))
        ->assertRedirect(route('login'));
});

it('should store a post', function () {
    $user = User::factory()->create();
    $data = value($this->validPost);

    actingAs($user)->post(route('posts.store'), $data);

    $this->assertDatabaseHas(Post::class, [
        ...$data,
        'user_id' => $user->id
    ]);
});

it('should redirect to the post show page', function () {
    $user = User::factory()->create();

    actingAs($user)->post(route('posts.store'), value($this->validPost))
        ->assertRedirect(Post::latest('id')->first()->showRoute());
});


it(
    'should require valid data',
    function (array $badData, array|string $errors) {
        actingAs(User::factory()->create())->post(
            route('posts.store'),
            [...value($this->validPost), ...$badData]
        )
            ->assertInvalid($errors);
    }
)->with('invalid_post_data');
