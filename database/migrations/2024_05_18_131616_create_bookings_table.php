<?php

use App\Enums\Booking\BookingStatus;
use App\Enums\Booking\BookingType;
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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->enum('type', BookingType::asArray())->default(BookingType::OnWebSite);
            $table->timestamp('booking_checkin');
            $table->timestamp('booking_checkout');
            $table->enum('status', array_column(BookingStatus::asArray(), 'key'))->default(BookingStatus::Awaiting['key']);
            $table->integer('number_of_adults')->default(0);
            $table->integer('number_of_children')->default(0);
            $table->integer('deposit')->default(0);
            $table->string('note')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
