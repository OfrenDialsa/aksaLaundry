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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->string('name'); // Nama user dari Auth
            $table->enum('type', ['satuan', 'kiloan']); // Jenis laundry
            $table->integer('baju')->nullable();
            $table->integer('celana')->nullable();
            $table->integer('jaket')->nullable();
            $table->integer('gaun')->nullable();
            $table->integer('sprey_kasur')->nullable();
            $table->decimal('weight', 8, 2)->nullable(); // Berat kg, untuk kiloan
            $table->enum('delivery_option', ['antar', 'jemput']); // Antar atau jemput
            $table->enum('service_type', ['cuci', 'setrika', 'cuci_setrika'])->default('cuci_setrika');
            $table->text('description')->nullable();
            $table->bigInteger('total')->default(0);
            $table->enum('status', ['menunggu', 'dijemput', 'diproses', 'selesai', 'dibatalkan'])->default('menunggu');
            $table->enum('status_pembayaran', ['unpaid', 'pending', 'paid'])->default('unpaid');
            $table->string('midtrans_order_id')->nullable()->unique();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
