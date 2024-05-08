<?php

namespace App\Http\Controllers\Api\Home\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // try {
        //     $TrainTickets = TrainTicket::where('origin', $request->origin)
        //         ->where('destination', $request->destination)
        //         ->where('arrivalTime', 'like', '%' . $request->arrivalDate . '%')
        //         ->get();
        //     $Response = [];
        //     foreach ($TrainTickets as $TrainTicket) {
        //         $TrainTicketData = [
        //             "adultPrice" => number_format($TrainTicket->adultPrice),
        //             "DateTime" => verta($request->arrivalTime)->format('l، d F'),
        //             "arrivalTime" => $TrainTicket->arrivalTime,
        //             "arrivalDate" => verta($TrainTicket->arrivalDate)->format('m/d - l'),
        //             "departureTime" => $TrainTicket->departureTime, 
        //             "departureDate" => verta($TrainTicket->departureDate)->format('m/d - l'),
        //             "capacity" => $TrainTicket->capacity,
        //             "trainnumber" => $TrainTicket->trainnumber,
        //             "origin" => $TrainTicket->cityorigin->name,
        //             "destination" => $TrainTicket->citydestination->name,
        //             'Railcompanie' => $TrainTicket->Railcompanie->name,
        //             'Railcompanie-photo' => $TrainTicket->Railcompanie->profile_photo_path,
        //             'type' => $TrainTicket->type,
        //             'isCompleted' => $TrainTicket->isCompleted,
        //         ];
        //         $Response[] = $TrainTicketData;
        //     }
        //     return Response::json([
        //         'data' => $Response,
        //     ], 200);
        // } catch (\Throwable $th) {
        //     return Response::json([
        //         'status' => false,
        //         'message' => $th->getMessage()
        //     ], 500);
        // }
    }
}
