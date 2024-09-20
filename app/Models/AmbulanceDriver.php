<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbulanceDriver extends Model
{
    use HasFactory;

    protected $table = "ambulance_drivers";
    protected $fillable = [
        'ambulance_id',
        'driver_id',
        'logged_in_time',
        'logged_out_time',
        'status'
    ];
}
