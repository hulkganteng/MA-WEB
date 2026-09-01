<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('teachers', 'is_in_structure')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->boolean('is_in_structure')->default(false)->index();
                $table->foreignId('structure_parent_id')->nullable()->after('is_in_structure')->constrained('teachers')->nullOnDelete();
                $table->unsignedInteger('structure_order')->default(0)->after('structure_parent_id');
            });
        }

        if (! Schema::hasTable('organization_members')) {
            return;
        }

        $teacherIds = [];
        foreach (DB::table('organization_members')->orderBy('id')->get() as $member) {
            $teacher = DB::table('teachers')->where('name', $member->name)->first();
            if (! $teacher) {
                $baseSlug = Str::slug($member->name) ?: Str::random(8);
                $slug = $baseSlug;
                $suffix = 2;
                while (DB::table('teachers')->where('slug', $slug)->exists()) {
                    $slug = $baseSlug.'-'.$suffix++;
                }

                $teacherId = DB::table('teachers')->insertGetId([
                    'name' => $member->name,
                    'slug' => $slug,
                    'type' => 'guru',
                    'position' => $member->position,
                    'photo' => $member->photo,
                    'order' => $member->order,
                    'is_active' => true,
                    'is_public' => true,
                    'created_at' => $member->created_at,
                    'updated_at' => $member->updated_at,
                ]);
            } else {
                $teacherId = $teacher->id;
            }

            $teacherIds[$member->id] = $teacherId;
            DB::table('teachers')->where('id', $teacherId)->update([
                'is_in_structure' => (bool) $member->is_active,
                'structure_order' => $member->order,
            ]);
        }

        foreach (DB::table('organization_members')->whereNotNull('parent_id')->get() as $member) {
            DB::table('teachers')->where('id', $teacherIds[$member->id])->update([
                'structure_parent_id' => $teacherIds[$member->parent_id] ?? null,
            ]);
        }

        Schema::drop('organization_members');
    }

    public function down(): void
    {
        if (! Schema::hasTable('organization_members')) {
            Schema::create('organization_members', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('position');
                $table->string('photo')->nullable();
                $table->foreignId('parent_id')->nullable()->constrained('organization_members')->nullOnDelete();
                $table->unsignedInteger('order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        Schema::table('teachers', function (Blueprint $table) {
            $table->dropForeign(['structure_parent_id']);
            $table->dropColumn(['is_in_structure', 'structure_parent_id', 'structure_order']);
        });
    }
};
