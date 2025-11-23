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
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'         => $this->name,
            'slug'          => $this->slug,
            'description'   => $this->description,
            'brand'         => $this->brand,
            'category_id'   => $this->category_id,
            'base_price'    => $this->base_price,
            'images'        => $this->images,
            'gender'        => $this->gender,
            'tags'          => $this->tags,
            'created_at'    => $this->created_at,

        ];
    }
}
