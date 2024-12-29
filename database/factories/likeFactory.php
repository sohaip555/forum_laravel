<?php

namespace Database\Factories;

use App\Models\like;
use App\Models\post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class likeFactory extends Factory
{
    protected $model = like::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(['email' => 'test+' . Str::uuid() . '@example.com']),
            'likeable_type' => $this->likeableType(...),
            'likeable_id' => post::factory(),
        ];
    }

    public function likeableType(array $values)
    {
        $type = $values['likeable_id'];
        $modelName = $type instanceof factory
            ? $type->modelName()
            : $type::class;
        return (new $modelName)->getMorphClass();
    }
}
