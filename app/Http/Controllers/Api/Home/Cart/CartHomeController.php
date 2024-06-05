<?php

namespace App\Http\Controllers\Api\Home\Cart;

use App\HomeColor;
use App\HomeProduct;
use App\Http\Controllers\Controller;
use App\Models\CartProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CartHomeController extends Controller
{
    protected $HomeProduct;
    protected $HomeColor;
    public function __construct()
    {
        $this->HomeProduct = new HomeProduct;
        $this->HomeColor = new HomeColor;
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
    public function checkoutCart(Request $request)
    {
        try {
            $Cart = $request->user()->Cart->where('is_pay', 0)->first();
            $Products = [];
            foreach ($Cart->products as $Product) {
                $Products[] = $this->HomeProduct->showProduct($Product);
            }
            return Response::json([
                'status' => true,
                'data' => $Products
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
            $Cart = $request->user()->Cart->where('is_pay', 0)->first();
            return Response::json([
                'status' => true,
                'data' => $Cart
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
                    'data' => "already exists"
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
