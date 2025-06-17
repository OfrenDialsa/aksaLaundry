<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['satuan', 'kiloan', 'ongkir']);
            $table->enum('category', ['cuci', 'setrika', 'cuci_setrika'])->nullable(); // untuk kiloan cuci_setrika
            $table->string('item')->nullable(); // null untuk kiloan
            $table->integer('price');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
