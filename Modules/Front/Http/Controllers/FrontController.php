<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Category\Entities\Category;
use Modules\Subcategory\Entities\Subcategory;
use App\Models\User;
use Modules\Role\Entities\Role_user;
use Modules\Role\Entities\Role;


class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function getSastoWholeSaleProducts()
    {
        $product = Product::where('type', 'whole_sale')
            ->where('status', 'active')
            ->orderBy('created_at', 'DESC')->take(12)->get();
        return response()->json(['data' => $product, 'status_code' => 200]);
    }


    // Moved to ProductApiController
    // public function getAllProducts(){
    //     $product = Product::where('status', 'active')->orderBy('created_at', 'DESC')->with(['category','ranges'])->get();
    //     return response()->json(['data'=>$product, 'status_code'=>200]);
    // }

    public function getVendorProducts(Request $request, $username)
    {
        $user = User::where('username', $username)->with('vendor', 'products')->first();
        return response()->json(['data' => $user, 'status_code' => 200]);
    }

    public function getCategoryProducts(Request $request, $categoryslug)
    {
        $category = Category::where('slug', $categoryslug)->with(['subcategory', 'products'])->first();
        if ($category->subcategory->isEmpty()) {
            $category = Category::where('slug', $categoryslug)->with(['products'])->first();
        }
        return response()->json(['data' => $category, 'status_code' => 200]);
    }

    public function getSubcategoryProducts($slug)
    {
        $sub = Subcategory::where('slug', $slug)->first();
        $products = Product::where('subcategory_id', $sub->id)->get();
        return response()->json(['data' => $products, 'status_code' => 200]);
    }

    public function getVendorCategories(Request $request, $username)
    {
        $user = User::where('username', $username)->with('vendor', 'products')->first();
        $products = $user->products->pluck('category_id');
        $categories = Category::whereIn('id', $products)->with('subcategory')->get();
        return response()->json(['data' => $categories, 'status_code' => 200]);
    }

    public function getVendorSubcategoryProducts($username, $slug)
    {
        $user = User::where('username', $username)->with('vendor', 'products')->first();
        $sub = Subcategory::where('slug', $slug)->first();
        $products = Product::where('subcategory_id', $sub->id)->where('user_id', $user->id)->get();
        return response()->json(['data' => $products, 'status_code' => 200]);
    }

    public function getVendorCategoryProducts($username, $slug)
    {
        $user = User::where('username', $username)->with('vendor', 'products')->first();
        $category = Category::where('slug', $slug)->with(['subcategory'])->first();
        $products = Product::where('category_id', $category->id)->where('user_id', $user->id)->get();
        if ($category->subcategory->isEmpty()) {
            $category = Category::where('slug', $slug)->with(['products'])->first();
            $products = Product::where('user_id', $user->id)->where('category_id', $category->id)->get();
        }
        return response()->json(['data' => $category, 'products' => $products, 'status_code' => 200]);
    }

    // Not in use
    // Checkout CategoryApiController
    public function allcategories()
    {
        $allcategories = Category::where('publish', 1)->with(['subcategory', 'products'])->get();
        return response()->json(['data' => $allcategories, 'status_code' => 200]);
    }



    public function index()
    {
        return view('front::index');
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
