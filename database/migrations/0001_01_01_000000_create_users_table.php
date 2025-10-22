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
    Schema::create('users', function (Blueprint $table) {
        $table->uuid('id')->primary();                           // Primary key (auto-increment)
        $table->string('name');                 // User's name
        $table->string('email')->unique();      // Email (must be unique)
        $table->string('password');             // Hashed password
        $table->string('phone')->nullable();
        $table->unsignedBigInteger('role_id')->nullable();    // Optional phone number
        $table->timestamps();                   // created_at & updated_at
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
