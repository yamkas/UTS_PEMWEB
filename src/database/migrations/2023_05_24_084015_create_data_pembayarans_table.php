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
        Schema::create('data_pembayarans', function (Blueprint $table) {
            $table->bigIncrements('No');
            $table->string('Kode Pembayaran');
            $table->string('Jenis Pembayaran');
            $table->string('Metode Pembayaran');
            $table->string('Jumlah Bayar');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pembayarans');
    }
};
