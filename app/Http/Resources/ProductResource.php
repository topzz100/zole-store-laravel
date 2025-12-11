<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    // public function toArray(Request $request): array
    // {
    //     return parent::toArray($request);
    // }
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'slug'          => $this->slug,
            'description'   => $this->description,
            'category_id'   => $this->category_id,
            'brand'         => $this->brand,
            'base_price'         => $this->base_price,
            'tags'          => $this->tags,
            'images'        => $this->images,
            'gender'        => $this->gender,
            'is_sold'       => $this->is_sold,
            'created_at'    => $this->created_at,
            // Eager load and format the category relationship
            'category'      => new CategoryResource($this->whenLoaded('category')),
            // Eager load and format the variants relationship
            'variants'      => ProductVariantResource::collection($this->whenLoaded('variants')),
        ];
    }
}
