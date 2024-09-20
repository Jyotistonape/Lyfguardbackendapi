<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class SubWalletController extends Controller
{
    private $branch;

    public function __construct()
    {
        $this->branch = new Branch();
    }

    public function index(){
        $data['pageName'] = "Wallet";
        $data['walletBalance'] = $this->branch->getBranchByID(auth()->user()->org_id)->wallet_balance;
        return view('panel.subwallet.wallet')->with('data', $data);
    }
}
