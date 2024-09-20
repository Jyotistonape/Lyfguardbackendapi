<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Models\EmergencyType;
use Illuminate\Http\Request;

class EmergencyTypeController extends Controller
{
    private $type;

    public function __construct()
    {
        $this->type = new EmergencyType();
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
}
