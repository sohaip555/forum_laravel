<?php

namespace Database\Seeders;

use App\Models\comment;
use App\Models\like;
use App\Models\post;
use App\Models\Topic;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TopicSeeder::class);
        $topics = Topic::all();
        $users = User::factory(10)->create();

        $posts = Post::factory(200)
            ->withFixture()
            ->has(Comment::factory(3)->recycle($users))
            ->recycle([$users, $topics])
            ->create();

        $sohaip = User::factory()
            ->has(Post::factory(45)->recycle($topics)->withFixture())
            ->has(like::factory(125)->forEachSequence(
                ...$posts->random(150)->map(fn (post $post) => ['likeable_id' => $post])
            ))
            ->create([
                'name' => 'sohaip',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);

//         Manually associate comments with Luke's posts
        $sohaip->posts->each(function ($post) use ($users) {
            Comment::factory(10)->recycle($users)->create([
                'post_id' => $post->id,
            ]);
        });
    }
}

