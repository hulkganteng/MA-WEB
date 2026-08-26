<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedInteger('graduation_year')->nullable()->index();
            $table->string('university')->nullable();
            $table->string('major')->nullable();
            $table->string('occupation')->nullable();
            $table->string('company')->nullable();
            $table->string('photo')->nullable();
            $table->text('testimonial')->nullable();
            $table->enum('status', ['pending', 'verified', 'hidden'])->default('verified')->index();
            $table->boolean('is_public')->default(true);
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('alumni_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('graduation_year')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('university')->nullable();
            $table->string('major')->nullable();
            $table->string('occupation')->nullable();
            $table->string('company')->nullable();
            $table->string('photo')->nullable();
            $table->text('testimonial')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->index();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_submissions');
        Schema::dropIfExists('alumni');
    }
};
