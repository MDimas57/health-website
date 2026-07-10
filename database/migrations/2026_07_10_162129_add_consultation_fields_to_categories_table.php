<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {

            $table->string('consultation_name')
                ->nullable()
                ->after('description');

            $table->string('consultation_phone')
                ->nullable()
                ->after('consultation_name');

        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {

            $table->dropColumn([
                'consultation_name',
                'consultation_phone',
            ]);

        });
    }
};