<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        // Changed from 'school__details' to 'school_details' to match your model
        Schema::create('school_details', function (Blueprint $table) {
            $table->id();
            
            $table->string('school_name');
            $table->string('school_code')->unique(); // Good practice to make codes unique
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable(); // Using text for addresses
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();
            $table->string('status')->default('active'); // Defaults to active
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Changed from 'school__details' to 'school_details'
        Schema::dropIfExists('school_details');
    }
};