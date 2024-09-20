<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchType extends Model
{
    use HasFactory;

    protected $table = "branch_types";
    protected $fillable = [
        'slug',
        'name',
        'status'
    ];

    public function getAllType(){

        return BranchType::where('status', 1)->get();
    }

    public function getTypeByID($id){
        return BranchType::where('id', $id)->where('status', 1)->first();
    }


    /**
     * Api
     * */


    public function getApiAllType(){

        return BranchType::where('status', 1)->get();
    }
}
