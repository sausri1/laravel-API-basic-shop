<?php

namespace App\Http\Resources;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = Cart::find($this->id)->product;
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price
        ];
    }
}
