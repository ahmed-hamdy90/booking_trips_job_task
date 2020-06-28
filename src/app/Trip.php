<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Trip Class represent model class for Trip instance
 * @package App
 */
class Trip extends Model
{
    protected $fillable = ['departure_city_id' ,'destination_city_id', 'date', 'departure_time'];
}
