<?php

namespace Database\Seeders;

use App\Models\comment;
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

        $luke = User::factory()
            ->has(Post::factory(45)->recycle($topics)->withFixture())
            ->create([
                'name' => 'sohaip',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);

        // Manually associate comments with Luke's posts
        $luke->posts->each(function ($post) use ($users) {
            Comment::factory(10)->recycle($users)->create([
                'post_id' => $post->id,
            ]);
        });
    }
}

