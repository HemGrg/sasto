<?php

namespace Modules\Review\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product;
use App\Models\User;

class Review extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Usage: Review::canReview($product_id, $customer_id);
    public static function canReview($productId, $customerId)
    {
        // Check if already have rated and reviewed
        $review = Review::where('product_id', $productId)
            ->where('customer_id', $customerId)
            ->first();

        if ($review) {
            return false;
        }

        // Check if has purchased product
        $hasPurchasedProduct = \Modules\Order\Entities\Order::whereHas('orderLists', function ($query) use ($productId) {
            $query->where('product_id', $productId);
        })
            ->where('user_id', $customerId)->count();

        if ($hasPurchasedProduct) {
            return true;
        }
        
        return false;
    }
}
