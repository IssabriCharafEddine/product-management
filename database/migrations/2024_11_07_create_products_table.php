<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); 
            $table->string('sku')->unique()->nullable();
            $table->string('status')->nullable(); 
            $table->string('image')->nullable(); 
            $table->decimal('price', 7, 2)->nullable();
            $table->string('currency', 20)->nullable(); 
            $table->softDeletes();
            $table->string('deletion_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
