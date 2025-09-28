<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        return OrderResource::collection(User::find(Auth::user()->id)->orders);
    }

    public function store(StoreOrderRequest $request)
    {
        //Находим пользователя, который делает заказ и его корзину
        $user = Auth::user();
        $carts = User::find($user->id)->carts;
        if ($carts->count() === 0) {
            return response()->json([
                "code" => 422,
                "message" => "Cart is empty"
            ], 422);
        } else {

            // create new "order" and fill in the data
            $order = new Order();
            $order->user_id = $user->id;
            foreach ($carts as $cart) {
                $order->order_price += Cart::find($cart->id)->product->price;
            }
            $order->save();

            // creating entities to associate an order with products
            foreach ($carts as $cart) {
                $order_item = new OrderItem();
                $order_item->order_id = $order->id;
                $order_item->product_id = $cart->product_id;
                $order_item->save();
            }
            Cart::query()->where("user_id", $user->id)->delete();
            return response()->json([
                "order_id" => $order->id,
                "message" => "Order is processed"
            ], 201);
        }
    }

    public function show(string $id)
    {
        return response()->json(["message" => "Not available"], 405);
    }

    public function update(Request $request, string $id)
    {
        return response()->json(["message" => "Not available"], 405);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json(["message" => "Not available"],405);
    }
}
