<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;

    protected $table = "amenities";
    protected $fillable = [
        'slug',
        'name',
        'image',
        'description',
        'price',
        'status'
    ];

    public function getAllAmenities(){

        return Amenity::where('status', 1)->get();
    }

    public function getAmenityByID($id){
        return Amenity::where('id', $id)->where('status', 1)->first();
    }

    /**
     * Api
     */
    public function getApiAllAmenities(){

        return Amenity::where('status', 1)->get();
    }

    public function getApiAmenityByID($id){
        return Amenity::where('id', $id)->where('status', 1)->first();
    }
}
