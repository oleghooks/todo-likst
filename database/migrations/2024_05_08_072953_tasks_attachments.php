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
        Schema::create('tasks_attachments', function (Blueprint $table) {
            $table->id();
            $table->integer('task_id');
            $table->string('url');
            $table->string('url150');
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
        Schema::dropIfExists('tasks_attachments');
    }
};
