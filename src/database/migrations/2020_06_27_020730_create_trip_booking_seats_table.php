<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CreateTripBookingSeatsTable migration Class to setup schema of TripBookingSeats table
 */
class CreateTripBookingSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_booking_seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->nullable(false)->references('id')->on('trips');
            $table->string('seat_number', 100)->nullable(false);
            $table->string('booking_user_name')->nullable(false);
            $table->string('booking_user_email')->nullable(false);
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_booking_seats');
    }
}
