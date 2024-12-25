<?php


namespace Tests\Feature;

use App\Http\Resources\PostResource;
use App\Http\Resources\TopicResource;
use App\Models\post;
use App\Models\Topic;

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



it('can filter to a topic', function () {
    $topic = topic::factory()->create();
    $posts = post::factory()->count(2)->for($topic)->create();
    $otherPosts = post::factory()->count(3)->create();

    $posts->load(['user', 'topic']);


    get(route('posts.index', ['topic' => $topic]))
        ->assertHasPaginatedResource('posts', PostResource::collection($posts->reverse()));

});



it('passes the selected topic to the view', function () {
    $topic = Topic::factory()->create();

    get(route('posts.index', ['topic' => $topic]))
        ->assertHasResource('selectedTopic', TopicResource::make($topic));
});







