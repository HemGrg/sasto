<?php

namespace Modules\Front\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
{
    protected $withoutFields = [];

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return $this->filterFields([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'category' => $this->category,
            'business_type' => $this->business_type,
            'plan' => $this->plan,
            'shop_name' => $this->shop_name,
            'company_name' => $this->company_name,
            'image' => $this->image,
            'image_url' => $this->imageUrl(),
            'image_url_thumbnail' => $this->imageUrl('thumbnail'),
            'description' => $this->description,
            'created_at' => $this->created_at,
            'user' => CustomerResource::make($this->whenLoaded('user')),
            'shipping_info' => $this->shipping_info
        ]);
    }

    
    public static function collection($resource)
    {
        return tap(new VendorCollection($resource), function ($collection) {
            $collection->collects = __CLASS__;
        });
    }

    // Set the keys that are supposed to be filtered out
    public function hide(array $fields)
    {
        $this->withoutFields = $fields;
        return $this;
    }

    // Remove the filtered keys
    protected function filterFields($array)
    {
        return collect($array)->forget($this->withoutFields)->toArray();
    }
}
