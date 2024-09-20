<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateAmbulanceDriver extends Model
{
    use HasFactory;

    protected $table = "private_ambulance_drivers";
    protected $fillable = [
        'ambulance_id',
        'driver_id',
        'logged_in_time',
        'logged_out_time',
        'status',
        'admin_id'
    ];
}
