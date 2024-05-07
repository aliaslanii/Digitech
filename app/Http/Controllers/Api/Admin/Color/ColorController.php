<?php

namespace App\Http\Controllers\Api\Admin\Color;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ColorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin/Color/index",
     *     summary="index Colors",
     *     tags={"Color"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Color index successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function index()
    {
        try {
            $Color = Color::all();
            return Response::json([
                'status' => true,
                'data' => $Color
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
     *     path="/api/admin/Color/create",
     *     summary="create a Color",
     *     tags={"Color"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="Count",
     *         in="query",
     *         description="Count test Color Data",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Test Color Created successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function create(Request $request)
    {
        try {
            $Color = Color::factory()->count($request->Count)->create();
            return Response::json([
                'status' => true,
                'data' => $Color
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
     *     path="/api/admin/Color/store",
     *     summary="create a Color",
     *     tags={"Color"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name Color",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *    @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="description Color",
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
     *                      description="image Color",
     *                      type="string",
     *                      format="binary"
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="Test Color Created successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function store(Request $request)
    {
        try {
            $ColorReauest = new ColorRequest();
            $Validator = Validator::make($request->all(),$ColorReauest->storeRules());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $Color = new Color();
            $Color->name = $request->name;
            $Color->description = $request->description;
            $Color->photo_path = $this->FileTransfer->moveFile($request,$this->path);
            $Color->save();
            return Response::json([
                'status' => true,
                'data' => $Color
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
     *     path="/api/admin/Color/show",
     *     summary="create a Color",
     *     tags={"Color"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Color",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Test Color Created successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function show(Request $request)
    {
        try {
            $Color = Color::find($request->id);
            return Response::json([
                'status' => true,
                'data' => $Color
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
     *     path="/api/admin/Color/edit",
     *     summary="create a Color",
     *     tags={"Color"},
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Color",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Test Color Created successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function edit(Request $request)
    {
        try {
            $Color = Color::find($request->id);
            return Response::json([
                'status' => true,
                'data' => $Color
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
     *     path="/api/admin/Color/update",
     *     summary="create a Color",
     *     tags={"Color"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Color",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name Color",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="description Color",
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
     *                      description="image Color",
     *                      type="string",
     *                      format="binary"
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="Test Color Created successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function update(Request $request)
    {
        try {
            $ColorReauest = new ColorRequest();
            $Validator = Validator::make($request->all(),$ColorReauest->updateRules($request->id));
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $Color = Color::find($request->id);
            $Color->name = $request->name;
            $Color->description = $request->description;
            $Color->photo_path = $this->FileTransfer->updateFile($Color,$request,$this->path);
            $Color->save();
            return Response::json([
                'status' => true,
                'data' => $Color
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
     *     path="/api/admin/Color/destroy",
     *     summary="Delete a Color",
     *     tags={"Color"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Color",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Color destroy successfully"),
     * )
     */
    public function destroy(Request $request)
    {
        try {
            $Color = Color::findOrfail($request->id);
            $Color->delete();
            return Response::json([
                'status' => true,
                'data' => $Color
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
     *     path="/api/admin/Color/restore",
     *     summary="Restore a Color",
     *     tags={"Color"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Color",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Color restore successfully"),
     * )
     */
    public function restore(Request $request)
    {
        try {
            $Color = Color::where('id', $request->id)->restore();
            return Response::json([
                'status' => true,
                'data' => $Color
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
