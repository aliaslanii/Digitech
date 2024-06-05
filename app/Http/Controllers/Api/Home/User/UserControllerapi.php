<?php

namespace App\Http\Controllers\Api\Home\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserControllerapi extends Controller
{
    protected $UserRequest;
    public function __construct()
    {
        $this->UserRequest = new UserRequest();
    }
    /**
     * @OA\Put(
     *     path="/api/User/ChangePassword",
     *     summary="ChangePassword a User",
     *     security={{"bearerAuth":{}}},
     *     tags={"User"},
     *      @OA\Parameter(
     *         name="now_password",
     *         in="query",
     *         description="User Now password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *    @OA\Parameter(
     *         name="new_password",
     *         in="query",
     *         description="User New password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="new_password_confirmation",
     *         in="query",
     *         description="User New password confirmation",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="User update successfully"),
     * )
     */
    public function changePassword(Request $request)
    {
        try {
            $user = $request->user();
            $Validate = Validator::make($request->all(), $this->UserRequest->changePasswordRole());
            if ($Validate->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validate->errors()
                ], 403);
            }
            if (Hash::check($request->now_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
                $user->save();
                $user->tokens()->delete();
                return Response::json([
                    'status' => true,
                    'message' => 'changed Password successfully',
                ], 200);
            } else {
                return Response::json([
                    'status' => true,
                    'message' => 'The current password is not correct',
                ], 500);
            }
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Put(
     *    path="/api/User/PersonalInformation",
     *    summary="show a User",
     *    tags={"User"},
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(
     *         name="firstName",
     *         in="query",
     *         description="firstName Passenger",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Parameter(
     *         name="lastName",
     *         in="query",
     *         description="lastName Passenger",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),  
     *     @OA\Parameter(
     *         name="nationalcode",
     *         in="query",
     *         description="nationalcode Passenger",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Parameter(
     *         name="gender",
     *         in="query",
     *         description="gender Passenger (male,femail)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ), 
     *     @OA\Parameter(
     *         name="birthday",
     *         in="query",
     *         description="birthday Passenger",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ), 
     *     @OA\Response(response="200", description="Passenger detail successfully"),
     *     @OA\Response(response="409", description="TrainTicket Validate Error"), 
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */
    public function personalInformation(Request $request)
    {
        try {
            $Validate = Validator::make($request->all(), $this->UserRequest->personalInformationRole());
            if ($Validate->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validate->errors()
                ], 403);
            }
            $user = $request->user();
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->update();
            $Customer = $user->Customer;
            $Customer->birthday = Verta::parse($request->birthday)->datetime();
            $Customer->nationalcode = $request->nationalcode;
            $Customer->gender = $request->gender;
            $Customer->update();
            $User = [
                "firstName" => $user->firstName,
                "lastName" => $user->lastName,
                "mobile" => $user->mobile,
                "email" => $user->email ,
                "profile_photo_path" => $user->getprofile($user->profile_photo_path),
                "birthday" =>  $Customer->birthday ,
                "nationalcode" =>  $Customer->nationalcode ,
                "gender" =>  $Customer->gender ,
                "cardnumber" =>  $Customer->cardnumber ,
                "shabanumber" =>  $Customer->shabanumber ,
            ];
            return Response::json([
                'status' => true,
                'message' => 'User Created Personal Information Successfully',
                'data' => $User,
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
     *     path="/api/User/BankInformation",
     *     summary="Add bankInformation a User",
     *     security={{"bearerAuth":{}}},
     *     tags={"User"},
     *      @OA\Parameter(
     *         name="shabanumber",
     *         in="query",
     *         description="User shabanumber",
     *         @OA\Schema(type="string")
     *     ),
     *    @OA\Parameter(
     *         name="cardnumber",
     *         in="query",
     *         description="User cardnumber",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="add personalInformation successfully"),
     * )
     */
    public function bankInformation(Request $request)
    {
        try {
            $user = $request->user();
            $Validate = Validator::make($request->all(), $this->UserRequest->bankInformationRole());
            if ($Validate->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validate->errors()
                ], 403);
            }
            $Customer = $request->user()->Customer;
            $Customer->shabanumber = $request->shabanumber;
            $Customer->cardnumber = $request->cardnumber;
            $Customer->update();
            return Response::json([
                'status' => true,
                'message' => 'User Created Bank Information Successfully',
                'token' => $user
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
     *     path="/api/User/ChangeMobile",
     *     summary="Add mobile a User",
     *     security={{"bearerAuth":{}}},
     *     tags={"User"},
     *      @OA\Parameter(
     *         name="mobile",
     *         in="query",
     *         description="User mobile",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="add personalInformation successfully"),
     * )
     */
    public function changeMobile(Request $request)
    {
        try {
            $user = $request->user();
            $Validate = Validator::make($request->all(), $this->UserRequest->changeMobileRole());
            if ($Validate->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validate->errors()
                ], 403);
            }
            $user = $request->user();
            $user->mobile = $request->mobile;
            $user->update();
            return Response::json([
                'status' => true,
                'message' => 'User Change Mobile Successfully',
                'token' => $user
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
     *     path="/api/User/ChangeEmail",
     *     summary="Add email a User",
     *     security={{"bearerAuth":{}}},
     *     tags={"User"},
     *      @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="email mobile",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="add personalInformation successfully"),
     * )
     */
    public function changeEmail(Request $request)
    {
        try {
            $user = $request->user();
            $Validate = Validator::make($request->all(), $this->UserRequest->changeEmailRole());
            if ($Validate->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validate->errors()
                ], 403);
            }
            $user = $request->user();
            $user->email = $request->email;
            $user->update();
            return Response::json([
                'status' => true,
                'message' => 'User Change Email Successfully',
                'token' => $user
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
