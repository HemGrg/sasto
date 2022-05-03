<?php

namespace Modules\ProductCategory\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Category\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\ProductCategory\Entities\ProductCategory;
use Modules\ProductCategory\Http\Requests\ProductCategoryRequest;
use Modules\Subcategory\Entities\Subcategory;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $this->authorize('manageCategories');
        $productCategories = ProductCategory::with('subcategory')->withCount('products')->latest()->get();
        return view('productcategory::index', compact('productCategories'));
    }

    public function create()
    {
        $this->authorize('manageCategories');
        return $this->showForm(new ProductCategory());
    }

    public function store(ProductCategoryRequest $request)
    {
        $this->authorize('manageCategories');

        $productCategory = new ProductCategory();
        $productCategory->name = $request->name;
        $productCategory->subcategory_id = $request->subcategory_id;
        $productCategory->is_featured = $request->filled('is_featured');
        $productCategory->publish = $request->filled('publish');

        if ($request->has('image')) {
            $productCategory->image = $request->image->store('images/category');
        }
        $productCategory->save();

        if (auth()->user()->hasRole('vendor')) {
            foreach(admin_users() as $admin) {
                $admin->notify(new \Modules\ProductCategory\Notifications\ProductCategoryRequestNotification($productCategory));
            }
        }


        return redirect()->route('product-category.index')->with('success', 'Item added successfully.');
    }

    // Not in use
    public function show($id)
    {
        return view('productcategory::show');
    }

    public function edit(ProductCategory $productCategory)
    {
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);

        return $this->showForm($productCategory);
    }

    public function update(ProductCategoryRequest $request, ProductCategory $productCategory)
    {
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);

        $productCategory->name = $request->name;
        if ($request->filled('slug')) {
            $productCategory->slug = $request->slug;
        }
        $productCategory->subcategory_id = $request->subcategory_id;
        $productCategory->is_featured = $request->filled('is_featured');
        $productCategory->publish = $request->filled('publish');
        if ($request->has('image')) {
            $productCategory->image = $request->image->store('images/category');
        }
        $productCategory->update();

        return redirect()->route('product-category.index')->with('success', 'Item updated successfully.');
    }

    /**
     * Using and API route
     */
    public function destroy(ProductCategory $productCategory)
    {
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);

        $productCategory->delete();

        return redirect()->route('product-category.index')->with('success', 'Item deleted successfully.');
    }

    public function showForm(ProductCategory $productCategory)
    {
        $updateMode = false;
        $categoryId = null;
        if ($productCategory->exists) {
            $updateMode = true;
            $categoryId = $productCategory->subcategory->category->id;
        }

        $categories = Category::with('subcategory')
            ->whereHas('subcategory', function ($query) {
                $query->where('publish', true);
            })
            ->get();
        // return $categories;

        return view('productcategory::form', compact('productCategory', 'categories', 'updateMode', 'categoryId'));
    }

    public function changeStatus(ProductCategory $productCategory)
    {
        $productCategory->publish = request()->publish ? true : false;
        $productCategory->update();
    }
}
