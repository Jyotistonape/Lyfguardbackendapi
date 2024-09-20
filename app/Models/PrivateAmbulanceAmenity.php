<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateAmbulanceAmenity extends Model
{
    use HasFactory;

    protected $table = "private_ambulance_amenities";
    protected $fillable = [
        'slug',
        'name',
        'image',
        'description',
        'price',
        'status'
    ];

    public function getAllAmenities(){

        return PrivateAmbulanceAmenity::where('status', 1)->get();
    }

    public function getAmenityByID($id){
        return PrivateAmbulanceAmenity::where('id', $id)->where('status', 1)->first();
    }

    public function getAmenitiesByIds($amenitiesIds){
        $amenitiesArray = explode(',', $amenitiesIds);
        return PrivateAmbulanceAmenity::whereIn('id', $amenitiesArray)->where('status', 1)->get();
    }

    /**
     * Api
     */


    public function getApiAllAmenities(){

        return PrivateAmbulanceAmenity::where('status', 1)->get();
    }


    public function getApiAmenitiesByIds($amenitiesIds){
        
        $amenitiesArray = explode(',', $amenitiesIds);
        $test = PrivateAmbulanceAmenity::whereIn('id', $amenitiesArray)->get();
        return PrivateAmbulanceAmenity::whereIn('id', $amenitiesArray)->where('status', 1)->get();
    }
}
