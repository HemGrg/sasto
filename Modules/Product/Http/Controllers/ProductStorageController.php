<?php

namespace Modules\Product\Http\Controllers;

use App\Service\ImageService;
use Exception;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Range;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Product\Http\Requests\ProductPricingRequest;
use Modules\Product\Http\Requests\ProductRequest;

class ProductStorageController extends Controller
{
    use AuthorizesRequests;

    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function create()
    {
        $this->authorize('manageProducts');

        return $this->showProductForm(new Product());
    }

    protected function showProductForm(Product $product)
    {
        $updateMode = false;
        $product->loadMissing('ranges');
        $subcategory = null;
        $categoryId = null;
        $subcategoryId = null;

        $categories = Category::with([
            'subcategory' => function ($query) {
                $query->published();
            },
            'subcategory.productCategory' => function ($query) {
                $query->published();
            }
        ])->published()->get();

        if ($product->exists) {
            $updateMode = true;

            $subcategory = $product->productCategory->subcategory;
            $categoryId = $subcategory->category->id;
            $subcategoryId = $subcategory->id;
        }

        return view('product::form', compact('product', 'updateMode', 'categories', 'categoryId', 'subcategoryId'));
    }

    public function store(ProductRequest $request)
    {
        $this->authorize('manageProducts');

        try {
            DB::beginTransaction();
            $product = new Product();
            $product->user_id = auth()->id();
            $product->vendor_id = auth()->user()->vendor->id;
            $product->title = $request->title;
            $product->product_category_id = $request->product_category_id;
            $product->shipping_charge = $request->shipping_charge;
            $product->unit = $request->unit;
            $product->highlight = $request->highlight;
            $product->description = $request->description;
            $product->video_link = $request->video_link;
            $product->is_top = $request->has('is_top') ? true : false;
            $product->is_new_arrival = $request->has('is_new_arrival') ? true : false;
            // $product->status = $request->status == 'active' ? true : false;
            $product->status = false;

            $product->meta_title = $request->meta_title;
            $product->meta_description = $request->meta_description;
            $product->meta_keyword = $request->meta_keyword;
            $product->meta_keyphrase = $request->meta_keyphrase;

            $product->overview = $request->only('payment_mode', 'size', 'brand', 'colors', 'country_of_origin', 'warranty', 'feature', 'use', 'gender', 'age_group');

            if ($request->hasFile('image')) {
                $product->image = $this->imageService->storeImage($request->file('image'));
                $product->image_thumbnail = $this->imageService->storeImage($request->file('image'));
                $this->imageService->createThumbnail(Storage::path($product->image_thumbnail), null, 350);
            }

            $product->save();

            // foreach ($request->from as $key => $val) {
            //     if (!empty($val)) {
            //         $range = new Range();
            //         $range->product_id = $product->id;
            //         $range->from = $val;
            //         $range->to = $request->to[$key] ?? null;
            //         $range->price = $request->prices[$key];
            //         $range->save();
            //     }
            // }

            DB::commit();

            return response()->json(['status' => 'successful', 'message' => 'Product information saved successfully.', 'data' => $product]);
        } catch (\Exception $exception) {
            DB::rollback();
            $this->deleteMainProductImage($product);
            report($exception);
            return response([
                'status' => 'unsuccessful',
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function pricing(Product $product)
    {
        $updateMode = true;
        $product->loadMissing('ranges');
        $product->above_range_price = collect($product->ranges)->whereNull('to')->first()->price ?? 0;
        return view('product::price_range', compact('updateMode', 'product'));
    }

    public function savePricing(ProductPricingRequest $request, Product $product)
    {
        $prevTo = null;
        foreach ($request->ranges as $key => $range) {
            if ($prevTo) {
                if ($range['from'] != $prevTo + 1) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'ranges.' . $key .'.from' => 'This value must be ' . ($prevTo + 1)
                    ]);
                }
            }
            $prevTo = $range['to'];
        }

        $product->ranges()->delete();

        $maxTo = 1;

        foreach ($request->ranges as $range) {
            $productRange = new Range();
            $productRange->product_id = $product->id;
            $productRange->from = $range['from'];
            $productRange->to = $range['to'];
            $productRange->price = $range['price'];
            $productRange->save();

            if ($range['to'] > $maxTo) {
                $maxTo = $range['to'];
            }
        }

        Range::create([
            'product_id' => $product->id,
            'from' => count($request->ranges) ? ($maxTo + 1) : 1,
            'to' => null,
            'price' => $request->above_range_price,
        ]);

        $product->update(['status' => true]);

        return response()->json([
            'message' => 'Pricing saved successfully.',
            'redirect_url' => route('product-images.index', $product->id)
        ], 200);
    }

    public function edit(Product $product)
    {
        $this->authorize('manageProducts');

        return $this->showProductForm($product);
    }

    public function update(ProductRequest $request)
    {
        $this->authorize('manageProducts');

        try {
            DB::beginTransaction();
            $product = Product::findorFail($request->id);
            $product->title = $request->title;
            $product->product_category_id = $request->product_category_id;
            $product->shipping_charge = $request->shipping_charge;
            $product->unit = $request->unit;
            $product->highlight = $request->highlight;
            $product->description = $request->description;
            $product->video_link = $request->video_link;
            $product->is_top = $request->has('is_top') ? true : false;
            $product->is_new_arrival = $request->has('is_new_arrival') ? true : false;
            // $product->status = $request->status == 'active' ? true : false;

            $product->meta_title = $request->meta_title;
            $product->meta_description = $request->meta_description;
            $product->meta_keyword = $request->meta_keyword;
            $product->meta_keyphrase = $request->meta_keyphrase;

            $product->overview = $request->only('payment_mode', 'size', 'brand', 'colors', 'country_of_origin', 'warranty', 'feature', 'use', 'gender', 'age_group');

            if ($request->hasFile('image')) {
                $this->deleteMainProductImage($product);
                $product->image = $this->imageService->storeImage($request->file('image'));
                $product->image_thumbnail = $this->imageService->storeImage($request->file('image'));
                $this->imageService->createThumbnail(Storage::path($product->image_thumbnail), null, 350);
            }

            $product->update();

            DB::commit();

            return response()->json([
                'status' => 'successful',
                "data" => $product,
                "message" => "Product updated successfully."
            ], 200);
        } catch (\Exception $exception) {
            DB::rollback();
            report($exception);
            return response([
                'status' => 'unsuccessful',
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    protected function deleteMainProductImage(Product $product)
    {
        if ($product->image) {
            $this->imageService->unlinkImage($product->image);
        }
        if ($product->image_thumbnail) {
            $this->imageService->unlinkImage($product->image_thumbnail);
        }
    }
}
