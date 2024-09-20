<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Models\Amenity;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    private $amenity;

    public function __construct()
    {
        $this->amenity = new Amenity();
    }


    public function get_amenity()
    {
        try {
            $amenities = $this->amenity->getApiAllAmenities();
            if ($amenities->isNotEmpty())
                return Response::suc(array('amenities' => $amenities, 'url' => asset('storage/')));
            return Response::err('No Data');
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }
}
