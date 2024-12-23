<?php

use \App\Models\comment;




it('generates the html', function () {
    $comment = comment::factory()->make(['body' => '## Herd body']);

    $comment->save();

//    \Pest\Laravel\actingAs($comment->user);

//    dd($post->user->name);
//    dd($post->html);
//    dd( $post->body);

    expect($comment->html)->toEqual(str($comment->body)->markdown());
});

