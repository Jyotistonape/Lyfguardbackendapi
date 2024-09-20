<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Listing extends Model
{
    use HasFactory;

    protected $table = "listings";
    protected $fillable = [
        'slug',
        'name',
        'phone',
        'phone2',
        'phone3',
        'email',
        'address_line1',
        'address_line2',
        'country',
        'state',
        'city',
        'latitude',
        'longitude',
        'pincode',
        'website',
        'type_id',
        'image',
        'status'
    ];

    public function getAllListing($typeID = null)
    {
        $listings = DB::table('listings as l')
            ->join('listing_types as lt', 'lt.id', '=', 'l.type_id')
            ->select('l.*', 'lt.name as typeName')
            ->where('lt.status', 1)
            ->where('l.status', 1);
        if ($typeID) {
            return $listings->where('l.type_id', $typeID)->get();
        } else {
            return $listings->get();
        }
    }

    public function getListingByID($id)
    {
        return Listing::where('id', $id)->where('status', 1)->first();
    }


    /**
     * Api
     * */


    public function getApiListingByType($typeID, $latitude, $longitude)
    {
        return DB::table('listings as l')
            ->join('listing_types as lt', 'lt.id', '=', 'l.type_id')
            ->select('l.*', 'lt.name as typeName',
                DB::raw("
                            (3959 * ACOS(COS(RADIANS($latitude))
                                * COS(RADIANS(latitude))
                                * COS(RADIANS($longitude) - RADIANS(longitude))
                                + SIN(RADIANS($latitude))
                                * SIN(RADIANS(latitude)))) AS distance"))
            ->orderBy('distance', 'ASC')
            ->limit(10)
            ->where('lt.status', 1)
            ->where('l.status', 1)
            ->where('l.type_id', $typeID)
            ->get();

    }
}
