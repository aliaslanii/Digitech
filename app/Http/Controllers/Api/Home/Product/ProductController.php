<?php

namespace App\Http\Controllers\Api\Home\Product;

use App\HomeColor;
use App\HomeProduct;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    protected $HomeProduct;
    protected $HomeColor;

    public function __construct()
    {
        $this->HomeProduct = new HomeProduct();
        $this->HomeColor = new HomeColor();
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
     *         @OA\Schema(type="string")
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
                "stock quantity" => $this->HomeProduct->stockQuantityProduct($Product),
                "detail Producu price color" => $this->HomeProduct->getMinDetailProduct($Product),
                "specific" => $Product->specific,
                "main photo" => $Product->photo_path,
                "additional photo" => $this->HomeProduct->getImages($Product),
                "Category" => $Product->Category->name,
                "Berand" => $Product->Berand->name,
                'dtp' => $Product->dtp,
                'is_discount' => $this->HomeProduct->getProductDiscount($Product),
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
