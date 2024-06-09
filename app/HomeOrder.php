<?php

namespace App;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class HomeOrder
{
    protected $HomeCart;
    public function __construct()
    {
        $this->HomeCart = new HomeCart;
    }
    public function createTransaction($request, $transaction_type)
    {
        $Transaction = new Transaction();
        $Transaction->user_id = Auth::user()->id;
        $Transaction->transaction_type = $transaction_type;
        $Transaction->amount = $request->Amount;
        $Transaction->description = ($transaction_type === 'charge') ? 'شارژ کیف پول - رسید دیجیتال' . $request->RefNum : 'کسر از کیف پول' . $request->RefNum;
        $Transaction->save();
    }
    public function chargeWallet($request)
    {
        $wallet = $request->user()->wallet;
        $wallet->inventory = $request->Amount;
        $wallet->update();
        return $wallet;
    }
    public function findOrder($request)
    {
        return Order::where('ordernumber', $request->ResNum)->first();
    }
    public function submitShoppingCart()
    {
        $Cart = $this->HomeCart->getCartUser();
        $Cart->is_pay = 1;
        $Cart->save();
        $Cart = new Cart();
        $Cart->user_id = Auth::user()->id;
        $Cart->is_pay = 0;
        $Cart->save();
    }
}
