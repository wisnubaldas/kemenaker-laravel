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
        Schema::table('th_usulan_tender', function (Blueprint $table) {
            $table->integer('tipe_tender')->default(0)->comment("0:Flow Lama,1:Tender Seleksi,2:Pengadaan Pengecualian");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('th_usulan_tender', function (Blueprint $table) {
            $table->dropColumn('tipe_tender');
        });
    }
};
