<?php

namespace Modules\Offer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Offer\Entities\Offer;
use Validator;
use Image;
use DB;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('offer::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('offer::create');
    }

    public function createoffer(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:offers|max:255',
            'image' => 'mimes:jpg,jpeg,png',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
            exit;
        }
        
        $value = $request->except('image', 'publish');
        $value['publish'] = is_null($request->publish) ? 0 : 1;

        if($request->image){
            $image = $this->imageProcessing('img-', $request->file('image'));
            $value['image'] = $image;
        }

        DB::beginTransaction();
        // dd($value);
        $data = Offer::create($value);
        DB::commit();
        return response()->json(['status' => 'successful', 'message' => 'Offer created successfully.', 'data' => $data]);
    }

    public function getoffer(){
        $details = Offer::orderBy('created_at', 'desc')->get();
        $view = \View::make("offer::offersTable")->with('details', $details)->render();
        return response()->json(['html' => $view, 'status' => 'successful', 'data' => $details]);
    }
    public function deleteoffer(Request $request)
    {
        try{
            $offer = Offer::findorFail($request->id);
            if ($offer->image) {
                $this->unlinkImage($offer->image);
            }
            $offer->delete();

      return response()->json([
        'status' => 'successful',
        "message" => "Offer deleted successfully!"
      ], 200);
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }

    }

    public function editoffer(Request $request)
    {
        try{
            $offer = offer::findorFail($request->id);

      return response()->json([
        "data" => $offer
      ], 200);
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }

    }

    public function updateoffer(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255',
                'image' => 'mimes:jpg,jpeg,png',
            ]);
    
            if($validator->fails()) {
                return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
                exit;
            }
            $offer = offer::findorFail($request->id);
            $value = $request->except('publish','_token');
            $value['publish'] = is_null($request->publish) ? 0 : 1;
            if ($request->image) {
            $image = offer::findorFail($request->id);
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
            $success = $offer->update($value);
      return response()->json([
        'status' => 'successful',
          "data" => $value,
        "message" => "offer updated successfully"
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
        return view('offer::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('offer::edit',compact('id'));
    }
    public function view($id)
    {
        return view('offer::view', compact('id'));
    }

    public function viewOffer(Request $request)
    {
        try{
            $offer = Offer::findorFail($request->id);
      return response()->json([
        "message" => "Offer view!",
        'data' => $offer
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
