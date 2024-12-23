<?php


use App\Models\User;
use \App\Models\post;
use \App\Models\comment;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

it('requires authentication', function () {


    post(route('posts.comments.store', post::factory()->create()))->assertRedirect(route('login'));

});


test('can store a comment', function () {

    $user = User::factory()->create();
    $post = post::factory()->create();

    actingAs($user)->post(route('posts.comments.store', $post), [
       'body' => 'test comment'
    ]);

    $this->assertDatabaseHas(comment::class, [
        'user_id' => $user->id,
        'post_id' => $post->id,
        'body' => 'test comment'
    ]);
});


test('redirects to Posts', function () {

    $post = post::factory()->create();

    actingAs(User::factory()->create())
        ->post(route('posts.comments.store', $post), [
        'body' => 'test comment'
    ])
    ->assertRedirect($post->showRoute());


});


test('requires a valid body', function ($value) {

    $post = post::factory()->create();

    actingAs(User::factory()
            ->create())
        ->post(route('posts.comments.store', $post), [
        'body' => $value
    ])
        ->assertInvalid('body');
})
->with([
    0,
    1.5,
    true,
    str_repeat('a', 2501)
]);





