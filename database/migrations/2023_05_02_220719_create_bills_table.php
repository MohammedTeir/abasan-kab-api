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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('user_pin');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('bill_categories');
            // $table->unsignedBigInteger('document_id');
            // $table->foreign('document_id')->references('id')->on('documents');
            $table->double('amount', 10, 2);
            $table->boolean('paid')->default(false);
            $table->timestamps();
            $table->foreign('user_pin')->references('pin')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
