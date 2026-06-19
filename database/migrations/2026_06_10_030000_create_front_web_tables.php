<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Sliders Table
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('image_path');
            $table->string('target_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order_index')->default(0);
            $table->integer('clicks')->default(0);
            $table->timestamps();
        });

        // 2. Site Settings Table (for About Us and any key-value configs)
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // 3. Courses Table
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('category');
            $table->string('duration');
            $table->decimal('tuition_fee', 8, 2);
            $table->string('status')->default('active'); // active, draft
            $table->text('description')->nullable();
            $table->text('outcomes')->nullable(); // stored as newline separated list or json
            $table->timestamps();
        });

        // 4. News Table
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->string('category');
            $table->string('author');
            $table->string('image_path')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->integer('views')->default(0);
            $table->string('status')->default('draft'); // published, draft
            $table->timestamps();
        });

        // 5. Galleries Table
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image_path');
            $table->string('category');
            $table->string('status')->default('visible'); // visible, hidden
            $table->timestamps();
        });

        // 6. Footer Pages Table
        Schema::create('footer_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->text('seo_description')->nullable();
            $table->string('status')->default('draft'); // active, draft
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('footer_pages');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('news');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('sliders');
    }
};
