<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pastikan content boleh NULL (form baru tidak mengisinya)
        Schema::table('articles', function (Blueprint $table) {
            $table->longText('content')->nullable()->change();
        });

        // Pindahkan isi lama menjadi 1 blok paragraf
        DB::table('articles')
            ->whereNotNull('content')
            ->where('content', '!=', '')
            ->whereNull('content_blocks')
            ->orderBy('id')
            ->each(function ($article) {
                DB::table('articles')
                    ->where('id', $article->id)
                    ->update([
                        'content_blocks' => json_encode([
                            [
                                'type' => 'paragraph',
                                'data' => ['text' => $article->content],
                            ],
                        ]),
                    ]);
            });
    }

    public function down(): void
    {
        // Tidak ada yang perlu dibalik; data content asli tidak dihapus.
    }
};