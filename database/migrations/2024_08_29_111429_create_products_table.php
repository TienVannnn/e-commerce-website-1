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
            $table -> string('code', 50);
            $table -> string('name', 100);
            $table -> string('slug', 100);
            $table -> bigInteger('price');
            $table -> string('short_des');
            $table -> text('content');
            $table -> string('image');
            $table -> integer('active') -> default(1);
            $table -> integer('quantity') -> default(1);
            $table -> integer('quantity_sold') -> default(0);
            $table -> unsignedBigInteger('category_id');
            $table -> foreign('category_id') -> references('id') -> on('categories') -> onDelete('restrict');
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
