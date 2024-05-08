<?php

namespace App\Http\Controllers\Api\Admin\Locality;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityRequest;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    protected $CityReauest;

    public function __construct()
    {
        $this->CityReauest = new CityRequest();
    }
    /**
     * @OA\Get(
     *     path="/api/admin/City/index",
     *     summary="index Citys",
     *     tags={"City"},
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
            $City = City::all();
            return Response::json([
                'status' => true,
                'data' => $City
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
     *     path="/api/admin/City/create",
     *     summary="create a City",
     *     tags={"City"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="Count",
     *         in="query",
     *         description="Count test City Data",
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
            $City = City::factory()->count($request->Count)->create();
            return Response::json([
                'status' => true,
                'data' => $City
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
     *     path="/api/admin/City/store",
     *     summary="create a City",
     *     tags={"City"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name City",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="state",
     *         in="query",
     *         description="state",
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
            $Validator = Validator::make($request->all(), $this->CityReauest->storeRules());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $City = new City();
            $City->name = $request->name;
            $City->state_id = $request->state;
            $City->save();
            return Response::json([
                'status' => true,
                'data' => $City
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
     *     path="/api/admin/City/show",
     *     summary="create a City",
     *     tags={"City"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id City",
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
            $City = City::find($request->id);
            return Response::json([
                'status' => true,
                'data' => $City
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
     *     path="/api/admin/City/edit",
     *     summary="create a City",
     *     tags={"City"},
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id City",
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
            $City = City::find($request->id);
            return Response::json([
                'status' => true,
                'data' => $City
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
     *     path="/api/admin/City/update",
     *     summary="create a City",
     *     tags={"City"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id City",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name City",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="state",
     *         in="query",
     *         description="state",
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
            $Validator = Validator::make($request->all(), $this->CityReauest->updateRoles($request->id));
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $City = City::find($request->id);
            $City->name = $request->name;
            $City->state_id = $request->state;
            $City->save();
            return Response::json([
                'status' => true,
                'data' => $City
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
     *     path="/api/admin/City/destroy",
     *     summary="Delete a City",
     *     tags={"City"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id City",
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
            $City = City::findOrfail($request->id);
            $City->delete();
            return Response::json([
                'status' => true,
                'data' => $City
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
     *     path="/api/admin/City/restore",
     *     summary="Restore a City",
     *     tags={"City"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id City",
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
            $City = City::where('id', $request->id)->restore();
            return Response::json([
                'status' => true,
                'data' => $City
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
