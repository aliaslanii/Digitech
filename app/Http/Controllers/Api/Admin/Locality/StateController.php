<?php

namespace App\Http\Controllers\Api\Admin\Locality;

use App\Http\Controllers\Controller;
use App\Http\Requests\StateRequest;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class StateController extends Controller
{
    protected $StateReauest;

    public function __construct()
    {
        $this->StateReauest = new StateRequest();
    }
    /**
     * @OA\Get(
     *     path="/api/admin/State/index",
     *     summary="index States",
     *     tags={"State"},
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
            $State = State::all();
            return Response::json([
                'status' => true,
                'data' => $State
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
     *     path="/api/admin/State/create",
     *     summary="create a State",
     *     tags={"State"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="Count",
     *         in="query",
     *         description="Count test State Data",
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
            $State = State::factory()->count($request->Count)->create();
            return Response::json([
                'status' => true,
                'data' => $State
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
     *     path="/api/admin/State/store",
     *     summary="create a State",
     *     tags={"State"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name State",
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
            $Validator = Validator::make($request->all(), $this->StateReauest->storeRules());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $State = new State();
            $State->name = $request->name;
            $State->save();
            return Response::json([
                'status' => true,
                'data' => $State
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
     *     path="/api/admin/State/show",
     *     summary="create a State",
     *     tags={"State"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id State",
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
            $State = State::find($request->id);
            return Response::json([
                'status' => true,
                'data' => $State
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
     *     path="/api/admin/State/edit",
     *     summary="create a State",
     *     tags={"State"},
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id State",
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
            $State = State::find($request->id);
            return Response::json([
                'status' => true,
                'data' => $State
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
     *     path="/api/admin/State/update",
     *     summary="create a State",
     *     tags={"State"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id State",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name State",
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
            $Validator = Validator::make($request->all(), $this->StateReauest->updateRoles($request->id));
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $State = State::find($request->id);
            $State->name = $request->name;
            $State->save();
            return Response::json([
                'status' => true,
                'data' => $State
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
     *     path="/api/admin/State/destroy",
     *     summary="Delete a State",
     *     tags={"State"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id State",
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
            $State = State::findOrfail($request->id);
            $State->delete();
            return Response::json([
                'status' => true,
                'data' => $State
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
     *     path="/api/admin/State/restore",
     *     summary="Restore a State",
     *     tags={"State"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id State",
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
            $State = State::where('id', $request->id)->restore();
            return Response::json([
                'status' => true,
                'data' => $State
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
