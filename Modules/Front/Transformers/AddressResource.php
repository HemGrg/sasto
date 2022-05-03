<?php

namespace Modules\Front\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'full_name' => $this->full_name,
            'company_name' => $this->company_name,
            'vat' => $this->vat,
            'country' => $this->country,
            'city' => $this->city,
            'street_address' => $this->street_address,
            'nearest_landmark' => $this->nearest_landmark,
            'phone' => $this->phone,
            'email' => $this->email,
        ];
    }
}
