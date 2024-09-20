<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = "services";
    protected $fillable = [
        'slug',
        'name',
        'image',
        'description',
        'is_emergency',
        'status'
    ];
    public function getAllServices(){
        return Service::where('status', 1)->get();
    }
    public function getServiceByID($id){
        return Service::where('id', $id)->where('status', 1)->first();
    }
}
