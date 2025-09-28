<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        if(!Gate::allows('admin-action', Auth::user())){
            return response()->json(["message" => "Forbidden for you"], 403);
        }
        $product = Product::create($request->validated());
        return response()->json(["id" => $product->id, "message" => "Product added"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        if(!Gate::allows('admin-action', Auth::user())){
            return response()->json(["message" => "Forbidden for you"], 403);
        }
        $product->update($request->validated());
        return response()->json([
            "id" => $product->id,
            "name" => $product->name,
            "description" => $product->description,
            "price" => $product->price,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if(!Gate::allows('admin-action', Auth::user())){
            return response()->json(["message" => "Forbidden for you"], 403);
        }
        $product->delete();
        return response()->json(["message" => "Product removed"]);
    }
}
