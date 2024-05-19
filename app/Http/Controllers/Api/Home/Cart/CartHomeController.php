<?php

namespace App\Http\Controllers\Api\Home\Cart;

use App\HomeColor;
use App\HomeProduct;
use App\Http\Controllers\Controller;
use App\Models\CartProduct;
use Illuminate\Http\Request;
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
            $Cart = $request->user()->Cart->where('is_pay',0)->first();
            $Products = [];
            foreach ($Cart->products as $Product) {
                $ProductData = [
                    "count" => $Product->pivot->count,
                    "color name" =>  $this->HomeColor->getColorDetailsById($Product->pivot->color_id)->name,
                    "color" =>  $this->HomeColor->getColorDetailsById($Product->pivot->color_id)->color,
                    "price" =>  $this->HomeProduct->getProductPrice($Product),
                    "name" => $Product->name,
                    "description" => $Product->description,
                    "stock quantity" => $Product->stock_quantity,
                    "specific" => $Product->specific,
                    "main photo" => $Product->photo_path,
                    "Category" => $Product->Category->name,
                    "Berand" => $Product->Berand->name,
                    'dtp' => $Product->dtp,
                    'is_discount' => $this->HomeProduct->getProductDiscount($Product),
                ];
                $Products[] = $ProductData;
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
            $Cart = $request->user()->Cart->where('is_pay',0)->first();
            $productsMaxDiscount = [];
            foreach ($Cart->cartProduct as $Product) {
                $ProductData = [
                    "name" => $Product->name,
                    "description" => $Product->description,
                    "stock quantity" => $Product->stock_quantity,
                    "specific" => $Product->specific,
                    "main photo" => $Product->photo_path,
                    "Category" => $Product->Category->name,
                    "Berand" => $Product->Berand->name,
                    'dtp' => $Product->dtp,
                    'discount amount' => $Product->discount ? $Product->discount->discount_amount : null,
                    'startTime discount' => $Product->discount ? $Product->discount->startTime : null,
                    'endTime discount' => $Product->discount ? $Product->discount->endTime : null,
                ];
                $productsMaxDiscount[] = $ProductData;
            }
            return Response::json([
                'status' => true,
                'data' => $productsMaxDiscount
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
            $Cart = $request->user()->Cart->where('is_pay',0)->first();
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
            $Cart = $request->user()->Cart->where('is_pay',0)->first();
            $CartProdcut = CartProduct::FindCartProduct($request->product_id,$request->color_id,$Cart->id)->first();
            $CartProdcut->count = $CartProdcut->count + 1;
            $CartProdcut->update();
            return Response::json([
                'status' => true,
                'data' => $CartProdcut
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
            $Cart = $request->user()->Cart->where('is_pay',0)->first();
            $CartProdcut = CartProduct::FindCartProduct($request->product_id,$request->color_id,$Cart->id)->first();
            if($CartProdcut->count <= 1)
            {
                $CartProdcut->delete();
                return Response::json([
                    'status' => true,
                    'message' => 'remove product from cart'
                ], 200);
            }else{
                $CartProdcut->count = $CartProdcut->count - 1;
                $CartProdcut->update();
                return Response::json([
                    'status' => true,
                    'data' => $CartProdcut
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
