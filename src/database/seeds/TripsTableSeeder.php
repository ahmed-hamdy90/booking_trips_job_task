<?php

use App\Trip;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * TripsTableSeeder Class seeder for trips table
 */
class TripsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // first truncate DB
        DB::table('trips')->delete();

        Trip::create([
            'departure_city_id' => 1, // refer to Cairo
            'destination_city_id' => 5, // refer to Asyut
            'date' => date('Y-m-d'),
            'departure_time' => date('G:i:s'),
            'expected_trip_hours' => 5, // 4 hours
            'expected_trip_minutes'=> 30, // 40 minute
            'total_seats_number' => 12,
            'available_seats_number' => 4
        ]);

        Trip::create([
            'departure_city_id' => 1, // refer to Cairo
            'destination_city_id' => 5, // refer to Asyut
            'date' => (new DateTime())->modify('+1 day')->format('Y-m-d'),
            'departure_time' => date('G:i:s'),
            'expected_trip_hours' => 5, // 4 hours
            'expected_trip_minutes'=> 30, // 40 minute
            'total_seats_number' => 12,
            'available_seats_number' => 12
        ]);

        Trip::create([
            'departure_city_id' => 1, // refer to Cairo
            'destination_city_id' => 3, // refer to AlFayyum
            'date' => date('Y-m-d'),
            'departure_time' =>  date('G:i:s'),
            'expected_trip_hours' => 2, // 2 hours
            'total_seats_number' => 12,
            'available_seats_number' => 4,
            'parent_trip_id' => 1 // the first cairo-asyut trip
        ]);

        Trip::create([
            'departure_city_id' => 3, // refer to AlFayyum
            'destination_city_id' => 4, // refer to AlMinya
            'date' => date('Y-m-d'),
            'departure_time' => (new DateTime())->modify('+2 hours')->format('G:i:s'),
            'expected_trip_hours' => 1, // 1 hours
            'expected_trip_minutes'=> 30, // 40 minute
            'total_seats_number' => 12,
            'available_seats_number' => 5,
            'parent_trip_id' => 1 // the first cairo-asyut trip
        ]);

        Trip::create([
            'departure_city_id' => 4, // refer to AlMinya
            'destination_city_id' =>  5, // refer to Asyut
            'date' => date('Y-m-d'),
            'departure_time' => (new DateTime())->modify('+3 hours 30 minutes')->format('G:i:s'),
            'expected_trip_hours' => 1, // 1 hours
            'total_seats_number' => 12,
            'available_seats_number' => 5,
            'parent_trip_id' => 1 // the first cairo-asyut trip
        ]);

        Trip::create([
            'departure_city_id' => 1, // refer to Cairo
            'destination_city_id' => 2, // refer to Giza
            'date' => date('Y-m-d'),
            'departure_time' => (new DateTime())->modify('+5 hours')->format('G:i:s'),
            'expected_trip_hours' => 2, // 4 hours
            'total_seats_number' => 12,
            'available_seats_number' => 12
        ]);
    }
}
