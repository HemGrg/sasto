<?php

namespace Modules\Deal\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Deal\Entities\Deal;
use Modules\Deal\Transformers\DealCollection;
use Modules\Deal\Transformers\DealResource;
use Modules\Product\Entities\Product;

class DealApiController extends Controller
{
    public function customerSearch()
    {
        // TODO::must be a vendor
        $users = User::where('name', 'like', request('q') . '%')
            // ->orWhere('email', 'like', request('q') . '%')
            ->select('id', 'name', 'email')
            ->whereHas(
                'roles',
                function ($q) {
                    $q->where('slug', 'customer');
                }
            )
            ->get();

        return response()->json(['data' => $users]);
    }

    public function productSearch()
    {
        // TODO::must be a vendor
        $products = Product::where('user_id', Auth::id())
            ->select('id', 'title')->get()->map(function ($product) {
                $product['image_url'] = 'https://dummyimage.com/50/5b43c4/ffffff';
            });
        return response()->json(['data' => $products]);
    }

    public function index()
    {
        $deals = Deal::with(['dealProducts', 'vendor', 'vendorShop'])->where('customer_id', Auth::id())
            ->when(request()->filled('status'), function ($query) {
                switch (request('status')) {
                    case 'available':
                        return $query->where('expire_at', '>', now())->whereNull('completed_at');
                        break;
                    case 'completed':
                        return $query->whereNotNull('completed_at');
                        break;
                    case 'expired':
                        return $query->where('expire_at', '<', now());
                        break;
                    default:
                        break;
                }
            })
            ->latest()
            ->paginate();
            
        return new DealCollection($deals);
    }

    public function show(Deal $deal)
    {
        abort_unless(Auth::id() == $deal->vendor_user_id || Auth::id() == $deal->customer_id, 403);

        if (!$deal->isAvailable()) {
            return response()->json(['message' => 'Deal is not available'], 404);
        }

        $deal->load(['dealProducts.product:id,title,image', 'vendorShop']);

        return new DealResource($deal);
    }
}
