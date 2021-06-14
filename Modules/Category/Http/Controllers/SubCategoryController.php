<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\SubCategory;
use Illuminate\Support\str;

class SubCategoryController extends Controller
{
    //add

    public function addSubCategory(Request $request, $slug){
       
        $detail = Category::where('slug',$slug)->first();
        if($request->isMethod('post')){
            $request->validate([
                'image' => 'required|mimes:jpeg,jpg,png,gif|dimensions:min_width=300,min_height=200,max_width=500,max_height=500',
                'name' => 'required|max:255',
            ]);
            $countSubCat = SubCategory::where('name',$request->name)->count();
            if($countSubCat > 0){
                return redirect()->back()->with('flash_message_error','This Sub Category is already exist please insert new Category!');
            }
            $value = $request->except('image','featured','in_include','parent_id','category_slug','publish');
            $value['parent_id'] = $request->parent_id;
            $value['category_slug'] = $request->category_slug;
            $value['featured'] = is_null($request->featured)? 0 : 1 ;
            $value['is_included_on_main_menu'] = is_null($request->in_include)? 0 : 1 ;
            $value['publish'] = is_null($request->publish)? 0 : 1 ;
            if ($request->hasFile('image')) {
                $thumImg = $this->imageProcessing($request->file('image'));
                $value['image'] = $thumImg;
            }
            SubCategory::create($value);
            return redirect()->back()->with('message','New Category is added successfully!');
        }
        return view('category::subCategory.add')->with(compact('detail'));
    }

    //view

    public function viewSubCategories($slug){
        $details = SubCategory::where('category_slug',$slug)->get();
        $parentCategory = Category::where('slug',$slug)->first();
        return view('category::subCategory.view')->with(compact('details','parentCategory'));
    }

    //edit

    public function editSubCategory(Request $request,$slug){
        $detail = SubCategory::where('slug',$slug)->first();
        $parentCategory = Category::where('slug',$detail->category_slug)->first();
        if($request->isMethod('post')){
            $request->validate([
                'image' => 'mimes:jpeg,jpg,png,gif|dimensions:min_width=300,min_height=200,max_width=500,max_height=500',
                'name' => 'required|max:255',
            ]);
            $value = $request->except('image','slug','featured','in_include','publish');
            $value['slug']=Str::slug($request->name);
            $value['featured'] = is_null($request->featured)? 0 : 1 ;
            $value['is_included_on_main_menu'] = is_null($request->in_include)? 0 : 1 ;
            $value['publish'] = is_null($request->publish)? 0 : 1 ;
            if ($request->hasFile('image')) {
                if ($detail->image) {
                    $this->unlinkImage($detail->image);
                }
                $value['image'] = $this->imageProcessing($request->file('image'));
            }
            $detail->update($value);
            return redirect()->back()->with('flash_message_success', 'Service Attribute Updated Successfully.');
        }
        return view('category::subCategory.edit')->with(compact('detail','parentCategory'));
    }


    //Image

    public function imageProcessing($image)
    {
        $input['imagename'] = Date("D-h-i-s") . '-' . rand() . '-' . '.' . $image->extension();
        $image->move('uploads/subCategory/', $input['imagename']);
        return $input['imagename'];
    }

    public function unlinkImage($imagename)
    {
        $mainPath = public_path('uploads/subCategory/') . $imagename;
        unlink($mainPath);
        return;
    }
}
