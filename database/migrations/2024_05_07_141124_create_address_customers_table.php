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
        Schema::create('address_customers', function (Blueprint $table) {
            $table->id();
            $table->string('Name');
            $table->string('Mobile');   
            $table->text('Address');
            $table->foreignId('states_id')->constrained();
            $table->foreignId('cities_id')->constrained();
            $table->string('ZipCode'); 
            $table->string('Plate'); 
            $table->string('Unit')->nullable();        
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_Delete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address_customers');
    }
};
