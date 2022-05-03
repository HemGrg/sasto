<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Country\Entities\Country;
use Modules\Front\Transformers\VendorResource;
use Modules\Product\Entities\Product;
use Modules\Subcategory\Entities\Subcategory;
use Modules\User\Entities\Vendor;

class VendorApiController extends Controller
{
    public function index()
    {
        $vendors = Vendor::whereHas('user', function ($query) {
            $query->published()->approved()->verified();
        })
            ->when(request()->filled('from'), function ($query) {
                $country = Country::where('slug', request('from'))->first();
                return $query->where('country_id', $country->id);
            })
            ->when(request()->filled('q'), function ($query) {
                return $query->where('shop_name', 'like', '%' . request()->q . '%');
            })
            ->paginate(20);

        return VendorResource::collection($vendors)->hide([
            'description',
        ]);
    }

    public function show(Vendor $vendor)
    {
        $vendor->load('user');

        return VendorResource::make($vendor);
    }

    public function showByUserId($userId)
    {
        $vendor = Vendor::with('user')->where('user_id', $userId)->firstOrFail();

        return VendorResource::make($vendor);
    }

    public function getLatestVendors()
    {
        $vendors = Vendor::where('is_featured', true)->whereHas('user', function ($query) {
            $query->published()->approved()->verified();
        })
            ->latest()
            ->limit(10)
            ->get()->map(function ($vendor) {
                return [
                    'id' => $vendor->id,
                    'shop_name' => $vendor->shop_name,
                    'image_url' => $vendor->imageUrl(),
                ];
            });

        return response()->json($vendors->shuffle()->all(), 200);
    }

    public function getCategoriesOfProductSold($vendorId)
    {
        $productCategoryIds = Product::where('vendor_id', $vendorId)->distinct('product_category_id')->pluck('product_category_id')->toArray();

        $subCategories = Subcategory::with(['category', 'productCategory'])->published()->get();

        $categories = [];
        foreach ($productCategoryIds as $productCategoryId) {
            foreach ($subCategories as $subCategory) {
                foreach ($subCategory->productCategory as $productCategory) {
                    if ($productCategory->id == $productCategoryId) {
                        $categories[] = $subCategory->category;
                    }
                }
            }
        }

        $categories = collect($categories)->unique('id');

        return $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'image_url' => $category->imageUrl(),
            ];
        });;
    }
}
