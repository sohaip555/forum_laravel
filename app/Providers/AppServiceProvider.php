<?php

namespace App\Providers;

use App\Models\comment;
use App\Models\like;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        Model:: preventLazyLoading(true);
        JsonResource::withoutWrapping();

//        Relation::enforceMorphMap([
//            'post' => Post::class,
//            'comment' => Comment::class,
//            'like' => Like::class, // Ensure this line is included
//        ]);


        Relation::morphMap([
            'post' => Post::class,
            'comment' => Comment::class,
            'like' => Like::class, // Ensure this line is included
        ]);
    }
}
