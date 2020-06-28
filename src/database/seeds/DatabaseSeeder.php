<?php

use Illuminate\Database\Seeder;

/**
 * DatabaseSeeder Class represent main Database seeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(CitiesTableSeeder::class);
         $this->call(TripsTableSeeder::class);
         $this->call(TripBookingSeatsTableSeeder::class);
    }
}
