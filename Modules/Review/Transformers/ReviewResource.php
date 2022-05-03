<?php

namespace Modules\Review\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Front\Transformers\CustomerResource;
use Modules\Front\Transformers\ProductResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            // 'user' => CustomerResource::make($this->whenLoaded('user')),
            'user' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name
                ];
            }),
            'product' => $this->whenLoaded('product', function () {
                return [
                    'id' => $this->product->id,
                    'title' => $this->product->title
                ];
            }),
            // 'product' => ProductResource::make($this->whenLoaded('product')),
            'reviews' => $this->reviews,
            'rate' => $this->rate,
            'created_at' => $this->created_at
        ];
    }
}
