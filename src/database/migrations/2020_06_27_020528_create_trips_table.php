<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * CreateTripsTable migration Class to setup schema of Trips table
 */
class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departure_city_id')->nullable(false)->references('id')->on('cities');
            $table->foreignId('destination_city_id')->nullable(false)->references('id')->on('cities');
            $table->date('date')->nullable(false);
            $table->time('departure_time')->nullable(false);
            $table->integer('expected_trip_hours')->default(0);
            $table->integer('expected_trip_minutes')->default(0);
            $table->integer('expected_trip_seconds')->default(0);
            $table->integer('total_seats_number')->default(0);
            $table->integer('available_seats_number')->default(0);
            $table->foreignId('parent_trip_id')->nullable(true)->references('id')->on('trips')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('trips');
    }
}
