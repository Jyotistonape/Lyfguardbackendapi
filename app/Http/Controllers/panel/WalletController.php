<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Hospital;
use App\Models\WalletTransaction;
use App\Models\SubWalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    private $hospital, $wallet_transaction, $sub_wallet_transaction, $branch;

    public function __construct()
    {
        $this->hospital = new Hospital();
        $this->wallet_transaction = new WalletTransaction();
        $this->sub_wallet_transaction = new SubWalletTransaction();
        $this->branch = new Branch();
    }

    public function index(){
        $data['pageName'] = "Wallet";
        $data['walletBalance'] = $this->hospital->getHospitalByID(auth()->user()->org_id)->wallet_balance;
        $data['walletTransactions'] = $this->wallet_transaction->getHospitalWalletTransaction();
        $data['subwalletTransactions'] = $this->sub_wallet_transaction->getSubWalletTransactionByHospital();
        return view('panel.wallet.wallet')->with('data', $data);
    }

    public function create(){
        $data['pageName'] = "Add Balance To Branch Wallet";
        $data['branches'] = $this->branch->getAllBranch();
        return view('panel.branch.add-balance')->with('data', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'branch' => 'required',
            'amount' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $hospitalData = $this->hospital->getHospitalByID(auth()->user()->org_id);
        if (!$hospitalData)
            return Redirect::back()->with('error', 'Invalid Hospital');

        $branchData = $this->branch->getBranchByID($request->input('branch'));
        if (!$branchData)
            return Redirect::back()->with('error', 'Invalid Branch');

        if($hospitalData->wallet_balance < $request->input('amount'))  
           return Redirect::back()->with('error', 'Insufficient Balance !'); 
            
        $subWalletTransaction = SubWalletTransaction::create([
                'hospital_id' => auth()->user()->org_id,
                'branch_id' => $request->input('branch'),
                'balance' => $branchData->wallet_balance,
                'amount' => $request->input('amount'),
            ]);
        if ($subWalletTransaction) {
            $branch = Branch::where('id', $request->input('branch'))->where('status', 1)->update([
                'wallet_balance' => $branchData->wallet_balance + $request->input('amount')
                ]);
                if($branch){
                    Hospital::where('id', auth()->user()->org_id)->where('status', 1)->update([
                        'wallet_balance' => $hospitalData->wallet_balance - $request->input('amount')
                        ]);
                    return \redirect(route('getWallet'))->with('success', 'Balance Added');
                } else{
                    SubWalletTransaction::destroy($subWalletTransaction->id);
                    return Redirect::back()->with('error', 'Please try again');
                }
        } else {
            return Redirect::back()->with('error', 'Please try again');
        }
    }
}
