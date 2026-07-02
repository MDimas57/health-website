<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_banners', function (Blueprint $table) {

            $table->id();

            $table->string('title');

            $table->text('subtitle')->nullable();

            $table->string('button_text')->nullable();

            $table->string('button_link')->nullable();

            $table->string('image');

            $table->boolean('is_active')->default(true);

            $table->integer('sort_order')->default(0);

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_banners');
    }
};
