<?php

namespace Modules\Advertisement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Advertisement\Entities\Advertisement;
use Validator;
use Image;
use DB;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $details = Advertisement::latest()->get();
        return view('advertisement::index',compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('advertisement::create');
    }

    public function createadvertisement(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:advertisements|max:255',
            'link' => 'required|url',
            'image' => 'mimes:jpg,jpeg,png',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
            exit;
        }
        
        $value = $request->except('image', 'publish');
        // dd($value);
        // $value['publish'] = is_null($request->publish) ? 0 : 1;

        if($request->image){
            $image = $this->imageProcessing('img-', $request->file('image'));
            $value['image'] = $image;
        }

        DB::beginTransaction();
        // dd($value);
        $data = Advertisement::create($value);
        DB::commit();
        return response()->json(['status' => 'successful', 'message' => 'Advertisement created successfully.', 'data' => $data]);
    }

    public function alladvertisements(){
        // $details = Advertisement::where('status','Publish')->orderBy('updated_at', 'desc')->get();
        $details = Advertisement::orderBy('updated_at', 'desc')->get();
        $view = \View::make("advertisement::advertisementsTable")->with('details', $details)->render();
        return response()->json(['html' => $view, 'status' => 'successful', 'data' => $details]);
    }

    public function deleteadvertisement(Request $request)
    {
        try{
            $advertisement = Advertisement::findorFail($request->id);
            if ($advertisement->image) {
                $this->unlinkImage($advertisement->image);
            }
            $advertisement->delete();

      return response()->json([
        'status' => 'successful',
        "message" => "Advertisement deleted successfully!"
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
        return view('advertisement::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('advertisement::edit',compact('id'));
    }

    public function editadvertisement(Request $request)
    {
        try{
            $advertisement = Advertisement::findorFail($request->id);

      return response()->json([
        "data" => $advertisement
      ], 200);
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }

    }

    public function updateadvertisement(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255',
                'link' => 'required|url',
                'image' => 'mimes:jpg,jpeg,png',
            ]);
    
            if($validator->fails()) {
                return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
                exit;
            }
            $advertisement = Advertisement::findorFail($request->id);
            $value = $request->except('_token');
            if ($request->image) {
            $image = Advertisement::findorFail($request->id);
                if ($image->image) {
                    $thumbPath = public_path('images/thumbnail');
                    $listingPath = public_path('images/listing');
                    if((file_exists($thumbPath . '/' . $image->image)) && (file_exists($listingPath . '/' . $image->image))){
                        unlink($thumbPath . '/' . $image->image);
                        unlink($listingPath . '/' . $image->image);
                    }
                }
                $image = $this->imageProcessing('img-', $request->file('image'));
                $value['image'] = $image;
            }
            $success = $advertisement->update($value);
      return response()->json([
        'status' => 'successful',
          "data" => $value,
        "message" => "advertisement updated successfully"
      ], 200);
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
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

    public function imageProcessing($type, $image)
    {
        $input['imagename'] = $type . time() . '.' . $image->getClientOriginalExtension();
        $thumbPath = public_path('images/thumbnail');
        $mainPath = public_path('images/main');
        $listingPath = public_path('images/listing');

        $img1 = Image::make($image->getRealPath());
        $img1->fit(530, 300)->save($thumbPath . '/' . $input['imagename']);


        $img2 = Image::make($image->getRealPath());
        $img2->fit(99, 88)->save($listingPath . '/' . $input['imagename']);

        $destinationPath = public_path('/images');
        return $input['imagename'];
    }

    public function unlinkImage($imagename)
    {
        $thumbPath = public_path('images/thumbnail/') . $imagename;
        $mainPath = public_path('images/main/') . $imagename;
        $listingPath = public_path('images/listing/') . $imagename;
        $documentPath = public_path('document/') . $imagename;
        if (file_exists($thumbPath)) {
            unlink($thumbPath);
        }

        if (file_exists($mainPath)) {
            unlink($mainPath);
        }

        if (file_exists($listingPath)) {
            unlink($listingPath);
        }

        if (file_exists($documentPath)) {
            unlink($documentPath);
        }
        return;
    }
}
