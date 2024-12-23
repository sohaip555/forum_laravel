<?php

use App\Models\Topic;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->default('default-slug')->nullable();
            $table->string('name');
            $table->text('description');
            $table->timestamps();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->foreignIdFor(Topic::class)->after('user_id')->constrained()->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor(Topic::class);
        });

        Schema::dropIfExists('topics');
    }
};
