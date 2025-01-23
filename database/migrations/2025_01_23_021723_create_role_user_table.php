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
        Schema::create('role_user', function (Blueprint $table) {
            
            $table->unsignedBigInteger('id_role');
            $table->unsignedBigInteger('id_user');
            $table->string('status')->default('active');
            $table->timestamps();

            // Llaves foráneas

            $table->foreign('id_role')->references('id')->on('roles');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
    }
};
