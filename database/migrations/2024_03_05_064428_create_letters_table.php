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
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->string("type")->nullable();
            $table->string("jenis_berkas")->nullable();
            $table->string("no_berkas")->nullable();
            $table->string("nama_unit")->nullable();
            $table->string("no_unit")->nullable();
            $table->date("tanggal_masuk")->nullable();
            $table->date("tanggal_keluar")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
