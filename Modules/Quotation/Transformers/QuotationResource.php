<?php

namespace Modules\Quotation\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class QuotationResource extends JsonResource
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
            'user_id' => $this->user_id,
            'purchase' => $this->purchase,
            'category_id' => $this->category_id,
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'specifications' => $this->specifications,
            'image1' => $this->image1,
            'image2' => $this->image2,
            'image3' => $this->image3,
            'image1_url' => asset('storage/' . $this->image1),
            'image2_url' => asset('storage/' . $this->image2),
            'image3_url' => asset('storage/' . $this->image3),
            'name' => $this->name,
            'email' => $this->email,
            'mobile_num' => $this->mobile_num,
            'ship_to' => $this->ship_to,
            'expected_price' => $this->expected_price,
            'expected_del_time' => $this->expected_del_time,
            'other_contact' => $this->other_contact,
            'link' => $this->link,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'replies_count' =>  $this->when(isset($this->replies_count), $this->replies_count),
            'replies' => $this->whenLoaded('replies')
        ];
    }
}
