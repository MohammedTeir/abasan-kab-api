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
            $table->string('pin')->primary();
            $table->string('name');
            $table->string('phone');
            $table->string('password')->nullable();
            $table->string('address')->nullable();
            $table->enum('status', ['active', 'in-active']);
            $table->string('activation_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('last_login_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
