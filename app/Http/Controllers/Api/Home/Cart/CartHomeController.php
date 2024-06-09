<?php

namespace App\Http\Controllers\Api\Home\Cart;

use App\HomeCart;
use App\HomeColor;
use App\HomeProduct;
use App\Http\Controllers\Controller;
use App\Models\AddressCustomer;
use App\Models\CartProduct;
use App\Models\ColorProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CartHomeController extends Controller
{
    protected $HomeProduct;
    protected $HomeColor;
    protected $HomeCart;
    public function __construct()
    {
        $this->HomeProduct = new HomeProduct;
        $this->HomeColor = new HomeColor;
        $this->HomeCart = new HomeCart;
    }
    /**
     * @OA\Get(
     *     path="/api/Cart/checkout/Cart",
     *     summary="Show Products in Cart",
     *     security={{"bearerAuth":{}}},
     *     tags={"Cart"},
     *     @OA\Response(
     *          response=200,
     *          description="Data index successfully",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid data",
     *      ),
     * )
     */
    public function checkoutCart()
    {
        try {
            $Cart = $this->HomeCart->getCartUser();
            $Products = [];
            foreach ($Cart->products as $Product) {
                $dataProduct = [
                    "name" => $Product->name,
                    "description" => $Product->description,
                    "stock quantity" => $this->HomeProduct->stockQuantityProduct($Product),
                    "detail Producut price color" => $this->HomeCart->getPPCC($Product),
                    "specific" => $Product->specific,
                    "main photo" => $Product->photo_path,
                    "additional photo" => $this->HomeProduct->getImages($Product),
                    "Category" => $Product->Category->name,
                    "Berand" => $Product->Berand->name,
                    'dtp' => $Product->dtp,
                    'is_discount' => $this->HomeProduct->getProductDiscount($Product),
                ];
                $Products[] = $dataProduct;
            }
            return Response::json([
                'status' => true,
                'Products' => $Products,
                'ToalPrice' => $this->HomeCart->getCartToalPrice()
            ], 200);
            return Response::json([
                'status' => true,
                'Products' => $Products,
                'ToalPrice' => $this->HomeCart->getCartToalPrice()
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/Cart/checkout/shipping",
     *     summary="Show Products in Cart",
     *     security={{"bearerAuth":{}}},
     *     tags={"Cart"},
     *     @OA\Parameter(
     *         name="address_id",
     *         in="query",
     *         description="id address",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Data index successfully",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid data",
     *      ),
     * )
     */
    public function checkoutShipping(Request $request)
    {
        try {
            $AddressCustomer = AddressCustomer::find($request->address_id);    
            if ($AddressCustomer->user_id == Auth::user()->id) 
            {
                $Cart = $this->HomeCart->getCartUser();
                $Cart->address_customer_id = $request->address_id;
                $Cart->update();
                return redirect(route('payMent'));
            }else{
                return Response::json([
                    'status' => false,
                    'message' => "Not found"
                ], 500);
            }
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/Cart/Add/Product",
     *     summary="Add Product in Cart",
     *     security={{"bearerAuth":{}}},
     *     tags={"Cart"},
     *      @OA\Parameter(
     *         name="product_id",
     *         in="query",
     *         description="id product",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="color_id",
     *         in="query",
     *         description="id product",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Data index successfully",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid data",
     *      ),
     * )
     */
    public function addProduct(Request $request)
    {
        try {
            $Cart = $request->user()->Cart->where('is_pay', 0)->first();
            if(ColorProduct::FindColorProduct($request->product_id, $request->color_id)->first() != null)
            {
                if ($this->HomeProduct->isDuplicate($Cart->id, $request->product_id, $request->color_id) == true) {
                    $CartProdcut = new CartProduct();
                    $CartProdcut->cart_id = $Cart->id;
                    $CartProdcut->product_id = $request->product_id;
                    $CartProdcut->color_id = $request->color_id;
                    $CartProdcut->count = 1;
                    $CartProdcut->save();
                    return Response::json([
                        'status' => true,
                        'data' => $CartProdcut
                    ], 200);
                } else {
                    return Response::json([
                        'status' => false,
                        'data' => "Produc already exists"
                    ], 200);
                }
            }
            else{
                return Response::json([
                    'status' => false,
                    'data' => "The Color of this Product is not available"
                ], 200);
            }
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/Cart/Added/Product",
     *     summary="Add Added in Cart",
     *     security={{"bearerAuth":{}}},
     *     tags={"Cart"},
     *      @OA\Parameter(
     *         name="product_id",
     *         in="query",
     *         description="id product",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="color_id",
     *         in="query",
     *         description="id product",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Data index successfully",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid data",
     *      ),
     * )
     */
    public function addedProduct(Request $request)
    {
        try {
            $Cart = $request->user()->Cart->where('is_pay', 0)->first();
            if ($this->HomeProduct->isAvailableAdded($Cart->id, $request->product_id, $request->color_id) == true) {
                $CartProdcut = CartProduct::FindCartProduct($request->product_id, $request->color_id, $Cart->id)->first();
                $CartProdcut->count = $CartProdcut->count + 1;
                $CartProdcut->update();
                return Response::json([
                    'status' => true,
                    'data' => $CartProdcut
                ], 200);
            } else if ($this->HomeProduct->isAvailableAdded($Cart->id, $request->product_id, $request->color_id) == null) {
                return Response::json([
                    'status' => false,
                    'message' => "not found"
                ], 200);
            } else {
                return Response::json([
                    'status' => false,
                    'message' => "out of stock"
                ], 200);
            }
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/Cart/Decreased/Product",
     *     summary="Decreased Product in Cart",
     *     security={{"bearerAuth":{}}},
     *     tags={"Cart"},
     *      @OA\Parameter(
     *         name="product_id",
     *         in="query",
     *         description="id product",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="color_id",
     *         in="query",
     *         description="id product",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Data index successfully",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid data",
     *      ),
     * )
     */
    public function decreasedProduct(Request $request)
    {
        try {
            $Cart = $request->user()->Cart->where('is_pay', 0)->first();
            $CartProdcut = CartProduct::FindCartProduct($request->product_id, $request->color_id, $Cart->id)->first();
            if ($CartProdcut != null) {
                if ($CartProdcut->count <= 1) {
                    $CartProdcut->delete();
                    return Response::json([
                        'status' => true,
                        'message' => 'remove product from cart'
                    ], 200);
                } else {
                    $CartProdcut->count = $CartProdcut->count - 1;
                    $CartProdcut->update();
                    return Response::json([
                        'status' => true,
                        'data' => $CartProdcut
                    ], 200);
                }
            } else {
                return Response::json([
                    'status' => false,
                    'message' => "not found"
                ], 200);
            }
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
