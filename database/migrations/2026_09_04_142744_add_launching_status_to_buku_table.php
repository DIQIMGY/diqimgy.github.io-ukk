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
        Schema::table('buku', function (Blueprint $table) {
            $table->enum('status_launching', ['tersedia', 'segera'])->default('tersedia')->after('is_featured');
            $table->date('tanggal_rilis')->nullable()->after('status_launching');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn(['status_launching', 'tanggal_rilis']);
        });
    }
};
