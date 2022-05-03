<?php

namespace Modules\Brand\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Brand\Entities\Brand;
use DB, Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('brand::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('brand::create');
    }
    public function getBrands()
    {
        // $details = DB::table('roles')->skip(10)->take(5)->get();
        $details = Brand::orderBy('created_at', 'desc')->get();
        $view = \View::make("brand::brandsTable")->with('details', $details)->render();
        return response()->json(['html' => $view, 'status' => 'successful', 'data' => $details]);
    }

    public function createbrand(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:brands|max:255',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
            exit;
        }
        DB::beginTransaction();
        try{
            $value = $request->except('publish');
            $value['publish'] = is_null($request->publish) ? 0 : 1;
            // dd($value['publish']);
        $title = $request->title;
        $value = [
            'title'=> $title,
            'publish' => $value['publish']
        ];
        $data = Brand::create($value);
        DB::commit();

        return response()->json(['status' => 'successful', 'message' => 'Brand Created Successfully.','data' => $data]);

        }  catch(\Exception $exception){
            DB::rollback();
              return response([
                  'message' => $exception->getMessage()
              ],400);
          }
    }

    
    public function view($id)
    {
        return view('brand::view', compact('id'));
    }
    public function deletebrand(Request $request)
    {
        try{
            $brand = Brand::findorFail($request->id);
            $brand->delete();

      return response()->json([
        'status' => 'successful',
        "message" => "Brand deleted successfully!"
      ], 200);
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }

    }

    public function editbrand(Request $request)
    {
        try{
            $brand = Brand::findorFail($request->id);

      return response()->json([
        "data" => $brand
      ], 200);
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }

    }

    public function updateBrand(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255',
            ]);
    
            if($validator->fails()) {
                return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
                exit;
            }
            $brand = Brand::findorFail($request->id);
            $value = $request->except('publish','_token');
            $value['publish'] = is_null($request->publish) ? 0 : 1;
            $success = $brand->update($value);
      return response()->json([
        'status' => 'successful',
          "data" => $value,
        "message" => "Brands updated successfully"
      ], 200);
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }
    }

    public function viewBrand(Request $request)
    {
        try{
            $brand = Brand::findorFail($request->id);
            // dd($role);

      return response()->json([
        "message" => "Role view!",
        'data' => $brand
      ], 200);
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }

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
        return view('brand::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('brand::edit',compact('id'));
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
