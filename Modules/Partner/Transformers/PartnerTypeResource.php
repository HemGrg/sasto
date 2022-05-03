<?php

namespace Modules\Partner\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PartnerTypeResource extends JsonResource
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
            'partners' => PartnerResource::collection($this->whenLoaded('partners')),
        ];
    }
}
