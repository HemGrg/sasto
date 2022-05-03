<?php

namespace Modules\Front\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone_num' => $this->phone_num,
            'birthday' => $this->birthday,
            'gender' => $this->gender,
            'image_url' => $this->imageUrl(),
            'image_url_thumbnail' => $this->imageUrl('thumbnail'),
            'address' => $this->address(),
        ];
    }
}
