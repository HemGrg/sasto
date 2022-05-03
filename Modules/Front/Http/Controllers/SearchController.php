<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use App\Models\User;
use  Modules\User\Entities\Vendor;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function productSearch(Request $request)
    {
        $title = $request->keyword;
        if ($request->select == 0) {
            $productSearch = Product::where('title', 'LIKE', "%" . $title . "%")
                ->orWhere('highlight', 'LIKE', "%" . $title . "%")
                ->orWhere('description', 'LIKE', "%" . $title . "%")
                ->get();
            return response()->json([
                'status' => 'successful',
                "message" => "Product search successfull!",
                "data" => $productSearch
            ], 200);
        } else {
            // $vendorSearch = Vendor::where('shop_name', 'LIKE', "%" . $title . "%")
            // ->orWhere('company_name', 'LIKE', "%" . $title . "%")
            // ->orWhere('company_address', 'LIKE', "%" . $title . "%")
            // ->orWhereHas('user', function ($query) use ($title) {
            //        $query->where('name', 'like', '%' . $title . '%')
            //        ;
            //     })
            // ->get();
            $vendorSearch = User::where('name', 'LIKE', "%" . $title . "%")
                ->orWhereHas('vendor', function ($query) use ($title) {
                    $query->where('shop_name', 'like', '%' . $title . "%")
                        ->orWhere('company_name', 'like', '%' . $title . "%")
                        ->orWhere('company_address', 'like', '%' . $title . "%");
                })
                ->orWhereHas('products', function ($query) use ($title) {
                    $query->where('title', 'like', '%' . $title . '%')
                        ->orWhere('highlight', 'LIKE', "%" . $title . "%")
                        ->orWhere('description', 'LIKE', "%" . $title . "%");
                })->get();
            return response()->json([
                'status' => 'successful',
                "message" => "vendor search successfull!",
                "data" => $vendorSearch
            ], 200);
        }
    }



    public function index()
    {
        $users = Vendor::whereHas('user', function ($q) {
            $q->where('shop_name', 'like', '%' . request()->q  . "%")
                ->orWhere('company_name', 'like', '%' . request()->q  . "%");
        })->where('status', 1)->orderBy('created_at', 'DESC')->paginate(request('per_page') ?? 15);
        return response()->json([
            'status' => 'successful',
            "message" => "vendor search successfull!",
            "data" => $users
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('front::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('front::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('front::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
