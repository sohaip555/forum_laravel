<?php

use App\Models\post;

it('uses title case for titles', function () {

    $post = post::factory()->create([
        'title' => 'Herd title',
    ]);

    expect($post->title)->toBe('Herd Title');
});

it('can generate a route to the show page', function () {
    $post = Post::factory()->create();

    expect($post->showRoute())->toBe(route('posts.show', [$post, Str::slug($post->title)]));
});


it('can generate additional query parameters on the show route', function () {
    $post = Post::factory()->create();

    expect($post->showRoute(['page' => 2]))
        ->toBe(route('posts.show', [$post, Str::slug($post->title), 'page' => 2]));
});


it('generates the html', function () {
    $post = Post::factory()->make(['body' => '## Herd body']);

    $post->save();

    \Pest\Laravel\actingAs($post->user);

//    dd($post->user->name);
//    dd($post->html);
//    dd( $post->body);

    expect($post->html)->toEqual(str($post->body)->markdown());
});

