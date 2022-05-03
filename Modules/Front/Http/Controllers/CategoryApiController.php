<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Category\Entities\Category;
use Modules\ProductCategory\Entities\ProductCategory;
use Modules\Subcategory\Entities\Subcategory;

class CategoryApiController extends Controller
{
    public function index()
    {
        $categories = Category::with([
            'subcategory' => function ($query) {
                $query->select(['id', 'name', 'slug', 'category_id', 'image'])->published();
            },
            'subcategory.productCategory' => function ($query) {
                $query->select(['id', 'name', 'slug', 'subcategory_id', 'image']); //->published();
            }
        ])
            ->published()
            ->get()->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    // 'image_url' => $category->imageUrl(),
                    'image_url' => $category->imageUrl('thumbnail'),
                    'is_featured' => $category->is_featured,
                    'subcategory' => $category->subcategory->map(function ($category) {
                        return [
                            'id' => $category->id,
                            'name' => $category->name,
                            'slug' => $category->slug,
                            'image_url' => $category->imageUrl(),
                            'product_categories' => $category->productCategory->map(function ($prodCat) {
                                return [
                                    'id' => $prodCat->id,
                                    'name' => $prodCat->name,
                                    'slug' => $prodCat->slug,
                                    'image_url' => $prodCat->imageUrl(),
                                ];
                            })
                        ];
                    }),
                ];
            });

        return response()->json($categories, 200);
    }

    public function vendorCategory()
    {
        $categories = Category::published()->select('id', 'name')
            ->get();
        return response()->json($categories, 200);
    }

    public function megamenu()
    {
        $categories = Cache::remember('megamenu', now()->addMinutes(30), function () {
            return Category::with([
                'subcategory' => function ($query) {
                    $query->select(['id', 'name', 'slug', 'category_id', 'image'])->published();
                },
                'subcategory.productCategory' => function ($query) {
                    $query->select(['id', 'name', 'slug', 'subcategory_id', 'image'])->published();
                }
            ])
                ->where('include_in_main_menu', 1)
                ->published()
                ->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                        'image_url' => $category->imageUrl('thumbnail'),
                        'is_featured' => $category->is_featured,
                        'subcategory' => $category->subcategory
                    ];
                });
        });

        return response()->json($categories, 200);
    }

    public function hotCategories()
    {
        $subCategories = Subcategory::select(['id', 'name', 'slug', 'category_id', 'image', 'is_featured'])
            ->featured()
            ->published()
            ->get()->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'image_url' => $category->imageUrl(),
                    'is_featured' => $category->is_featured,
                ];
            });

        return response()->json($subCategories, 200);
    }

    public function vendorCatgeory()
    {
        $categories = Category::published()->select('id', 'name')
            ->get();
        return response()->json($categories, 200);
    }

    public function subcategories()
    {
        return Subcategory::select(['id', 'name', 'slug', 'category_id', 'image', 'is_featured'])
            ->when(request()->filled('category_id'), function ($query) {
                $query->where('category_id', request('category_id'));
            })
            ->published()
            ->get()->map(function ($category) {
                return [
                    'id' => $category->id,
                    'category_id' => $category->category_id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'image_url' => $category->imageUrl(),
                    'is_featured' => $category->is_featured,
                ];
            });
    }

    public function productCategories()
    {
        return ProductCategory::select(['id', 'name', 'slug', 'subcategory_id', 'image', 'is_featured'])
            ->when(request()->filled('subcategory_id'), function ($query) {
                $query->where('subcategory_id', request('subcategory_id'));
            })
            ->published()
            ->get()->map(function ($category) {
                return [
                    'id' => $category->id,
                    'subcategory_id' => $category->subcategory_id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'image_url' => $category->imageUrl(),
                    'is_featured' => $category->is_featured,
                ];
            });
    }
}
