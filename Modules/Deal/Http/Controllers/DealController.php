<?php

namespace Modules\Deal\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Deal\Entities\Deal;
use Modules\Deal\Entities\DealProduct;
use Auth;
use App\Models\User;

class DealController extends Controller
{
    public function index()
    {
        $deals = Deal::with(['deal_products.product_info', 'user', 'vendor', 'vendorShop'])
            ->when(auth()->user()->hasRole('vendor'), function ($query) {
                return $query->where('vendor_user_id', auth()->id());
            })
            ->latest()
            ->get();

        return view('deal::index', compact('deals'));
    }

    public function create()
    {
        $products = Product::where('user_id', Auth::id())->select('id', 'title','image')->get()->map(function ($product) {
            $product['image_url'] = $product->imageUrl();
            return $product;
        });

        $customer = null;
        if(request()->filled('customer')) {
            $customer = User::Where('id', request('customer'))
            ->select('id', 'name', 'email')
            ->whereHas(
                'roles',
                function ($q) {
                    $q->where('slug', 'customer');
                }
            )
            ->first();
        }

        return view('deal::create')->with(compact('products', 'customer'));
    }

    public function store(Request $request)
    {
        try {
            $deals = $request->all();
            $deals['vendor_user_id'] = $request->vendor_id;
            $data = Deal::create($deals);
            foreach ($deals['invoice_products'] as $key => $val) {
                if (!empty($val)) {
                    $deal = new DealProduct();
                    $deal->deal_id = $data->id;
                    $deal->product_id = $val['product_id']['id'];
                    $deal->product_qty = $val['product_qty'];
                    $deal->unit_price = $val['unit_price'];
                    $deal->shipping_charge = $val['shipping_charge'];
                    $deal->save();
                }
            }
            return response()->json(['status' => 'successful', 'message' => 'Deal created successfully.', 'data' => $deal]);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function show(Deal $deal)
    {
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin') || auth()->id() == $deal->vendor_user_id, 403);

        $deal->load(['dealProducts.product', 'user', 'vendor']);
        return view('deal::show', compact('deal'));
    }

    public function edit($id)
    {
        $products = Product::where('user_id', Auth::id())->select('id', 'title','image')->get()->map(function ($product) {
            $product['image_url'] = $product->imageUrl();
            return $product;
        });;
        $customers = User::select('id', 'name', 'email')
            ->whereHas(
                'roles',
                function ($q) {
                    $q->where('slug', 'customer');
                }
            )
            ->get();
        $deal = Deal::where('id', $id)->with('deal_products')->first();
        return view('deal::update', compact('deal', 'customers', 'products'));
    }

    public function editDeal(Deal $deal)
    {
        $deals = $deal->with('deal_products')->first();
        return response()->json([
            'status' => true,
            'data' => $deals,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $deals = $request->all();
            $deal = Deal::findorFail($request->id);
            $success = $deal->update($deals);
            if (count($deal->deal_products)) {
                $deal->deal_products()->delete();
            }
            foreach ($deals['invoice_products'] as $key => $val) {
                if (!empty($val)) {
                    $deal = new DealProduct();
                    $deal->deal_id = $request->id;
                    $deal->product_id = $val['product_id']['id'];
                    $deal->product_qty = $val['product_qty'];
                    $deal->unit_price = $val['unit_price'];
                    $deal->shipping_charge = $val['shipping_charge'];
                    $deal->save();
                }
            }
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request, Deal $deal)
    {
        $deal->delete();

        return response()->json([
            'status' => true, 'message' => "Deal deleted successfully."
        ], 200);
    }
}
