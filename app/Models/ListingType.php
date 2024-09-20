<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingType extends Model
{
    use HasFactory;

    protected $table = "listing_types";
    protected $fillable = [
        'slug',
        'name',
        'status',
        'image'
    ];

    public function getAllType(){

        return ListingType::where('status', 1)->get();
    }

    public function getTypeByID($id){
        return ListingType::where('id', $id)->where('status', 1)->first();
    }


    /**
     * Api
     * */


    public function getApiAllType(){

        return ListingType::where('status', 1)->get();
    }
}
