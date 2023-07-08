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
        

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('location', 250);
            $table->longText('description')->nullable();
            $table->double('price');
            $table->integer('capacity');
            $table->unsignedBigInteger('user_id')->default('1');
            $table->boolean('approve')->nullable()->default(false);
            $table->timestamps();   
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::dropIfExists('rooms');
    }
};
