<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,

            'quantity' => $this->quantity,

            'variant' => [
                'id' => $this->variant->id,
                'price' => $this->variant->price,
                'sku' => $this->variant->sku ?? null,

                'product' => [
                    'id' => $this->variant->product->id,
                    'title' => $this->variant->product->title,
                    'slug' => $this->variant->product->slug,
                ],
            ],
        ];
    }
}
