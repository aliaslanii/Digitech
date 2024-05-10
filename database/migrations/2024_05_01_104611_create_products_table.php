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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('dtp')->unique();
            $table->string('name');
            $table->text('description');
            $table->double('stock_quantity');
            $table->string('photo_path', 2048)->nullable();
            $table->foreignId('categorie_id')->constrained();
            $table->foreignId('berand_id')->constrained();
            $table->boolean('specific');
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
