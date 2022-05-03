<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;

class ProductPublicationController extends Controller
{
    use AuthorizesRequests;
    
    public function store(Request $request,  Product $product)
    {
        // $this->authorize('manageProducts');

        $product->update(['status' => 1]);
        return response()->json([
            "status" => "true",
            "message" => "Product Activated!!"
        ], 200);
    }


    public function destroy(Request $request,  Product $product)
    {
        $product->update(['status' => 0]);
        return response()->json([
            "status" => "true",
            "message" => "Product Deactivated!!"
        ], 200);
    }
}
