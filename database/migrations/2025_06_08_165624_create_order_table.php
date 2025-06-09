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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->string('name'); // Nama user dari Auth
            $table->enum('type', ['satuan', 'kiloan']); // Jenis laundry
            $table->integer('baju')->nullable();
            $table->integer('celana')->nullable();
            $table->integer('jaket')->nullable();
            $table->integer('gaun')->nullable();
            $table->integer('sprey_kasur')->nullable();
            $table->integer('quantity')->nullable(); // Jumlah barang, untuk satuan
            $table->decimal('weight', 8, 2)->nullable(); // Berat kg, untuk kiloan
            $table->enum('delivery_option', ['antar', 'jemput']); // Antar atau jemput
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'dibatalkan'])->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
