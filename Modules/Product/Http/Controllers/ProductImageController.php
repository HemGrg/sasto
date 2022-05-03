<?php

namespace Modules\Product\Http\Controllers;

use App\Service\ImageService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductImage;
use Modules\Product\Service\ProductImageService;

class ProductImageController extends Controller
{
    protected $productImageService;
    protected $imageService;

    public function __construct(ProductImageService $productImageService, ImageService $imageService)
    {
        $this->productImageService = $productImageService;
        $this->imageService = $imageService;
    }

    public function index(Product $product)
    {
        $updateMode = true;

        return view('product::product-images', compact('product', 'updateMode'));
    }

    public function listing(Product $product)
    {
        $productImages = $product->images()->latest()->get();
        $productImages = $productImages->map(function ($productImage) {
            $productImage['url'] = $productImage->imageUrl();
            $productImage['readable_size'] = $productImage->getReadableSize($productImage->size);
            return $productImage;
        });

        return response()->json($productImages);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::findOrFail($request->product_id);

        $this->productImageService->create($product, $request->file('file'));

        return response()->json([
            'success' => 'Image Saved'
        ]);
    }

    public function destroy(ProductImage $productImage)
    {
        try {
            $this->imageService->unlinkImage($productImage->path);
            $this->imageService->unlinkImage($productImage->thumbnail_path);
            $productImage->delete();

            return response()->json(null, 204);
        } catch (Exception $e) {
            return response()->json(null, 500);
        }
    }
}
