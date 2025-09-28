<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CartResource::collection(User::find(Auth::user()->id)->carts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request, Product $product)
    {
        $cart = new Cart();
        $cart->product_id = $product->id;
        $cart->user_id = Auth::user()->id;
        $cart->save();
        return response()->json(["message" => "Product add to cart"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart) {
        return response()->json(["message" => "Not available"], 405);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Cart $cart) {
        return response()->json(["message" => "Not available"], 405);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        if(!Gate::forUser(Auth::user())->allows('cart-delete', $cart)){
            return response()->json(["message" => "Forbidden for you"], 403);
        }
        $cart->delete();
        return response()->json(["message" => "Cart delete"]);
    }
}
