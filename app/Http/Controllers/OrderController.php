<?php

namespace App\Http\Controllers;

use App\Http\Controllers\RootController;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends RootController
{
    public function placeOrder(Request $request)
    {

        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'pickup_address' => 'required',
            'delivery_address' => 'required',
        ]);

        $input['user_id'] = auth('sanctum')->user()->id;
        $role_id = auth('sanctum')->user()->role_id;

        if ($validator->fails()) {
            return $this->apiResponse([], $validator->errors(), 422);
        }

        if ($role_id == 1) {
            $order = Order::create($input);
        } else {
            return $this->apiResponse([], "only customer can create order", 403);
        }
        $response = array(
            "order" => $order,
        );
        return $this->apiResponse($response, "Order placed successfully", 200);
    }

    public function viewOrder(Request $request)
    {
        $role_id = auth('sanctum')->user()->role_id;

        if ($role_id == 1) {
            // TODO
            $order = Order::where('user_id', auth('sanctum')
                    ->user()->id)
                ->leftJoin('users', 'users.id', '=', 'orders.delivery_user_id')
                ->get();
        } else {
            return $this->apiResponse([], "only customer can view status", 403);
        }
        $response = array(
            "order" => $order,
        );
        return $this->apiResponse($response, "Order fetched successfully", 200);
    }

    public function orderList(Request $request)
    {
        $role_id = auth('sanctum')->user()->role_id;

        if ($role_id == 2) {
            $order = Order::where('status', 'pending')->with('User')->get();
        } else {
            return $this->apiResponse([], "only delivery user can view orders", 403);
        }
        $response = array(
            "order" => $order,
        );
        return $this->apiResponse($response, "Order fetched successfully", 200);
    }

    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required',
        ]);

        $role_id = auth('sanctum')->user()->role_id;

        if ($validator->fails()) {
            return $this->apiResponse([], $validator->errors(), 422);
        }
        
        if ($role_id == 2) {
            $order = Order::where('id', $request->id)->first();
            $order->status = $request->status;
            $order->delivery_user_id = auth('sanctum')->user()->id;
            if ($order->save()) {
                $response = array(
                    "order" => $order,
                );
                return $this->apiResponse($response, "Status Updated successfully", 200);
            }
        } else {
            return $this->apiResponse([], "only delivery user can update status", 403);
        }
    }
}
