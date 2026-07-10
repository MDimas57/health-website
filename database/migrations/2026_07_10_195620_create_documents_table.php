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
        Schema::create('documents', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELATION
            |--------------------------------------------------------------------------
            */

            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | CONTENT
            |--------------------------------------------------------------------------
            */

            $table->string('title');

            $table->string('slug')->unique();

            $table->longText('description')->nullable();

            /*
            |--------------------------------------------------------------------------
            | FILE
            |--------------------------------------------------------------------------
            */

            $table->string('document_file');

            // Thumbnail/Cover Dokumen (Opsional)
            $table->string('cover')->nullable();

            // Ukuran file (byte)
            $table->unsignedBigInteger('file_size')->nullable();

            /*
            |--------------------------------------------------------------------------
            | PUBLISH
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'draft',
                'published',
                'archived',
            ])->default('draft');

            $table->boolean('is_featured')
                ->default(false);

            $table->timestamp('published_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | STATISTIC
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('download_count')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | SYSTEM
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};