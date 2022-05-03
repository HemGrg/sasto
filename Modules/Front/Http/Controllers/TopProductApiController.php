<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Front\Transformers\ProductResource;
use Modules\Product\Entities\Product;

class TopProductApiController extends Controller
{
    public function index()
    {
        $products = Product::with(['productCategory', 'ranges', 'user'])
            ->productsfromapprovedvendors()
            ->where('is_top', true)
            ->active()
            ->orderBy('id', 'DESC')->cursorPaginate(request('per_page') ?? 18)->withQueryString();

        return ProductResource::collection($products)->hide([
            'highlight',
            'description',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'meta_keyphrase',
        ]);
    }

    // Top Products for homepage
    public function getTopProducts()
    {
        $products = Product::with(['ranges','user'])
            ->productsfromapprovedvendors()
            ->where('is_top', true)
            ->active()
            ->orderBy('created_at', 'DESC')
            ->take(4)->get();

        return ProductResource::collection($products->shuffle()->all())->hide([
            'highlight',
            'description',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'meta_keyphrase',
        ]);
    }
}
