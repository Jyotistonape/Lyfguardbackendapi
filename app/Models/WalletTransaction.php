<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $table = "wallet_transactions";
    protected $fillable = ['hospital_id', 'balance', 'amount', 'comment', 'status'];
    
    
    public function getHospitalWalletTransaction()
    {
        return WalletTransaction::where('hospital_id', auth()->user()->org_id)->where('status', 1)->get();
    }

    public function getWalletTransactionByHospital($hospitalID)
    {
        return WalletTransaction::where('hospital_id', $hospitalID)->where('status', 1)->get();
    }
}
