<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/xxxx_create_consultations_table.php
public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->string('topic');              // topik konsultasi (pengganti nama kategori)
            $table->string('officer_name');       // nama petugas
            $table->string('phone');              // nomor WhatsApp
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Pindahkan data lama dari categories
        DB::table('categories')
            ->whereNotNull('consultation_phone')
            ->whereNotNull('consultation_name')
            ->orderBy('id')
            ->get()
            ->each(function ($c) {
                DB::table('consultations')->insert([
                    'topic'        => $c->name,
                    'officer_name' => $c->consultation_name,
                    'phone'        => $c->consultation_phone,
                    'is_active'    => true,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            });
    }
};
