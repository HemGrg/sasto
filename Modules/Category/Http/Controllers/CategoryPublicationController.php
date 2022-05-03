<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;

class CategoryPublicationController extends Controller
{
    public function store(Request $request, Category $category)
    {
        $category->update(['publish' => 1]);
        return response()->json([
            "status" => "true",
            "message" => "Category published!!"
          ], 200);
    }

    public function destroy(Request $request ,  Category $category)
    {
        $category->update(['publish' => 0]);
        return response()->json([
            "status" => "true",
            "message" => "Category unpublished!!"
          ], 200);
    }
}
