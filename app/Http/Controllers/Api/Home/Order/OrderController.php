<?php

namespace App\Http\Controllers\Api\Home\Order;

use App\HomeCart;
use App\HomeOrder;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{
    protected $HomeCart;
    protected $HomeOrder;

    public function __construct()
    {
        $this->HomeCart = new HomeCart;
        $this->HomeOrder = new HomeOrder;
    }
    public function payMent()
    {
        try {
            $Cart = $this->HomeCart->getCartUser();
            $total_price = $this->HomeCart->getCartToalPrice();
            $ordernumber = "Digitech-" . random_int(1403, 99999999);
            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->mobile = Auth::user()->mobile;
            $order->order_date = Carbon::now();
            $order->ordernumber = $ordernumber;
            $order->total_price = $total_price;
            $order->is_payed = 0;
            $order->Status = "unpaid";
            $order->save();
            foreach ($Cart->products as $Product) {
                $OrderDetails = new OrderDetail();
                $OrderDetails->order_id = $order->id;
                $OrderDetails->product_id = $Product->id;
                $OrderDetails->color_id = $Product->pivot->color_id;
                $OrderDetails->quantity = $Product->pivot->count;
                $OrderDetails->unit_price = $this->HomeCart->getPPCC($Product)["Price"];
                $OrderDetails->save();
            }
            $url = 'https://sandbox.banktest.ir/saman/sep.shaparak.ir/OnlinePG/OnlinePG?';
            $data = [
                'Username' => env('BANK_USERNAME', 'default_user'),
                'Password' => env('BANK_PASSWORD', 'default_pass'),
                'action' => 'token',
                'Amount' => $total_price,
                'Wage' => 2,
                'AffectiveAmount' => '134755516',
                'TerminalId' => env('BANK_TERMINALID','default_terminalid'),
                'ResNum' => $ordernumber,
                'CellNumber' => Auth::user()->mobile,
                'RedirectURL' => url('/api/orders/Paydone')
            ];
            $response = Http::post($url, $data);
            if ($response->successful()) {
                $jsonResponse = $response->json();
                $token = $jsonResponse['token'];
                return redirect('https://sandbox.banktest.ir/saman/sep.shaparak.ir/OnlinePG/SendToken?token=' . $token);
            } else {
                return Response::json([
                    'status' => false,
                    'message' => 'Invalid request'
                ], 500);
            }
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function payDone(Request $request)
    {
        try {
            if ($request->State == "OK") {
                $RefNum = Order::where('ordernumber', $request->RefNum)->first();
                if ($RefNum) {
                    return Response::json([
                        'status' => false,
                        'message' => "Double Spending"
                    ], 500);
                } else {
                    $this->HomeOrder->createTransaction($request, "charge");
                    $wallet = $this->HomeOrder->chargeWallet($request); 
                    $order = $this->HomeOrder->findOrder($request);
                    if ($wallet->inventory >= $order->Amount) {
                        $this->HomeOrder->createTransaction($request, "debit");
                        $this->HomeOrder->submitShoppingCart();
                        $wallet->inventory -= $request->Amount;
                        $wallet->update();
                        $order->total_price = $request->Amount;
                        $order->is_payed = 1;
                        $order->update();
                    }
                    return Response::json([
                        'status' => true,
                        'data' => $order
                    ], 200);
                }
            } else {
                $messages = [
                    "Failed" => "Payment Failed",
                    "Canceled By User" => "Canceled By User",
                    "Invalid Merchant" => "Invalid Merchant",
                    "InvalidParameters" => "Invalid Parameters",
                    "Invalid Transaction" => "Invalid Parameters",
                    "Honour With Identification" => "Honour With Identification"
                ];
                $status_codes = [
                    "Failed" => 2,
                    "Canceled By User" => 2,
                    "Invalid Merchant" => 2,
                    "InvalidParameters" => 3,
                    "Invalid Transaction" => 12,
                    "Honour With Identification" => 8
                ];
        
                if (isset($messages[$request->State])) {
                    return Response::json([
                        'status' => $status_codes[$request->State],
                        'message' => $messages[$request->State]
                    ], 500);
                }
            }
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
