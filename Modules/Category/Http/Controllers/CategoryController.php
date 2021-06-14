<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\str;
use Modules\Category\Entities\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $details = Category::all();
        return view('category::category.view')->with(compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('category::category.add');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpeg,jpg,png,gif|dimensions:min_width=300,min_height=200,max_width=500,max_height=500',
            'name' => 'required|max:255',
        ]);
        $countCat = Category::where('name',$request->name)->count();
        if($countCat > 0){
            return redirect()->back()->with('flash_message_error','This Category is already exist please insert new Category!');
        }
        $value = $request->except('image','featured','is_sub_category','in_include','publish');
        $value['featured'] = is_null($request->featured)? 0 : 1 ;
        $value['include_in_main_menu'] = is_null($request->in_include)? 0 : 1 ;
        $value['does_contain_sub_category'] = is_null($request->is_sub_category)? 0 : 1 ;
        $value['publish'] = is_null($request->publish)? 0 : 1 ;
        if ($request->hasFile('image')) {
            $thumImg = $this->imageProcessing($request->file('image'));
            $value['image'] = $thumImg;
        }
        Category::create($value);
        return redirect()->back()->with('message', 'Data Added Successfully.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('category::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($slug)
    {
        $detail = Category::where('slug',$slug)->first();
        return view('category::category.edit')->with(compact('detail'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'mimes:jpeg,jpg,png,gif|dimensions:min_width=300,min_height=200,max_width=500,max_height=500',
            'name' => 'required|max:255',
        ]);
        $value = $request->except('image','featured','is_sub_category','in_include','publish');
        $value['slug']=Str::slug($request->name);
        $value['featured'] = is_null($request->featured)? 0 : 1 ;
        $value['include_in_main_menu'] = is_null($request->in_include)? 0 : 1 ;
        $value['does_contain_sub_category'] = is_null($request->is_sub_category)? 0 : 1 ;
        $value['publish'] = is_null($request->publish)? 0 : 1 ;
        if($request->hasFile('image')){
                $image=Category::find($id);
                if($image->image){
                    $imagePath = public_path('uploads/category');
                    if((file_exists($imagePath.'/'.$image->image))){
                        unlink($imagePath.'/'.$image->image);
                    }
                }
                $image=$this->imageProcessing($request->file('image'));
                $value['image']=$image;
            }
        Category::find($id)->update($value);
        return redirect()->route('category.index')->with('message','Category Updated Successfully.');
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

    //Image

    public function imageProcessing($image)
    {
        $input['imagename'] = Date("D-h-i-s") . '-' . rand() . '-' . '.' . $image->extension();
        $image->move('uploads/category/', $input['imagename']);
        return $input['imagename'];
    }

    public function unlinkImage($imagename)
    {
        $mainPath = public_path('uploads/category/') . $imagename;
        unlink($mainPath);
        return;
    }
}
