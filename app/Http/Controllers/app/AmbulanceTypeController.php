<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Models\AmbulanceType;
use Illuminate\Http\Request;

class AmbulanceTypeController extends Controller
{
    private $type;

    public function __construct()
    {
        $this->type = new AmbulanceType();
    }


    public function get_type()
    {
        try {
            $types = $this->type->getApiAllAmbulanceType();
            if ($types->isNotEmpty())
                return Response::suc(array('types' => $types, 'url' => asset('storage/')));
            return Response::err('No Data');
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }
}
