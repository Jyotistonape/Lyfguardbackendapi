<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstAidCategory extends Model
{
    use HasFactory;

    protected $table = "first_aid_categories";
    protected $fillable = [
        'slug',
        'name',
        'status'
    ];

    public function getAllCategory(){

        return FirstAidCategory::where('status', 1)->get();
    }

    public function getCategoryByID($id){
        return FirstAidCategory::where('id', $id)->where('status', 1)->first();
    }


    /**
     * Api
     * */


    public function getApiAllCategory(){

        return FirstAidCategory::where('status', 1)->get();
    }
}
