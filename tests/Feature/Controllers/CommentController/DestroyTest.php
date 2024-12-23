<?php


use App\Models\User;
use \App\Models\post;
use \App\Models\comment;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;
use function Pest\Laravel\delete;


it('requires authentication', function () {

        delete(route('comments.destroy', comment::factory()->create()))
        ->assertRedirect(route('login'));
});



it('can destroy comment', function () {

    $comment = comment::factory()->create();

    actingAs($comment->user); // ensure that this is a valid user object
    delete(route('comments.destroy', $comment));
    $this->assertModelMissing($comment);

});




it('redirect to post show page', function () {

    $comment = comment::factory()->create();

    actingAs($comment->user);
    delete(route('comments.destroy', $comment))
    ->assertRedirect($comment->post->showRoute());

});




it('prevents deleting a comment you didnt create', function () {

    $comment = comment::factory()->create();

    actingAs(User::factory()->create());
    delete(route('comments.destroy', $comment))
        ->assertForbidden();

});




it('prevents deleting a comment posted over an hour ago', function () {

     $this->freezeTime();

    $comment = comment::factory()->create();

    $this->travel(1)->hour();
    actingAs(User::factory()->create());
    delete(route('comments.destroy', $comment))
        ->assertForbidden();



});



it('redirect to post show page with page number', function () {

    $comment = comment::factory()->create();

//    dd($comment->post->showRoute([ 'page' => 2]));
    actingAs($comment->user)
        ->delete(route('comments.destroy', ['comment' => $comment, 'page' => 2]))
//        ->dd($comment->post->showRoute([ 'page' => 2]))
        ->assertRedirect($comment->post->showRoute([ 'page' => 2]));



});














