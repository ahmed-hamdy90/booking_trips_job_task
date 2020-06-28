<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * City Class represent model class for City instance
 * @package App
 */
class City extends Model
{
    protected $fillable = ['name', 'code'];
}
