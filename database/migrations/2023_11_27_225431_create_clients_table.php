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
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('id')->primary('id');
            $table->integer('code');
            $table->string('name');
            $table->string('zip_code');
            $table->string('address');
            $table->string('number_address');
            $table->string('complement_address');
            $table->string('neighborhood');
            $table->uuid('state_id')->index();
            $table->foreign('state_id')->references('id')->on('states');
            $table->uuid('city_id')->index();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->date('birth');
            $table->string('phone');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
