<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Post::class);
    }

    public function index()
    {
//        dd(PostResource::collection(post::latest()->paginate()));

        return inertia('Posts/Index', [
            'posts' => PostResource::collection(post::with(['user', 'topic'])->latest('id')->paginate()),
        ]);
    }

    public function create()
    {
        return inertia('Posts/Create');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'min:10', 'max:120'],
            'body' => ['required', 'string', 'min:100', 'max:10000'],
        ]);


        $post = post::create([
            'title' => $data['title'],
            'body' => $data['body'],
            'slug' => Str::slug($data['title']),
            'user_id' => auth()->id(),

        ]);

        return redirect($post->showRoute());
    }
    public function show(Request $request, Post $post)
    {

//        dd(Str::contains($post->showRoute(), $request->path()));

        if (! Str::contains($post->showRoute(), $request->path())) {
            return redirect($post->showRoute($request->query()), status: 301);
        }

        $post->load(['user', 'topic']);

//        dd($post);
//        dd(PostResource::make($post)->html);

        return inertia('Posts/Show', [
            'post' => fn () => PostResource::make($post),
            'comments' => fn () => CommentResource::collection($post->comments()->with(['user', 'topic'])->latest()->latest('id')->paginate(10)),
        ]);
    }

}


















