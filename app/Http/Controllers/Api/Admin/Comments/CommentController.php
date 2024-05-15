<?php

namespace App\Http\Controllers\Api\Admin\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    protected $CommentReauest;

    public function __construct()
    {
        $this->CommentReauest = new CommentRequest();
    }
    /**
     * @OA\Get(
     *     path="/api/admin/Comment/index",
     *     summary="index Comments",
     *     tags={"Comment"},
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
            $Comment = Comment::all();
            return Response::json([
                'status' => true,
                'data' => $Comment
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
     *     path="/api/admin/Comment/create",
     *     summary="create a Comment",
     *     tags={"Comment"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="Count",
     *         in="query",
     *         description="Count test Comment Data",
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
            $Comment = Comment::factory()->count($request->Count)->create();
            return Response::json([
                'status' => true,
                'data' => $Comment
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
     *     path="/api/admin/Comment/show",
     *     summary="create a Comment",
     *     tags={"Comment"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Product",
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
            $Product = Product::find($request->id);
            $Comment = $Product->Comment;
            return Response::json([
                'status' => true,
                'data' => $Comment
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
     *     path="/api/admin/Comment/update",
     *     summary="create a Comment",
     *     tags={"Comment"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Comment",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="title Comment",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="body",
     *                     type="string",
     *                     format="textarea",
     *                     description="body comment"
     *                 ),
     *                 @OA\Property(
     *                   property="is_accept",
     *                   type="string",
     *                   enum={"0","1"}
     *                 ),
     *                 @OA\Property(
     *                   property="rating",
     *                   type="string",
     *                   enum={"1","2","3","4","5"}
     *                 ),
     *                 required={"description"}
     *             
     *              ),
     *         )
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
            $Validator = Validator::make($request->all(), $this->CommentReauest->rules());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $Comment = Comment::find($request->id);
            $Comment->title = $request->title;
            $Comment->body = $request->body;
            $Comment->rating = $request->rating;
            $Comment->is_accept = $request->rating;
            $Comment->save();
            return Response::json([
                'status' => true,
                'data' => $Comment
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
     *     path="/api/admin/Comment/destroy",
     *     summary="Delete a Comment",
     *     tags={"Comment"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Comment",
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
            $Comment = Comment::findOrfail($request->id);
            $Comment->delete();
            return Response::json([
                'status' => true,
                'data' => $Comment
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
     *     path="/api/admin/Comment/restore",
     *     summary="Restore a Comment",
     *     tags={"Comment"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Comment",
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
            $Comment = Comment::where('id', $request->id)->restore();
            return Response::json([
                'status' => true,
                'data' => $Comment
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
     *     path="/api/admin/Comment/accept",
     *     summary="Restore a Comment",
     *     tags={"Comment"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Comment",
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
    public function accept(Request $request)
    {
        try {
            $Comment = Comment::find($request->id);
            $Comment->is_accept = 1;
            $Comment->save();
            return Response::json([
                'status' => true,
                'data' => $Comment
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
