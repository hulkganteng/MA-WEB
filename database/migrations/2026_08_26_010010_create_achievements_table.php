<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('participant')->nullable();
            $table->string('category', 50)->index();
            $table->enum('level', ['madrasah', 'kecamatan', 'kabupaten', 'provinsi', 'nasional', 'internasional'])->default('kabupaten')->index();
            $table->string('organizer')->nullable();
            $table->string('rank')->nullable();
            $table->date('achieved_date')->nullable()->index();
            $table->unsignedInteger('year')->nullable()->index();
            $table->text('description')->nullable();
            $table->string('cover')->nullable();
            $table->enum('status', ['draft', 'published'])->default('published')->index();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
