<?php

namespace App\Http\Controllers\Api\Admin\Color;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    protected $ColorReauest;

    public function __construct()
    {
        $this->ColorReauest = new ColorRequest();
    }
    /**
     * @OA\Get(
     *     path="/api/admin/Color/index",
     *     summary="index Colors",
     *     tags={"Color"},
     *     security={{"bearerAuth":{}}},
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
     *     @OA\Parameter(
     *         name="color",
     *         in="query",
     *         description="Code Color",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Data store successfully",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid data",
     *      ),
     * )
     */
    public function store(Request $request)
    {
        try {
            $Validator = Validator::make($request->all(), $this->ColorReauest->storeRules());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $Color = new Color();
            $Color->name = $request->name;
            $Color->color = $request->color;
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
     *     @OA\Response(
     *          response=200,
     *          description="Data show successfully",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid data",
     *      ),
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
     *     @OA\Response(
     *          response=200,
     *          description="Data edit successfully",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid data",
     *      ),
     *  )
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
     *         name="color",
     *         in="query",
     *         description="Code Color",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Data update successfully",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid data",
     *      ),
     * )
     */
    public function update(Request $request)
    {
        try {
            $Validator = Validator::make($request->all(), $this->ColorReauest->updateRules($request->id));
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $Color = Color::find($request->id);
            $Color->name = $request->name;
            $Color->color = $request->color;
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
     *     @OA\Response(
     *          response=200,
     *          description="Data destroy successfully",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid data",
     *      ),
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
     *     @OA\Response(
     *          response=200,
     *          description="Data restore successfully",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid data",
     *      ),
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
