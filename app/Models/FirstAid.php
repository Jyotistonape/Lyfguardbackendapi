<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FirstAid extends Model
{
    use HasFactory;

    protected $table = "first_aids";
    protected $fillable = [
        'cat_id',
        'slug',
        'title',
        'description',
        'video_link',
        'status'
    ];

    public function getAllFirstAid($catID = null)
    {
        $firstAid = DB::table('first_aids as fa')
            ->join('first_aid_categories as c', 'c.id', '=', 'fa.cat_id')
            ->select('fa.*', 'c.name as catName')
            ->where('c.status', 1)
            ->where('fa.status', 1);
        if ($catID) {
            return $firstAid->where('fa.cat_id', $catID)->get();
        } else {
            return $firstAid->get();
        }
    }

    public function getFirstAidByID($ID)
    {
        return FirstAid::where('id', $ID)->where('status', 1)->first();
    }


    /**
     * Api
     * */


    public function getApiFirstAidByCatID($catID)
    {
        return DB::table('first_aids as fa')
            ->join('first_aid_categories as c', 'c.id', '=', 'fa.cat_id')
            ->select('fa.*', 'c.name as catName')
            ->where('c.status', 1)
            ->where('fa.status', 1)
            ->where('fa.cat_id', $catID)
            ->get();
    }
}
