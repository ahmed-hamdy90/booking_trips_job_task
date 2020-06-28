<?php

use App\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * CitiesTableSeeder Class seeder for cities table
 */
class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // first truncate DB
        DB::table('cities')->delete();

        City::create([
            'name' => 'Cairo',
            'code' => 'CA'
        ]);

        City::create([
            'name' => 'Giza',
            'code' => 'GI'
        ]);

        City::create([
            'name' => 'AlFayyum',
            'code' => 'FA'
        ]);

        City::create([
            'name' => 'AlMinya',
            'code' => 'MI'
        ]);

        City::create([
            'name' => 'Asyut',
            'code' => 'AS'
        ]);
    }
}
