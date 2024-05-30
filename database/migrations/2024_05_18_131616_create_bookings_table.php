<?php

use App\Enums\Booking\BookingStatus;
use App\Enums\Booking\BookingType;
use App\Enums\Booking\PaymentType;
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
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('phone');
            $table->string('country');
            $table->string('gender');
            $table->string('citizen_id');
            $table->enum('for_relative', [0,1])->default(0);
            $table->enum('payment_type', [PaymentType::asArray()])->default(PaymentType::Cash);
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
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

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
