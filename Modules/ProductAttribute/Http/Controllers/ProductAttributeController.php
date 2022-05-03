<?php

namespace Modules\ProductAttribute\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ProductAttribute\Entities\Productattribute;
use Modules\Category\Entities\Category;
use Modules\Subcategory\Entities\Subcategory;
use Modules\ProductAttribute\Entities\CategoryAttribute;
use DB, Validator;

class ProductAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('productattribute::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $categories = Category::where('publish',1)->get();
        $subcategories = Subcategory::where('publish',1)->get();
        return view('productattribute::create',compact('categories','subcategories'));
    }

    public function createproductattribute(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'category_id'=>'required_without:subcategory_id',
            // 'category_id.*'=>'required_unless:subcategory_id.*,null|exists:categories,id',
            'subcategory_id'=>'required_without:category_id',
            // 'subcategory_id.*'=>'required_unless:category_id.*,null|exists:subcategories.id'
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
            exit;
        }
        DB::beginTransaction();
        try{
            $value = $request->except('image', 'publish');
            $value['publish'] = is_null($request->publish) ? 0 : 1;
            if($request->has('options')){
                $value['options'] = serialize($request->options);
            }else{
                 $value['options'] = serialize([]);
            }
            $data = Productattribute::create($value);
            if($request->has('category_id')){
                foreach($request->category_id as $catId){
                    $categoryProduct = new CategoryAttribute;
                    $categoryProduct->attribute_id = $data->id;
                    $categoryProduct->category_id = $catId;
                    $categoryProduct->save();
                }
            }
            if($request->has('subcategory_id')){
                 foreach($request->subcategory_id as $subCatId){
                    $categoryProduct = new CategoryAttribute;
                    $categoryProduct->attribute_id = $data->id;
                    $categoryProduct->subcategory_id = $subCatId;
                    $categoryProduct->save();
                }
            }
            DB::commit();
            return response()->json(['status' => 'successful', 'message' => 'Product Attribute Created Successfully.','data' => $data]);
        }  catch(\Exception $exception){
            DB::rollback();
              return response([
                  'message' => $exception->getMessage()
              ],400);
          }
    }

    public function allproductattributes()
    {
        $details = Productattribute::orderBy('created_at', 'desc')->get();
        $view = \View::make("productattribute::productattributesTable")->with('details', $details)->render();
        return response()->json(['html' => $view, 'status' => 'successful', 'data' => $details]);
    }

    

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('productattribute::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $categories = Category::where('publish',1)->get();
        $subcategories = Subcategory::where('publish',1)->get();
        // $categoryAttribute = CategoryAttribute::where('attribute_id',$id)->pluck('category_id');
        $productAttribute = Productattribute::where('id',$id)->firstOrFail();
        $cat = CategoryAttribute::where('attribute_id',$id)->whereNotNull('category_id')->whereNull('subcategory_id')->get();
        $subcat = CategoryAttribute::where('attribute_id',$id)->whereNotNull('subcategory_id')->whereNull('category_id')->get();
       
        return view('productattribute::edit',compact('categories','subcategories','cat','subcat','productAttribute'));
    }

    public function updateproductattribute(Request $request){
        // dd($request->all());
        $productAttribute = Productattribute::findOrFail($request->id);
        if($productAttribute){
            if($request->has('options')){
                $value['options'] = serialize($request->options);
            }else{
                 $value['options'] = serialize([]);
            }
            // dd($value);
            $data = Productattribute::find($request->id)->update($value);
            // dd($data);
            if($request->has('category_id')){
                foreach($request->category_id as $catId){
                    $categoryProducts = CategoryAttribute::where('attribute_id',$request->id)->first();
                    // foreach($categoryProducts as $categoryProduct ){
                        // dd($categoryProduct);
                        $categoryProducts->category_id = $catId;
                        $categoryProducts->update();

                    // }
                    // $categoryProduct = new CategoryAttribute;
                    // $categoryProduct->attribute_id = $request->id;
                    // $categoryProduct->category_id = $catId;
                    // $categoryProduct->save();
                }
            }
            if($request->has('subcategory_id')){
                 foreach($request->subcategory_id as $subCatId){
                    // $categoryProduct = new CategoryAttribute;
                    // $categoryProduct->attribute_id = $request->id;
                    // $categoryProduct->subcategory_id = $subCatId;
                    // $categoryProduct->save();
                    // $categoryProducts = CategoryAttribute::where('attribute_id',$request->id)->get();
                    // // foreach($categoryProducts as $categoryProduct ){
                    //     $categoryProduct->subcategory_id = $subCatId;
                    //     $categoryProduct->update();

                    // }
                }
            }
            return response()->json(['status' => 'successful', 'message' => 'Product Attribute updated Successfully.','data' => $data]);

        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
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
}
