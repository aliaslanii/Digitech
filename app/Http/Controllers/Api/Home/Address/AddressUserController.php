<?php

namespace App\Http\Controllers\Api\Home\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressCustomerRequest;
use App\Models\AddressCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AddressUserController extends Controller
{
    
    protected $AddressCustomerRequest;

    public function __construct()
    {
        $this->AddressCustomerRequest = new AddressCustomerRequest();
    }
    /**
     * @OA\Get(
     *     path="/api/User/Addres/index",
     *     summary="Address User",
     *     security={{"bearerAuth":{}}},
     *     tags={"User Address"},
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
            
            $AddressCustomer = Auth::user()->AddressCustomer;
            return Response::json([
                'status' => true,
                'data' => $AddressCustomer
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
     *     path="/api/User/Addres/create",
     *     summary="create a Addres User",
     *     tags={"User Address"},
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
            $AddressCustomer = AddressCustomer::factory()->count($request->Count)->create();
            return Response::json([
                'status' => true,
                'data' => $AddressCustomer
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
     *     path="/api/User/Addres/store",
     *     summary="insert a Addres User",
     *     tags={"User Address"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="name Receiver Addres",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="mobile",
     *         in="query",
     *         description="mobile Receiver Addres",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="address",
     *         in="query",
     *         description="Addres",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="states_id",
     *         in="query",
     *         description="id states Addres",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ), 
     *     @OA\Parameter(
     *         name="cities_id",
     *         in="query",
     *         description="id city Addres",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="zipCode",
     *         in="query",
     *         description="zipCode Addres",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="plate",
     *         in="query",
     *         description="plate Addres",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="unit",
     *         in="query",
     *         description="unit Addres",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="id User Addres",
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
    public function store(Request $request)
    {
        try {
            $Validator = Validator::make($request->all(),$this->AddressCustomerRequest->rules());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $AddressCustomer = new AddressCustomer();
            $AddressCustomer->name = $request->name;
            $AddressCustomer->mobile = $request->mobile;
            $AddressCustomer->address = $request->address;
            $AddressCustomer->states_id = $request->states_id;
            $AddressCustomer->cities_id = $request->cities_id;
            $AddressCustomer->zipCode = $request->zipCode;
            $AddressCustomer->plate = $request->plate;
            $AddressCustomer->unit = $request->unit;
            $AddressCustomer->user_id = Auth::user()->id;
            $AddressCustomer->save();

            return Response::json([
                'status' => true,
                'data' => $AddressCustomer
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
     *     path="/api/User/Addres/edit",
     *     summary="create a Addres User",
     *     tags={"User Address"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Address Customer Data",
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
     * )
     */
    public function edit(Request $request)
    {
        try {
            $AddressCustomer = AddressCustomer::findOrFail($request->id);
            if ($AddressCustomer->user_id == Auth::user()->id) {
                $Response = [];
                $ProductData = [
                    "name" => $AddressCustomer->name,
                    "mobile" => $AddressCustomer->mobile,
                    "address" => $AddressCustomer->address,
                    "states_id" => $AddressCustomer->states_id,
                    "cities_id" => $AddressCustomer->cities_id,
                    "zipCode" => $AddressCustomer->zipCode,
                    "plate" => $AddressCustomer->plate,
                    "unit" => $AddressCustomer->unit,
                ];
                $Response[] = $ProductData;
                return Response::json([
                    'status' => true,
                    'data' => $Response
                ], 200);
            }
            return Response::json([
                'status' => false,
                'message' => "nou found"
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/User/Addres/update",
     *     summary="update a Addres User",
     *     tags={"User Address"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Address Customer Data",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="name Receiver Addres",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="mobile",
     *         in="query",
     *         description="mobile Receiver Addres",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="address",
     *         in="query",
     *         description="Addres",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="states_id",
     *         in="query",
     *         description="id states Addres",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ), 
     *     @OA\Parameter(
     *         name="cities_id",
     *         in="query",
     *         description="id city Addres",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="zipCode",
     *         in="query",
     *         description="zipCode Addres",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="plate",
     *         in="query",
     *         description="plate Addres",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="unit",
     *         in="query",
     *         description="unit Addres",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="id User Addres",
     *         required=true,
     *         @OA\Schema(type="integer")
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
            $Validator = Validator::make($request->all(),$this->AddressCustomerRequest->rules());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $AddressCustomer = AddressCustomer::findorfail($request->id);
            if ($AddressCustomer->user_id == Auth::user()->id) {
                $AddressCustomer->name = $request->name;
                $AddressCustomer->mobile = $request->mobile;
                $AddressCustomer->address = $request->address;
                $AddressCustomer->states_id = $request->states_id;
                $AddressCustomer->cities_id = $request->cities_id;
                $AddressCustomer->zipCode = $request->zipCode;
                $AddressCustomer->plate = $request->plate;
                $AddressCustomer->unit = $request->unit;
                $AddressCustomer->user_id = Auth::user()->id;
                return Response::json([
                    'status' => true,
                    'data' => $AddressCustomer
                ], 200);
            }
            return Response::json([
                'status' => false,
                'message' => "nou found"
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
     *     path="/api/User/Addres/destroy",
     *     summary="Delete a Addres ",
     *     tags={"User Address"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Addres",
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
            $AddressCustomer = AddressCustomer::findOrFail($request->id);
            if ($AddressCustomer->user_id == Auth::user()->id) 
            {
                $AddressCustomer->delete();
                return Response::json([
                    'status' => true,
                    'message' => 'done'
                ], 200);
            }
            return Response::json([
                'status' => false,
                'message' => "nou found"
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}