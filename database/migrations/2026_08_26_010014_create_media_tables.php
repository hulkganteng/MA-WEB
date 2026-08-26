<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('cover')->nullable();
            $table->string('category', 50)->default('foto')->index();
            $table->date('album_date')->nullable();
            $table->enum('status', ['draft', 'published'])->default('published')->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->constrained()->cascadeOnDelete();
            $table->string('image');
            $table->string('caption')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });

        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('disk', 50)->default('public');
            $table->string('path');
            $table->string('mime_type', 100)->nullable();
            $table->string('extension', 20)->nullable();
            $table->unsignedBigInteger('size')->default(0);
            $table->string('type', 20)->default('image')->index();
            $table->string('collection', 50)->default('default')->index();
            $table->string('alt')->nullable();
            $table->json('meta')->nullable();
            $table->nullableMorphs('mediable');
            $table->timestamps();
        });

        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('url');
            $table->string('provider', 30)->default('youtube');
            $table->string('thumbnail')->nullable();
            $table->string('category', 50)->nullable()->index();
            $table->text('description')->nullable();
            $table->date('video_date')->nullable();
            $table->enum('status', ['draft', 'published'])->default('published')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
        Schema::dropIfExists('media');
        Schema::dropIfExists('photos');
        Schema::dropIfExists('albums');
    }
};
