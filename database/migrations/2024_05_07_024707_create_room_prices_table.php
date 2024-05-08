<?php

use App\Enums\Room\PriceType;
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
        Schema::create('room_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_room_id');
            $table->enum('type_price', PriceType::getRoomPriceType());
            $table->integer('price');
            $table->timestamps();

            $table->foreign('type_room_id')->references('id')->on('room_types')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_prices');
    }
};
