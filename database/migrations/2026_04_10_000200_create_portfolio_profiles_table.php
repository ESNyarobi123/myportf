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
        Schema::create('portfolio_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name')->nullable();
            $table->string('nickname')->nullable();
            $table->string('role_title')->nullable();
            $table->string('hero_stack_pill')->nullable();
            $table->string('headline')->nullable();
            $table->text('summary')->nullable();
            $table->string('positioning')->nullable();
            $table->json('hero_focus')->nullable();
            $table->json('metrics')->nullable();
            $table->json('preview_cards')->nullable();
            $table->json('archive_projects')->nullable();
            $table->json('capabilities')->nullable();
            $table->json('workflow')->nullable();
            $table->json('proof_points')->nullable();
            $table->json('about_highlights')->nullable();
            $table->json('contact_channels')->nullable();
            $table->json('availability')->nullable();
            $table->json('stack')->nullable();
            $table->unsignedTinyInteger('years_experience')->nullable();
            $table->text('bio')->nullable();
            $table->string('profile_image_path')->nullable();
            $table->json('stats')->nullable();
            $table->json('skills')->nullable();
            $table->json('education')->nullable();
            $table->json('certifications')->nullable();
            $table->json('achievements')->nullable();
            $table->string('site_seo_title')->nullable();
            $table->string('site_seo_description', 512)->nullable();
            $table->string('default_og_image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_profiles');
    }
};
