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
        Schema::create('tm_jenis_tender_docs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tmjenistender_id')->constrained(
                table: 'tm_jenis_tender', indexName: 'id'
            );
            $table->string('nama_doc');
            $table->string('tipe_doc')->default('any');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void    
    {
        Schema::dropIfExists('tm_jenis_tender_docs');
    }
};
