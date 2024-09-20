<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Models\Listing;
use App\Models\ListingType;
use Illuminate\Http\Request;

class ListingTypeController extends Controller
{
    private $type, $listing;

    public function __construct()
    {
        $this->type = new ListingType();
        $this->listing = new Listing();
    }


    public function get_type()
    {
        try {
            $types = $this->type->getApiAllType();
            if ($types->isNotEmpty())
                return Response::suc(array('types' => $types, 'url' => asset('storage/')));
            return Response::err('No Data');
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function get_listing_by_type($typeID, $lat, $long)
    {
        try {
            if (!empty($lat) && !empty($long)) {
                $listing = $this->listing->getApiListingByType($typeID, $lat, $long);
                if ($listing->isNotEmpty())
                    return Response::suc(array('listing' => $listing, 'url' => asset('storage/')));
                return Response::err('No Data');
            }
            return Response::err('Required field empty');
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }
}
