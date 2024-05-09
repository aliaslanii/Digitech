<?php

namespace App\Http\Controllers\Api\Admin\Product;

use App\FileTransfer;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\ColorProduct;
use App\Models\Discount;
use App\Models\FeatureProduct;
use App\Models\ImageProduct;
use App\Models\Product;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $FileTransfer;
    protected $ProductRequest;
    protected $path;
    public function __construct()
    {
        $this->FileTransfer = new FileTransfer();
        $this->ProductRequest = new ProductRequest();
        $this->path = 'images/Product-image';
    }
    /**
     * @OA\Get(
     *     path="/api/admin/Product/index",
     *     summary="index Products",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="User registered successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function index()
    {
        try {
            $Product = Product::all();
            return Response::json([
                'status' => true,
                'data' => $Product
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
     *     path="/api/admin/Product/create",
     *     summary="create a Product",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="Count",
     *         in="query",
     *         description="Count test product Data",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Test Product Created successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function create(Request $request)
    {
        try {
            $Product = Product::factory()->count($request->Count)->create();
            return Response::json([
                'status' => true,
                'data' => $Product
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/admin/Product/store",
     *     summary="create a Product",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="description Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="price",
     *         in="query",
     *         description="price Product",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="stock_quantity",
     *         in="query",
     *         description="stock_quantity Product",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="Category",
     *         in="query",
     *         description="Category Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="Berand",
     *         in="query",
     *         description="Berand Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *     required=true,
     *     description="Product images",
     *     @OA\MediaType(
     *         mediaType="multipart/form-data",
     *         @OA\Schema(
     *             @OA\Property(
     *                 property="main_image",
     *                 type="string",
     *                 format="binary",
     *                 description="Main product image"
     *             ),
     *             @OA\Property(
     *                 property="additional_images[]",
     *                 type="array",
     *                 @OA\Items(
     *                     type="string",
     *                     format="binary",
     *                     description="Additional product images"
     *                 )
     *             )
     *         )
     *     )
     *    ),
     *     @OA\Response(response="200", description="Test Product Created successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     *  ),
     */
    public function store(Request $request)
    {
        try {
            $Validator = Validator::make($request->all(), $this->ProductRequest->storeRules());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $Product = new Product();
            $Product->name = $request->name;
            $Product->description = $request->description;
            $Product->stock_quantity = $request->stock_quantity;
            $Product->categorie_id = $request->Category;
            $Product->berand_id = $request->Berand;
            $Product->photo_path = $this->FileTransfer->moveProductMainImage($request, $this->path);
            $Product->save();
            $this->FileTransfer->moveProductAdditionalImages($Product, $request, $this->path);
            return Response::json([
                'status' => true,
                'data' => $Product
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
     *     path="/api/admin/Product/show",
     *     summary="Show a Product",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Product",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Show Product successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function show(Request $request)
    {
        try {
            $Product = Product::find($request->id);
            return Response::json([
                'status' => true,
                'data' => $Product
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
     *     path="/api/admin/Product/edit",
     *     summary="edit a Product",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Product",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="edit Product successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function edit(Request $request)
    {
        try {
            $Product = Product::find($request->id);
            return Response::json([
                'status' => true,
                'data' => $Product
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/admin/Product/update",
     *     summary="update a Product",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Product",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="description Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="price",
     *         in="query",
     *         description="price Product",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="stock_quantity",
     *         in="query",
     *         description="stock_quantity Product",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="Category",
     *         in="query",
     *         description="Category Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="Berand",
     *         in="query",
     *         description="Berand Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *     required=true,
     *     description="Product images",
     *     @OA\MediaType(
     *         mediaType="multipart/form-data",
     *         @OA\Schema(
     *             @OA\Property(
     *                 property="main_image",
     *                 type="string",
     *                 format="binary",
     *                 description="Main product image"
     *             ),
     *         )
     *     )
     *    ),
     *     @OA\Response(response="200", description="Test Product Created successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     *  ),
     */
    public function update(Request $request)
    {
        try {
            $Validator = Validator::make($request->all(), $this->ProductRequest->updateRules($request->id));
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $Product = Product::find($request->id);
            $Product->name = $request->name;
            $Product->description = $request->description;
            $Product->stock_quantity = $request->stock_quantity;
            $Product->categorie_id = $request->Category;
            $Product->berand_id = $request->Berand;
            $Product->photo_path = $this->FileTransfer->updateProductMainImage($Product, $request, $this->path);
            $Product->save();
            return Response::json([
                'status' => true,
                'data' => $Product
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Delete(
     *     path="/api/admin/Product/destroy",
     *     summary="Delete a Product",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Product destroy successfully"),
     * )
     */
    public function destroy(Request $request)
    {
        try {
            $Product = Product::findOrfail($request->id);
            $Product->delete();
            return Response::json([
                'status' => true,
                'data' => $Product
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Delete(
     *     path="/api/admin/Product/remove/image",
     *     summary="remove a image Product",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id image Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Product remove image successfully"),
     * )
     */
    public function removeProductImage(Request $request)
    {
        try {
            $ImageProduct = ImageProduct::find($request->id);
            File::delete($ImageProduct->photo_path);
            $ImageProduct->delete();
            return Response::json([
                'status' => true
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/admin/Product/add/image",
     *     summary="update a Product",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Product",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *     required=true,
     *     description="Product images",
     *     @OA\MediaType(
     *         mediaType="multipart/form-data",
     *         @OA\Schema(
     *             @OA\Property(
     *                 property="additional_images[]",
     *                 type="array",
     *                 @OA\Items(
     *                     type="string",
     *                     format="binary",
     *                     description="Additional product images"
     *                 )
     *             )
     *         )
     *     )
     *    ),
     *     @OA\Response(response="200", description="Test Product Created successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     *  ),
     */
    public function addProductImage(Request $request)
    {
        try {
            $Product = Product::find($request->id);
            $this->FileTransfer->moveProductAdditionalImages($Product, $request, $this->path);
            return Response::json([
                'status' => true,
                'data' => $Product
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Put(
     *     path="/api/admin/Product/restore",
     *     summary="Restore a Product",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Product restore successfully"),
     * )
     */
    public function restore(Request $request)
    {
        try {
            $Product = Product::where('id', $request->id)->restore();
            return Response::json([
                'status' => true,
                'data' => $Product
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/admin/Product/add/Discount",
     *     summary="add Discount in Product",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="product_id",
     *         in="query",
     *         description="id Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="discount_amount",
     *         in="query",
     *         description="amount discount Product",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="startTime",
     *         in="query",
     *         description="startTime Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="endTime",
     *         in="query",
     *         description="startTime Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Data updated successfully",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid data",
     *      ),
     * )
     */
    public function addProductDiscount(Request $request)
    {
        try {
            $Product = Product::find($request->product_id);
            $Discount = new Discount();
            $Discount->product_id = $request->product_id;
            $Discount->discount_amount = $request->discount_amount;
            $Discount->startTime =  Verta::parse($request->startTime)->datetime();
            $Discount->endTime =  Verta::parse($request->endTime)->datetime();
            $Discount->save();
            return Response::json([
                'status' => true,
                'Product Discount' => $Product->discount
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/admin/Product/update/Discount",
     *     summary="update Discount in Product",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *    @OA\Parameter(
     *         name="product_id",
     *         in="query",
     *         description="id Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="discount_amount",
     *         in="query",
     *         description="amount discount Product",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="startTime",
     *         in="query",
     *         description="startTime Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="endTime",
     *         in="query",
     *         description="startTime Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Data updated successfully",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid data",
     *      ),
     * )
     */
    public function updateProductDiscount(Request $request)
    {
        try {
            $Product = Product::find($request->product_id);
            $Discount = $Product->discount;
            $Discount->product_id = $request->product_id;
            $Discount->discount_amount = $request->discount_amount;
            $Discount->startTime =  Verta::parse($request->startTime)->datetime();
            $Discount->endTime =  Verta::parse($request->endTime)->datetime();
            $Discount->save();
            return Response::json([
                'status' => true,
                'Product Discount' => $Product->discount
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
/**
     * @OA\Post(
     *     path="/api/admin/Product/remove/Discount",
     *     summary="update Discount in Product",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *    @OA\Parameter(
     *         name="product_id",
     *         in="query",
     *         description="id Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Data updated successfully",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid data",
     *      ),
     * )
     */
    public function removeProductDiscount(Request $request)
    {
        try {
            $Product = Product::find($request->product_id);
            $Discount = $Product->discount;
            $Discount->delete();
            return Response::json([
                'status' => true,
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/admin/Product/add/Color/Price",
     *     summary="add Color Price in Product",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="product_id",
     *         in="query",
     *         description="id Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *    @OA\RequestBody(
     *          required=true,
     *          description="Data to be updated",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="ColorPrice",
     *                      type="array",
     *                      description="Array of Color and Price to be updated",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(
     *                              property="Color",
     *                              type="string",
     *                              description="id Color of the Product",
     *                          ),
     *                          @OA\Property(
     *                              property="Quantity",
     *                              type="string",
     *                              description="Quantity Product",
     *                          ),
     *                          @OA\Property(
     *                              property="Price",
     *                              type="string",
     *                              description="Price of the Product",
     *                          ),
     *                      ),
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Data updated successfully",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid data",
     *      ),
     * )
     */
    public function addProductColorPrice(Request $request)
    {
        try {
            $Product = Product::find($request->product_id);
            foreach($request->ColorPrice as $ColorPrice)
            {
                $ColorProduct = new ColorProduct();
                $ColorProduct->product_id = $request->product_id;
                $ColorProduct->color_id = $ColorPrice['Color'];
                $ColorProduct->price = $ColorPrice['Price'];
                $ColorProduct->quantity = $ColorPrice['Quantity'];
                $ColorProduct->save();
            }
            return Response::json([
                'status' => true,
                'Product Detial' => $Product->ColorProduct
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/admin/Product/update/Color/Price",
     *     summary="add Color Price in Product",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="product_id",
     *         in="query",
     *         description="id Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *    @OA\RequestBody(
     *          required=true,
     *          description="Data to be updated",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="ColorPrice",
     *                      type="array",
     *                      description="Array of Color and Price to be updated",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(
     *                              property="Color",
     *                              type="string",
     *                              description="id Color of the Product",
     *                          ),
     *                          @OA\Property(
     *                              property="Quantity",
     *                              type="string",
     *                              description="Quantity Product",
     *                          ),
     *                          @OA\Property(
     *                              property="Price",
     *                              type="string",
     *                              description="Price of the Product",
     *                          ),
     *                      ),
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Data updated successfully",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid data",
     *      ),
     * )
     */
    public function updateProductColorPrice(Request $request)
    {
        try {
            $Product = Product::find($request->product_id);
            ColorProduct::where('product_id','=',$Product->id)->delete();
            foreach($request->ColorPrice as $ColorPrice)
            {
                $ColorProduct = new ColorProduct();
                $ColorProduct->product_id = $request->product_id;
                $ColorProduct->color_id = $ColorPrice['Color'];
                $ColorProduct->price = $ColorPrice['Price'];
                $ColorProduct->quantity = $ColorPrice['Quantity'];
                $ColorProduct->save();
            }
            return Response::json([
                'status' => true,
                'Product Detial' => $Product->ColorProduct
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/admin/Product/add/Detial",
     *     summary="add Detial in Product",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="product_id",
     *         in="query",
     *         description="id Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *    @OA\RequestBody(
     *          required=true,
     *          description="Data to be updated",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="featureProducts",
     *                      type="array",
     *                      description="Array of Feature product",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(
     *                              property="title",
     *                              type="string",
     *                              description="title Feature Product",
     *                          ),
     *                          @OA\Property(
     *                              property="value",
     *                              type="string",
     *                              description="value Feature Product",
     *                          ),
     *                      ),
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Data updated successfully",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid data",
     *      ),
     * )
     */
    public function addProductDetial(Request $request)
    {
        try {
            $Product = Product::find($request->product_id);
            foreach($request->featureProducts as $featureProduct)
            {
                $FeatureProduct = new FeatureProduct();
                $FeatureProduct->product_id = $request->product_id;
                $FeatureProduct->title = $featureProduct['title'];
                $FeatureProduct->value = $featureProduct['value'];
                $FeatureProduct->save();
            }
            return Response::json([
                'status' => true,
                'Product Detial' => $Product->featureProducts
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/admin/Product/update/Detial",
     *     summary="add Detial in Product",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="product_id",
     *         in="query",
     *         description="id Product",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *    @OA\RequestBody(
     *          required=true,
     *          description="Data to be updated",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="featureProducts",
     *                      type="array",
     *                      description="Array of Feature product",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(
     *                              property="title",
     *                              type="string",
     *                              description="title Feature Product",
     *                          ),
     *                          @OA\Property(
     *                              property="value",
     *                              type="string",
     *                              description="value Feature Product",
     *                          ),
     *                      ),
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Data updated successfully",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid data",
     *      ),
     * )
     */
    public function updateProductDetial(Request $request)
    {
        try {
            $Product = Product::find($request->product_id);
            FeatureProduct::where('product_id','=',$Product->id)->delete();
            foreach($request->featureProducts as $featureProduct)
            {
                
                $FeatureProduct = new FeatureProduct();
                $FeatureProduct->product_id = $request->product_id;
                $FeatureProduct->title = $featureProduct['title'];
                $FeatureProduct->value = $featureProduct['value'];
                $FeatureProduct->save();
            }
            return Response::json([
                'status' => true,
                'Product Detial' => $Product->featureProducts
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
