<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Change user_id columns to string for UUID
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->string('user_id', 36)->change();
        });

        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            $table->string('user_id', 36)->change();
        });
    }

    public function down(): void
    {
        // Revert back to integer if needed
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->bigInteger('user_id')->change();
        });

        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            $table->bigInteger('user_id')->change();
        });
    }
};
