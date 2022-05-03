<?php

namespace Modules\Subcategory\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Subcategory\Entities\Subcategory;

class SubcategoryPublicationController extends Controller
{
    public function store(Request $request,  Subcategory $subcategory)
    {
        $subcategory->update(['publish' => 1]);
        return response()->json([
            "status" => "true",
            "message" => "Subcategory published!!"
        ], 200);
    }

    public function destroy(Request $request,  Subcategory $subcategory)
    {
        $subcategory->update(['publish' => 0]);
        return response()->json([
            "status" => "true",
            "message" => "Subcategory unpublished!!"
        ], 200);
    }
}
