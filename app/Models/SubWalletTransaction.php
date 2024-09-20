<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SubWalletTransaction extends Model
{
    use HasFactory;

    protected $table = "sub_wallet_transactions";
    protected $fillable = ['hospital_id', 'branch_id', 'balance', 'amount', 'comment', 'status'];
    
    
    public function getBranchSubWalletTransaction()
    {
        return SubWalletTransaction::where('branch_id', auth()->user()->org_id)->where('status', 1)->get();
    }

    public function getSubWalletTransactionByHospital()
    {
        return DB::table('sub_wallet_transactions as swt')
            ->join('branches as b', 'b.id', '=', 'swt.branch_id')
            ->select('swt.*', 'b.name as branchName')
            ->where('swt.status', 1)
            ->where('b.status', 1)
            ->where('swt.hospital_id', auth()->user()->org_id)
            ->get();
    }
}
