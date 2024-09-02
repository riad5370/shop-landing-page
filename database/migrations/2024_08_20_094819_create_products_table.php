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
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('category')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('discount')->nullable();
            $table->string('vdo_link')->nullable();
            $table->decimal('after_discount', 10, 2);
            $table->text('short_desp')->nullable();
            $table->longText('long_desp')->nullable();
            $table->string('preview')->nullable();
            $table->string('slug');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
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
