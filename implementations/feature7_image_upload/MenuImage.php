<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuImage extends Model
{
    protected $fillable = ['restaurant_id', 'path', 'status'];

    // Possible statuses: 'uploaded', 'processing', 'completed', 'failed'
}
