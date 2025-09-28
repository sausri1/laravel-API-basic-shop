<?php

namespace App\Http\Resources;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $order_items = Order::find($this->id)->orderItems;
        $array_products = [];
        foreach ($order_items as $order_item) {
            // пройтись по каждому продукту, который относится к order
            array_push($array_products, $order_item->product->id);
        }
        return [
            'id' => $this->id,
            'products' => $array_products,
            'order_price' => $this->order_price
        ];
    }
}
