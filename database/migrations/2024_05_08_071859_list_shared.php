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
        Schema::create('lists_shared', function (Blueprint $table) {
            $table->id();
            $table->integer('list_id');
            $table->integer('to_user_id');
            $table->string('permission');
            $table->integer('created_at');
            $table->integer('updated_at');
            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lists_shared');
    }
};
