<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('series_buku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('series_id')
                  ->constrained('series')
                  ->onDelete('cascade');
            $table->foreignId('buku_id')
                  ->constrained('buku')
                  ->onDelete('cascade');
            $table->unsignedSmallInteger('urutan_baca')->default(0);
            $table->unsignedSmallInteger('urutan_terbit')->default(0);
            $table->boolean('is_penutup')->default(false);
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['series_id', 'buku_id']); // 1 buku hanya 1x per series
            $table->index(['series_id', 'urutan_baca']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('series_buku');
    }
};
