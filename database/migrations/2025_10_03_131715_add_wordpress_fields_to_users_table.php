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
        Schema::table('users', function (Blueprint $table) {
        $table->string('wp_url')->nullable();
        $table->string('wp_username')->nullable();
        $table->string('wp_app_password')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['wp_url', 'wp_username', 'wp_app_password']);
    });

    }
};