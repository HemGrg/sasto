<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Product\Entities\ProductImage;

class ProductImageApiController extends Controller
{
    public function index($product_id)
    {
        $productImages = ProductImage::where('product_id', $product_id)->get();
        return $productImages->map(function($productImage) {
            return [
                'id' => $productImage->id,
                'product_id' => $productImage->product_id,
                'image_url' => $productImage->imageUrl(),
            ];
        });
    }
}
