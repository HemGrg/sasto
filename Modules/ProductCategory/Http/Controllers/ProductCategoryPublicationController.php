<?php

namespace Modules\ProductCategory\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ProductCategory\Entities\ProductCategory;

class ProductCategoryPublicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(ProductCategory $productCategory)
    {
        $productCategory->update(['publish' => true]);

        return response()->json([
            "status" => "success",
            "message" => "Published successfully!!"
        ], 200);
    }

    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->update(['publish' => false]);

        return response()->json([
            "status" => "success",
            "message" => "Unpublished successfully!!"
        ], 200);
    }
}
