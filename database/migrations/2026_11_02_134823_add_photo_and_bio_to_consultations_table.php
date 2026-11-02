<?php

use App\Models\Consultation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('officer_name');
            $table->text('bio')->nullable()->after('photo');
        });

        $disk = Storage::disk('public');

        // Ambil foto dari thumbnail kategori (cocokkan topic = categories.name)
        DB::table('consultations')
            ->join('categories', 'categories.name', '=', 'consultations.topic')
            ->whereNotNull('categories.image')
            ->select('consultations.id', 'categories.image')
            ->get()
            ->each(function ($row) use ($disk) {
                if (! $disk->exists($row->image)) {
                    return;
                }

                // Salin file asli (thumbnail kategori tetap aman)
                $ext  = pathinfo($row->image, PATHINFO_EXTENSION);
                $path = 'consultations/' . uniqid('c_') . '.' . $ext;
                $disk->copy($row->image, $path);

                // Lewat Eloquent agar hook saving mengubahnya jadi .webp
                Consultation::find($row->id)?->update(['photo' => $path]);
            });
    }

    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn(['photo', 'bio']);
        });
    }
};