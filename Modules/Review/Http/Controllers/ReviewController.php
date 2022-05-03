<?php

namespace Modules\Review\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Order\Entities\Order;
use Validator;
use Modules\Review\Entities\Review;
use Modules\Review\Transformers\ReviewCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function canReviewProduct($productId, $customerId)
    {
        return response()->json(Review::canReview($productId, $customerId), 200);
    }

    public function index()
    {
        $reviews = Review::get();
        return view('review::index', compact('reviews'));
    }

    public function productReview($productId)
    {
        $reviews = Review::with('user:id,name', 'product:id,title')
            ->where('product_id', $productId)
            ->latest()
            ->get();

        return new ReviewCollection($reviews);
    }

    public function createReview(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'rate'             => 'required|numeric',
                'reviews'          => 'nullable',
                'customer_id'       => 'required|numeric|exists:users,id',
                'product_id'       => 'required|numeric|exists:products,id',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()], 422);
            }
            if (!Review::canReview($request->product_id, $request->customer_id)) {
                return response()->json(['status' => 'unsuccessful', 'data' => 'Sorry you cannot review this product.']);
            } else {
                Review::create([
                    'name' => $request->name,
                    'reviews' => $request->reviews,
                    'customer_id' => $request->customer_id,
                    'product_id' => $request->product_id,
                    'rate' => $request->rate,
                ]);
            }
        } catch (\Exception $ex) {
            Log::error('Review Created', [
                'status' => '500',
                'message' => serialize($ex->getMessage())
            ]);
            return response()->json([
                'status' => '500',
                'message' => 'Something  went wrong'
            ], 500);
        }
    }
}
