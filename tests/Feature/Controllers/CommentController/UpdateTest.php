<?php


use App\Models\User;
use \App\Models\post;
use \App\Models\comment;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;
use function Pest\Laravel\put;
use function Pest\Laravel\delete;


it('requires authentication', function () {

    put(route('comments.update', comment::factory()->create()))
        ->assertRedirect(route('login'));

});



it('can update comment', function () {

    $comment = Comment::factory()->create(['body' => 'This is the old body']);
    $newBody = 'This is the new body';

    actingAs($comment->user)
        ->put(route('comments.update', $comment), ['body' => $newBody]);

//    dd(Comment::find($comment->id));
    $this->assertDatabaseHas(Comment::class, [
        'id' => $comment->id,
        'body' => $newBody,
    ]);
});


it('redirect to post show page', function () {

    $comment = Comment::factory()->create();

    actingAs($comment->user)
        ->put(route('comments.update', $comment), ['body' => 'this is the new body'])
        ->assertRedirect($comment->post->showRoute());
});




it('redirect to the correct page of comments', function () {
    $comment = Comment::factory()->create();

    actingAs($comment->user)
        ->put(route('comments.update', ['comment' => $comment, 'page' => 2]), [ 'body' => 'This is the new body'])
        ->assertRedirect($comment->post->showRoute(['page' => 2]));
});


it('cannot update a comment from another user', function () {

    $comment = Comment::factory()->create();

    actingAs(User::factory()->create())
        ->put(route('comments.update', $comment), [ 'body' => 'This is the new body'])
        ->assertForbidden();

});


it('requires a valid body', function ($body) {
    $comment = Comment::factory()->create();

    actingAs($comment->user)
        ->put(route('comments.update', $comment), ['body' => $body])
        ->assertInvalid('body');
})
    ->with([
        null,
        0,
        1.5,
        true,
        str_repeat('a', 2501)
    ]);














