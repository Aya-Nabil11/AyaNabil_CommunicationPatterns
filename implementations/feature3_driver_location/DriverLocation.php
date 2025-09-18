<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverLocation extends Model
{
    protected $fillable = ['order_id', 'driver_id', 'latitude', 'longitude'];
}