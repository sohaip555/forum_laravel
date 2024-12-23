<?php

namespace App\Http\Controllers;

use App\Models\comment;
use App\Models\post;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Comment::class);
    }

    public function store(Request $request, post $post)
    {


        $data = $request->validate(['body' => ['required' ,'string' ,'max:2500'],]);

        comment::create([
            ...$data,
            'post_id' => $post->id,
            'user_id' => $request->user()->id,
        ]);

        return redirect($post->showRoute())
//        return to_route('posts.show', $post)
            ->banner('Comment added.');
    }

    public function destroy(Request $request, comment $comment)
    {
        $comment->delete();

        return redirect($comment->post->showRoute(['page' => $request->query('page')]))
            ->banner('Comment deleted.');

    }


    public function update(Request $request, comment $comment)
    {

        // Validate the request data
        $data = $request->validate(['body' => ['required', 'string' ,'max:2500'],]);

        $comment->update($data);

        return redirect($comment->post->showRoute(['page' => $request->query('page')]))
//        return to_route('posts.show', ['post' => $comment->post_id, 'page' => $request->query('page')])
            ->banner('Comment updated.');
    }


}














