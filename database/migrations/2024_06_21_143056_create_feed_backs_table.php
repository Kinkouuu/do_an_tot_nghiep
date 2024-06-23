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
        Schema::create('feed_backs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('room_type_id');
            $table->float('rate_stars');
            $table->text('comment');
            $table->text('rely')->nullable();
            $table->timestamp('reply_at')->nullable();
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->cascadeOnDelete();
            $table->foreign('admin_id')->references('id')->on('admins')->cascadeOnDelete();
            $table->foreign('room_type_id')->references('id')->on('room_types')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed_backs');
    }
};
