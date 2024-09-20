<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AddBalanceToWalletController extends Controller
{
    private $hospital, $wallet_transaction;

    public function __construct()
    {
        $this->hospital = new Hospital();
        $this->wallet_transaction = new WalletTransaction();
    }

    public function create(){
        $data['pageName'] = "Add Balance To Hospital Wallet";
        $data['hospitals'] = $this->hospital->getAllHospital();
        return view('panel.hospital.add-balance')->with('data', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hospital' => 'required',
            'amount' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $hospitalData = $this->hospital->getHospitalByID($request->input('hospital'));
        if (!$hospitalData)
            return Redirect::back()->with('error', 'Invalid Hospital');
            
        $walletTransaction = WalletTransaction::create([
                'hospital_id' => $request->input('hospital'),
                'balance' => $hospitalData->wallet_balance,
                'amount' => $request->input('amount'),
            ]);
        if ($walletTransaction) {
            $hospital = Hospital::where('id', $request->input('hospital'))->where('status', 1)->update([
                'wallet_balance' => $hospitalData->wallet_balance + $request->input('amount')
                ]);
            if($hospital){
                return Redirect::back()->with('success', 'Balance Added');
            }   else{
                WalletTransaction::destroy($walletTransaction->id);
                return Redirect::back()->with('error', 'Please try again');
            }  
        } else {
            return Redirect::back()->with('error', 'Please try again');
        }
    }
}
