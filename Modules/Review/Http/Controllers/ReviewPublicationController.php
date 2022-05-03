<?php

namespace Modules\Review\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Review\Entities\Review;

class ReviewPublicationController extends Controller
{
   
  
    public function store(Request $request ,  Review $review)
    {
        $review->update(['status' => 'publish']);
        return response()->json([
            "status" => "true",
            "message" => "Review published!!"
          ], 200);
    }

   
    public function destroy(Request $request ,  Review $review)
    {
        $review->update(['status' => 'unpublish']);
        return response()->json([
            "status" => "true",
            "message" => "Review unpublished!!"
          ], 200);
    }
}
