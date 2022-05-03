<?php

namespace Modules\Front\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Category\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\ProductCategory\Entities\ProductCategory;
use Modules\Subcategory\Entities\Subcategory;

class BreadcrumbApiController extends Controller
{
    protected $breadcrumbs = [];

    public function category()
    {
        request()->validate([
            'type' => 'required',
            'slug' => 'required'
        ]);

        if (request('type') == 'cat') {
            $category = Category::where('slug', request('slug'))->firstOrFail();
            $this->addItem($category, 'cat');
        }

        if (request('type') == 'subcat') {
            $subcategory = Subcategory::with('category')->where('slug', request('slug'))->firstOrFail();
            $this->addItem($subcategory->category, 'cat');
            $this->addItem($subcategory, 'subcat');
        }

        if (request('type') == 'prod_cat') {
            $productCategory = ProductCategory::with('subcategory.category')->where('slug', request('slug'))->firstOrFail();
            $this->addItem($productCategory->subcategory->category, 'cat');
            $this->addItem($productCategory->subcategory, 'subcat');
            $this->addItem($productCategory, 'prod_cat');
        }

        return response()->json($this->breadcrumbs, 200);
    }

    public function productBreadcrumbs($id)
    {
        $product = Product::with('productCategory.subcategory.category')->findOrFail($id);
        $this->addItem($product->productCategory->subcategory->category, 'cat');
        $this->addItem($product->productCategory->subcategory, 'subcat');
        $this->addItem($product->productCategory, 'prod_cat');

        return response()->json($this->breadcrumbs, 200);
    }

    protected function addItem($item, $type)
    {
        $this->breadcrumbs[] =  [
            'name' => $item->name,
            'slug' => $item->slug,
            'type' => $type
        ];
    }
}
