<?php

use App\TripBookingSeat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * TripBookingSeatsTableSeeder Class seeder for trip_booking_seats table
 */
class TripBookingSeatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // first truncate DB
        DB::table('trip_booking_seats')->delete();

        // Simulate there 7 person booking full trip(Cairo-Asyut)
        for ($counterForFullTrip = 1; $counterForFullTrip < 8; $counterForFullTrip++) {
            TripBookingSeat::create([
                'trip_id' => 1,
                'seat_number' => $counterForFullTrip,
                'booking_user_name'=> "test{$counterForFullTrip}",
                'booking_user_email'=> "test{$counterForFullTrip}@gmail.com"
            ]);
        }

        // Simulate there 7 person booking internal trip(Cairo-AlFayyum)
        TripBookingSeat::create([
            'trip_id' => 3,
            'seat_number' => 8,
            'booking_user_name'=> "test8",
            'booking_user_email'=> "test8@gmail.com"
        ]);
    }
}
