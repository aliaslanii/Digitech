<?php

namespace App\Http\Controllers\Api\Home\Product;

use App\HomeProduct;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    protected $HomeProduct;

    public function __construct()
    {
        $this->HomeProduct = new HomeProduct();
    }
    /**
     * @OA\Get(
     *     path="/api/Product/index",
     *     summary="index Products",
     *     tags={"Product Home"},
     *     @OA\Response(
     *          response=200,
     *          description="Data create successfully",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid data",
     *      ),
     * 
     * )
     */
    public function index()
    {
        try {
            $MostViewedProduct = $this->HomeProduct->MostViewedProduct();
            $HotProducts = $this->HomeProduct->HotProducts();
            $productsMaxDiscount = $this->HomeProduct->productsMaxDiscount();
            return Response::json([
                'MostViewedProduct' => $MostViewedProduct,
                'HotProducts' => $HotProducts,
                'ProductMaxDiscount' => $productsMaxDiscount,
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
     *     path="/api/Product/Show",
     *     summary="index Products",
     *     tags={"Product Home"},
     *     @OA\Parameter(
     *         name="dtp",
     *         in="query",
     *         description="dtp product",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Data create successfully",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid data",
     *      ),
     * )
     */
    public function showProduct(Request $request)
    {
        try {
            $Product = Product::where('dtp', $request->dtp)->first();
            $Product->incrementViews();
            $Response = [];
            $ProductData = [
                "name" => $Product->name,
                "description" => $Product->description,
                "stock quantity" => $Product->stock_quantity,
                "specific" => $Product->specific,
                "main photo" => $Product->photo_path,
                "additional photo" => $this->HomeProduct->getImages($Product),
                "Category" => $Product->Category->name,
                "Berand" => $Product->Berand->name,
                'dtp' => $Product->dtp,
                'discount amount' => $Product->discount ? $Product->discount->discount_amount : null,
                'startTime discount' => $Product->discount ? $Product->discount->startTime : null,
                'endTime discount' => $Product->discount ? $Product->discount->endTime : null,
            ];
            $Response[] = $ProductData;
            return Response::json([
                'data' => $Response,
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
