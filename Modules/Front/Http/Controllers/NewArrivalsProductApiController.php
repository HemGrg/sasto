<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Front\Transformers\ProductResource;
use Modules\Product\Entities\Product;
use Modules\Subcategory\Entities\Subcategory;

class NewArrivalsProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['productCategory', 'ranges', 'user'])
            ->productsfromapprovedvendors()
            ->where('is_new_arrival', true)
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

    // New Arrivals
    public function getNewArrivals()
    {
        $products = Product::with(['ranges','user'])
            ->productsfromapprovedvendors()
            ->where('is_new_arrival', true)
            ->active()
            ->orderBy('created_at', 'DESC')
            ->take(4)
            ->get();

        return ProductResource::collection($products)->hide([
            'highlight',
            'description',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'meta_keyphrase',
        ]);
    }
}
