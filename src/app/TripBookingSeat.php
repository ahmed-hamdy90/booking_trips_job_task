<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * TripBookingSeat Class represent model class for TripBookingSeat instance
 * @package App
 */
class TripBookingSeat extends Model
{
    protected $fillable = ['trip_id', 'seat_number', 'booking_user_name', 'booking_user_email'];
}
