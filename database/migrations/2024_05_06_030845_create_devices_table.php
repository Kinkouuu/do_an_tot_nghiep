<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_device_id');
            $table->string('name');
            $table->integer('rental_price')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('brand')->nullable();
            $table->text('description')->nullable();
            $table->enum('for_rent', [0,1])->default(0);
            $table->timestamps();
            $table->foreign('type_device_id')->references('id')->on('type_devices')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
};
