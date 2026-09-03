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
            $table->string('isbn')->nullable()->after('kode_buku');
            $table->decimal('rating', 2, 1)->default(0)->after('deskripsi');
            $table->boolean('is_featured')->default(false)->after('rating');
            $table->timestamp('returned_at')->nullable()->after('is_featured');
            $table->integer('waitlist_count')->default(0)->after('returned_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn(['isbn', 'rating', 'is_featured', 'returned_at', 'waitlist_count']);
        });
    }
};
