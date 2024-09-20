<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Models\Branch;
use Illuminate\Http\Request;

class BrachController extends Controller
{
    private $branch;

    public function __construct()
    {
        $this->branch = new Branch();
    }


    public function get_branch($lat, $long)
    {
        try {
            if (!empty($lat) && !empty($long)) {
                $branches = $this->branch->getApiBranchByLatitudeAndLongitude($lat, $long);
                if ($branches->isNotEmpty())
                    return Response::suc(array('branches' => $branches));
                return Response::err('No data found');
            }
            return Response::err('Required field empty');
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }
}
