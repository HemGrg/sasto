<?php

namespace Modules\Deal\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Front\Transformers\CustomerResource;
use Modules\Front\Transformers\ProductResource;
use Modules\Front\Transformers\VendorResource;

class DealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'vendor_user_id' => $this->vendor_user_id,
            'expire_at' => $this->expire_at,
            'completed_at' => $this->completed_at,
            'subtotal_price' =>  $this->subTotalPrice(),
            'shipping_charge' =>  $this->totalShippingCharge(),
            'total_price' => $this->totalPrice(),
            'is_available' => $this->isAvailable(),
            'deal_products' => $this->formattedDealProducts(),
            'vendor' => CustomerResource::make($this->whenLoaded('vendor')), // the vendor user
            'vendor_shop' => VendorResource::make($this->whenLoaded('vendorShop')),
            'note' => $this->note
        ];
    }

    protected function formattedDealProducts()
    {
        return $this->dealProducts->map(function ($dealProduct) {
            return [
                'id' => $dealProduct->id,
                'product_id' => $dealProduct->product_id,
                'product_qty' => (int) $dealProduct->product_qty,
                'unit_price' => (int) $dealProduct->unit_price,
                'subtotal_price' =>  $dealProduct->subTotalPrice(),
                'shipping_charge' =>  $dealProduct->shipping_charge ?? 0,
                'total_price' =>  $dealProduct->totalPrice(),
                'title' => $dealProduct->product ? $dealProduct->product->title : 'N/A',
                'product' => $dealProduct->product ? ProductResource::make($dealProduct->product) : [],
            ];
        });
    }
}
