<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Category\Entities\Category;
use Validator;
use Image;
use DB, File;

class CategoryController extends Controller
{
    public function index()
    {
        $this->authorize('manageCategories');
        $details = Category::orderBy('created_at', 'desc')->withCount('subcategory')->withCount('products')->get();
        // $details = Category::withCount('subcategory')->orderBy('created_at', 'desc')->get();

        return view('category::index', [
            'details' => $details
        ]);
    }

    public function create()
    {
        $this->authorize('manageCategories');
        return view('category::create');
    }

    public function createcategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories|max:255',
            'image' => 'mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
        }

        $value = $request->except('image', 'publish');
        if (auth()->user()->hasRole('vendor')) {
            $value['publish'] = 0;
        } else {
            $value['publish'] = $request->has('publish') ? 1 : 0;
        }
        $value['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $value['hot_category'] = $request->has('hot_category') ? 1 : 0;
        $value['include_in_main_menu'] = $request->has('include_in_main_menu') ? 1 : 0;
        $value['does_contain_sub_category'] = $request->has('does_contain_sub_category') ? 1 : 0;
        if ($request->image) {
            $image = $this->imageProcessing('img-', $request->file('image'));
            $value['image'] = $image;
        }
        $data = Category::create($value);

        if (auth()->user()->hasRole('vendor')) {
            foreach(admin_users() as $admin) {
                $admin->notify(new \Modules\Category\Notifications\CategoryRequestNotification($data));
            }
        }

        
    }

    public function allCategories()
    {
        $details = Category::orderBy('created_at', 'desc')->get();
        $view = \View::make("category::categoriesTable")->with('details', $details)->render();

        return response()->json(['html' => $view, 'status' => 'successful', 'data' => $details]);
    }

    public function deletecategory(Request $request,  Category $category)
    {
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);

        $category->delete();

        return response()->json([
            'status' => 'successful',
            "message" => "Category deleted successfully!"
        ], 200);
    }

    public function editcategory(Request $request)
    {
        try {
            $category = Category::findorFail($request->id);

            return response()->json([
                "data" => $category
            ], 200);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function updatecategory(Request $request)
    {
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'image' => 'mimes:jpg,jpeg,png',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
                exit;
            }
            $category = Category::findorFail($request->id);
            $value = $request->except('publish', '_token');
            $value['publish'] = is_null($request->publish) ? 0 : 1;
            $value['is_featured'] = $request->has('is_featured') ? 1 : 0;
            $value['hot_category'] = $request->has('hot_category') ? 1 : 0;
            $value['include_in_main_menu'] = $request->has('include_in_main_menu') ? 1 : 0;
            $value['does_contain_sub_category'] = $request->has('does_contain_sub_category') ? 1 : 0;
            if ($request->image) {
                $image = Category::findorFail($request->id);
                if ($image->image) {
                    $thumbPath = public_path('images/thumbnail');
                    $listingPath = public_path('images/listing');
                    if ((file_exists($thumbPath . '/' . $image->image)) && (file_exists($listingPath . '/' . $image->image))) {
                        unlink($thumbPath . '/' . $image->image);
                        unlink($listingPath . '/' . $image->image);
                    }
                }
                $image = $this->imageProcessing('img-', $request->file('image'));
                $value['image'] = $image;
            }
            $success = $category->update($value);
            return response()->json([
                'status' => 'successful',
                "data" => $value,
                "message" => "category updated successfully"
            ], 200);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }


    public function show($id)
    {
        return view('category::show');
    }

    public function edit($id)
    {
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);

        return view('category::edit', compact('id'));
    }

    public function view($id)
    {
        return view('category::view', compact('id'));
    }

    public function viewCategory(Request $request)
    {
        try {
            $category = Category::findorFail($request->id);
            return response()->json([
                "message" => "Category view!",
                'data' => $category
            ], 200);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function imageProcessing($type, $image)
    {
        $input['imagename'] = $type . time() . '.' . $image->getClientOriginalExtension();
        $thumbPath = public_path() . "/images/thumbnail";
        if (!File::exists($thumbPath)) {
            File::makeDirectory($thumbPath, 0777, true, true);
        }
        $listingPath = public_path() . "/images/listing";
        if (!File::exists($listingPath)) {
            File::makeDirectory($listingPath, 0777, true, true);
        }
        $img1 = Image::make($image->getRealPath());
        $img1->fit(99, 88)->save($thumbPath . '/' . $input['imagename']);


        $img2 = Image::make($image->getRealPath());
        $img2->save($listingPath . '/' . $input['imagename']);

        $destinationPath = public_path('/images');
        return $input['imagename'];
    }

    public function unlinkImage($imagename)
    {
        $thumbPath = public_path('images/thumbnail/') . $imagename;
        $listingPath = public_path('images/listing/') . $imagename;
        if (file_exists($thumbPath)) {
            unlink($thumbPath);
        }

        if (file_exists($listingPath)) {
            unlink($listingPath);
        }

        return;
    }
}
