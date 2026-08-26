<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['berita', 'artikel'])->default('berita')->index();
            $table->string('title');
            $table->string('slug')->index();
            $table->foreignId('post_category_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->string('cover')->nullable();
            $table->string('og_image')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('body');
            $table->enum('status', ['draft', 'published', 'scheduled', 'archived'])->default('draft')->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->unsignedBigInteger('views')->default(0);
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
            $table->unique(['type', 'slug']);
        });

        Schema::create('post_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('tag_id');
            $table->unique(['post_id', 'tag_id']);

            $table->foreign('post_id', 'fk_post_tags_post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('tag_id', 'fk_post_tags_tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_tags');
        Schema::dropIfExists('posts');
    }
};
