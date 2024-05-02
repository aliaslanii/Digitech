<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $AuthRequest;

    public function __construct() {
        $this->AuthRequest = new AuthRequest();
    }
    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     summary="Register a new user",
     *     tags={"Auth"},
     *     @OA\Parameter(
     *         name="firstName",
     *         in="query",
     *         description="User firstName",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Parameter(
     *         name="lastName",
     *         in="query",
     *         description="User lastName",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),  
     *     @OA\Parameter(
     *         name="mobile",
     *         in="query",
     *         description="User mobile",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User email",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password_confirmation",
     *         in="query",
     *         description="User password confirmation",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="User registered successfully"),
     *     @OA\Response(response="403", description="Validation errors")
     * )
     */
    
    public function userRegister(Request $request)
    {
        try {
            $Validate = Validator::make($request->all(), $this->AuthRequest->registerRole());
            if ($Validate->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validate->errors()
                ], 403);
            }
            $user = User::create([
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $wallet = new Wallet();
            $wallet->user_id = $user->id;
            $wallet->inventory = 0;
            $wallet->status = true;
            $wallet->save();
            return Response::json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
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
     *     path="/api/auth/login",
     *     summary="Login user",
     *     tags={"Auth"},
     *     @OA\Parameter(
     *         name="mobile",
     *         in="query",
     *         description="User Mobile",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User's password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="User login successfully"),
     *     @OA\Response(response="403", description="Validation errors"),
     *     @OA\Response(response="401", description="Login information is incorrect")
     * )
     */
    public function userLogin(Request $request)
    {
        try {
            
            $Validate = Validator::make($request->all(), $this->AuthRequest->loginRole());
            if ($Validate->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validate->errors()
                ], 403);
            }
            if (!Auth::attempt($request->only(['mobile', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'mobile & Password does not match with our record.',
                ], 401);
            }
            $user = User::where('mobile', $request->mobile)->first();
            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
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
     *     path="/api/auth/detail",
     *     summary="detail user login",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="User detail successfully"),
     * )
     */
    public function detail()
    {
        try {
            return Response::json([
                'status' => true,
                'message' => 'Done',
                'data' => Auth::user()
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
     *     path="/api/auth/logout",
     *     summary="user logout",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="User Logout Successfully"),
     * )
     */
    public function userLogout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return Response::json([
                'status' => true,
                'message' => 'Logout Successfully'
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
