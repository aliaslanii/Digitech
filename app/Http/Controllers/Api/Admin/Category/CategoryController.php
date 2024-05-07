<?php

namespace App\Http\Controllers\Api\Admin\Category;

use App\FileTransfer;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    protected $path;
    protected $FileTransfer;
    protected $CategoryReauest;
    
    public function __construct()
    {
        $this->path = 'images/Category-image';
        $this->FileTransfer = new FileTransfer();
        $this->CategoryReauest = new CategoryRequest();
    }
    /**
     * @OA\Get(
     *     path="/api/admin/Category/index",
     *     summary="index Categorys",
     *     tags={"Category"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Category index successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function index()
    {
        try {
            $Category = Category::all();
            return Response::json([
                'status' => true,
                'data' => $Category
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
     *     path="/api/admin/Category/create",
     *     summary="create a Category",
     *     tags={"Category"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="Count",
     *         in="query",
     *         description="Count test Category Data",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Test Category Created successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function create(Request $request)
    {
        try {
            $Category = Category::factory()->count($request->Count)->create();
            return Response::json([
                'status' => true,
                'data' => $Category
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
     *     path="/api/admin/Category/store",
     *     summary="create a Category",
     *     tags={"Category"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name Category",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *    @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="description Category",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          description="Image file to upload",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="image",
     *                      description="image Category",
     *                      type="string",
     *                      format="binary"
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="Test Category Created successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function store(Request $request)
    {
        try {
            $Validator = Validator::make($request->all(),$this->CategoryReauest->storeRules());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $Category = new Category();
            $Category->name = $request->name;
            $Category->description = $request->description;
            $Category->photo_path = $this->FileTransfer->moveFile($request,$this->path);
            $Category->save();
            return Response::json([
                'status' => true,
                'data' => $Category
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/admin/Category/show",
     *     summary="create a Category",
     *     tags={"Category"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Category",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Test Category Created successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function show(Request $request)
    {
        try {
            $Category = Category::find($request->id);
            return Response::json([
                'status' => true,
                'data' => $Category
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
     *     path="/api/admin/Category/edit",
     *     summary="create a Category",
     *     tags={"Category"},
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Category",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Test Category Created successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function edit(Request $request)
    {
        try {
            $Category = Category::find($request->id);
            return Response::json([
                'status' => true,
                'data' => $Category
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
     *     path="/api/admin/Category/update",
     *     summary="create a Category",
     *     tags={"Category"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Category",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name Category",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="description Category",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          description="Image file to upload",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="image",
     *                      description="image Category",
     *                      type="string",
     *                      format="binary"
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="Test Category Created successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function update(Request $request)
    {
        try {
            $Validator = Validator::make($request->all(),$this->CategoryReauest->updateRules($request->id));
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $Category = Category::find($request->id);
            $Category->name = $request->name;
            $Category->description = $request->description;
            $Category->photo_path = $this->FileTransfer->updateFile($Category,$request,$this->path);
            $Category->save();
            return Response::json([
                'status' => true,
                'data' => $Category
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
    /**
     * @OA\Delete(
     *     path="/api/admin/Category/destroy",
     *     summary="Delete a Category",
     *     tags={"Category"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Category",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Category destroy successfully"),
     * )
     */
    public function destroy(Request $request)
    {
        try {
            $Category = Category::findOrfail($request->id);
            $Category->delete();
            return Response::json([
                'status' => true,
                'data' => $Category
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
     *     path="/api/admin/Category/restore",
     *     summary="Restore a Category",
     *     tags={"Category"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Category",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Category restore successfully"),
     * )
     */
    public function restore(Request $request)
    {
        try {
            $Category = Category::where('id', $request->id)->restore();
            return Response::json([
                'status' => true,
                'data' => $Category
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
