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
        Schema::create('portfolio_services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('short_intro')->nullable();
            $table->longText('full_details')->nullable();
            $table->string('icon')->default('globe-24');
            $table->string('cover_image_path')->nullable();
            $table->string('pricing_note')->nullable();
            $table->string('cta_label')->nullable();
            $table->string('cta_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('publication_status')->default('published');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_services');
    }
};
