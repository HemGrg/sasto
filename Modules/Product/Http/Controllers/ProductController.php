<?php

namespace Modules\Product\Http\Controllers;

use App\Service\ImageService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Product\Entities\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\Product\Service\ProductImageService;
use Modules\ProductCategory\Entities\ProductCategory;

class ProductController extends Controller
{
    use AuthorizesRequests;

    protected $productImageService;
    protected $imageService;

    public function __construct(ProductImageService $productImageService, ImageService $imageService)
    {
        $this->productImageService = $productImageService;
        $this->imageService = $imageService;
    }

    public function index()
    {
        $this->authorize('manageProducts');

        $products = Product::with('user.vendor')
            ->when(request()->filled('search'), function ($query) {
                return $query->where('title', 'like', '%' . request('search') . "%");
            })
            ->latest()
            ->paginate(request('per_page') ?? 15)
            ->withQueryString();

        return view('product::index', compact('products'));
    }

    public function getcategories()
    {
        $categories = Category::where('publish', 1)->get();
        return response()->json(['data' => $categories, 'status_code' => 200]);
    }

    public function getsubcategory(Request $request)
    {
        $categories = Category::find($request->category_id);
        return response()->json(['category' => $categories]);
    }

    public function getProductCategory(Request $request)
    {
        $request->validate([
            'subcategory_id' => ['required', 'exists:subcategories,id'],
        ]);

        $productCategories  = ProductCategory::select(['id', 'name', 'publish'])
            ->where('subcategory_id', $request->subcategory_id)
            ->published()->get();

        return response()->json(['data' => $productCategories]);
    }

    public function view($id)
    {
        $product = Product::where('id', $id)->with('ranges', 'images')->first();
        return view('product::view', compact('id', 'product'));
    }

    // Ask mam where it is required
    public function viewProduct(Request $request)
    {
        try {
            $product = Product::where('id', $request->id)->with(['category', 'brand', 'offer'])->first();
            return response()->json([
                "message" => "Product view!",
                'data' => $product
            ], 200);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function deleteproduct(Request $request)
    {
        $this->authorize('manageProducts');

        try {
            $product = Product::findorFail($request->id);
            $this->productImageService->delete($product);
            $product->delete();

            return response()->json([
                'status' => 'successful',
                "message" => "Product deleted successfully!"
            ], 200);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}
