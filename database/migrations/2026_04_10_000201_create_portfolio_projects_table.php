<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('portfolio_projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('eyebrow')->nullable();
            $table->string('headline')->nullable();
            $table->text('summary');
            $table->text('result')->nullable();
            $table->string('metric')->nullable();
            $table->string('icon')->default('apps-24');
            $table->string('year')->nullable();
            $table->string('client')->nullable();
            $table->text('challenge')->nullable();
            $table->text('approach')->nullable();
            $table->json('impact_points')->nullable();
            $table->json('deliverables')->nullable();
            $table->json('stack')->nullable();
            $table->longText('full_description')->nullable();
            $table->string('category')->nullable();
            $table->string('project_status')->default('completed');
            $table->string('publication_status')->default('published');
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('thumbnail_path')->nullable();
            $table->json('gallery_paths')->nullable();
            $table->string('live_url')->nullable();
            $table->string('github_url')->nullable();
            $table->date('completed_at')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 512)->nullable();
            $table->string('og_image_path')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('scheduled_publish_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['publication_status', 'published_at']);
            $table->index(['sort_order', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_projects');
    }
};
