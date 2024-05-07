<?php

namespace App\Http\Controllers\Api\Admin\Berand;

use App\FileTransfer;
use App\Http\Controllers\Controller;
use App\Http\Requests\BerandRequest;
use App\Models\Berand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class BerandController extends Controller
{
    protected $path;
    protected $FileTransfer;
    protected $BerandRequest;

    public function __construct()
    {
        $this->FileTransfer = new FileTransfer();
        $this->path = 'images/Berand-image';
        $this->BerandRequest = new BerandRequest();
    }
    /**
     * @OA\Get(
     *     path="/api/admin/Berand/index",
     *     summary="index Berands",
     *     tags={"Berand"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="User registered successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function index()
    {
        try {
            $Berand = Berand::all();
            return Response::json([
                'status' => true,
                'data' => $Berand
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
     *     path="/api/admin/Berand/create",
     *     summary="create a Berand",
     *     tags={"Berand"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="Count",
     *         in="query",
     *         description="Count test Berand Data",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Test Berand Created successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function create(Request $request)
    {
        try {
            $Berand = Berand::factory()->count($request->Count)->create();
            return Response::json([
                'status' => true,
                'data' => $Berand
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
     *     path="/api/admin/Berand/store",
     *     summary="create a Berand",
     *     tags={"Berand"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name Berand",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="description Berand",
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
     *                      description="image Berand",
     *                      type="string",
     *                      format="binary"
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="Test Berand Created successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function store(Request $request)
    {
        try {
            $Validator = Validator::make($request->all(),$this->BerandRequest->storeRules());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $Berand = new Berand();
            $Berand->name = $request->name;
            $Berand->description = $request->description;
            $Berand->photo_path = $this->FileTransfer->moveFile($request,$this->path);
            $Berand->save();
            return Response::json([
                'status' => true,
                'data' => $Berand
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
     *     path="/api/admin/Berand/show",
     *     summary="Show a Berand",
     *     tags={"Berand"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Berand",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="show Berand successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function show(Request $request)
    {
        try {
            $Berand = Berand::find($request->id);
            return Response::json([
                'status' => true,
                'data' => $Berand
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
     *     path="/api/admin/Berand/edit",
     *     summary="Show a Berand",
     *     tags={"Berand"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Berand",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="show Berand successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function edit(Request $request)
    {
        try {
            $Berand = Berand::find($request->id);
            return Response::json([
                'status' => true,
                'data' => $Berand
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
     *     path="/api/admin/Berand/update",
     *     summary="create a Berand",
     *     tags={"Berand"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Berand",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name Berand",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="description Berand",
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
     *                      description="image Berand",
     *                      type="string",
     *                      format="binary"
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="Test Berand Created successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    public function update(Request $request)
    {
        try {
            
            $Validator = Validator::make($request->all(),$this->BerandRequest->updateRules($request->id));
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $Berand = Berand::find($request->id);
            $Berand->name = $request->name;
            $Berand->description = $request->description;
            $Berand->photo_path = $this->FileTransfer->updateFile($Berand ,$request,$this->path);
            $Berand->save();
            return Response::json([
                'status' => true,
                'data' => $Berand
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
     *     path="/api/admin/Berand/destroy",
     *     summary="Delete a Railcompanie",
     *     tags={"Berand"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Berand",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Berand destroy successfully"),
     * )
     */
    public function destroy(Request $request)
    {
        try {
            $Berand = Berand::findOrfail($request->id);
            $Berand->delete();
            return Response::json([
                'status' => true,
                'data' => $Berand
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
     *     path="/api/admin/Berand/restore",
     *     summary="Restore a Berand",
     *     tags={"Berand"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Berand",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Berand restore successfully"),
     * )
     */
    public function restore(Request $request)
    {
        try {
            $Berand = Berand::where('id', $request->id)->restore();
            return Response::json([
                'status' => true,
                'data' => $Berand
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
