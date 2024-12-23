<?php


namespace Tests\Feature;

use App\Http\Resources\PostResource;
use App\Models\post;
use function Pest\Laravel\get;


it('should return a component', function () {
    get(route('posts.index'))
        ->assertComponent('Posts/Index');

});


it('passes post to the view', function () {

    $posts = post::factory()->count(3)->create();

    $posts->load(['user', 'topic']);


    get(route('posts.index'))
        ->assertHasPaginatedResource('posts', PostResource::collection($posts->reverse()));



});














