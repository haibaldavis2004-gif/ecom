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
        $table->uuid('id')->primary();
        $table->string('name');
        $table->text('description')->nullable();
        $table->decimal('price', 8, 2);
        $table->integer('stock');
        //$table->foreignId('subcategory_id')->constrained()->onDelete('cascade');
       // $table->foreignId('category_id')->constrained()->onDelete('cascade');
      //  $table->foreignUuid('category_id')->constrained()->cascadeOnDelete();
        $table->timestamps();


      $table->uuid('subcategory_id');
      $table->foreign('subcategory_id')
      ->references('id')
      ->on('subcategories')
      ->onDelete('cascade');
      
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
