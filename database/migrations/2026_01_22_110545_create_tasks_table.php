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

        Schema::create('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('task_title');
            $table->string('client_name');
            $table->text('description');
            $table->tinyInteger('status')->default(0); // 0: Pending, 1: Active, 2: Completed
            $table->timestamps(); //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('tasks');
    }
};
