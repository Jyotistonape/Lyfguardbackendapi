<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Models\FirstAid;
use App\Models\FirstAidCategory;
use Illuminate\Http\Request;

class FirstAidController extends Controller
{
    private $firstAid, $cat;

    public function __construct()
    {
        $this->cat = new FirstAidCategory();
        $this->firstAid = new FirstAid();
    }

    public function get_category()
    {
        try {
            $firstAidCategories = $this->cat->getApiAllCategory();
            if ($firstAidCategories)
                return Response::suc(array('firstAidCategories' => $firstAidCategories));
            return Response::err('No Data');
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function get_first_aid($catID)
    {
        try {
            $firstAid = $this->firstAid->getApiFirstAidByCatID($catID);
            if ($firstAid)
                return Response::suc(array('firstAid' => $firstAid));
            return Response::err('No Data');
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }
}
