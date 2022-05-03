<?php

namespace Modules\Slider\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Slider\Entities\Slider;
use Image;
use File;
use Validator;

class SliderController extends Controller
{
    protected $slider = null;
    public function __construct(Slider $slider){
        $this->slider = $slider;
    }
    public function index()
    {
        $sliders = $this->slider->published()->orderBy('id', 'DESC')->get();
        return view('slider::index',compact('sliders'));
    }

    public function create()
    {
        $slider_info = null;
        return view('slider::create',compact('slider_info'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'mimes:jpg,jpeg,png',
        ]);

        $value = $request->except('image', 'publish');
        $value['publish'] = is_null($request->publish) ? 0 : 1;
        if($request->image){
            $image = $this->imageProcessing('img-', $request->file('image'));
            $value['image'] = $image;
        }
        $success= $this->slider->create($value);
        
        return redirect()->route('slider.index')->with('success', 'Slider added Successfuly.');
    }

    public function edit($id)
    {
        $slider_info = $this->slider->find($id);
        if (!$slider_info) {
           $request->session()->flash('error', 'Invalid Slider Id or Slider  not found.');
            return redirect()->route('slider.index');
        }
        return view('slider::create', compact( 'slider_info'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'mimes:jpg,jpeg,png',
        ]);

        $slider =$this->slider->findorFail($id);
        $value = $request->except('_token');
        // $value['status'] = is_null($request->status) ? 'unpublish' : 'publish';
        if ($request->image) {
        $image = $this->slider->findorFail($id);
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
        $success = $slider->update($value);
        return redirect()->route('slider.index')->with('success', 'Slider Updated Successfuly.');
    }

    public function destroy(Request $request,$id)
    {
        $slider = $this->slider->findorFail($id);
            if ($slider->image) {
                $this->unlinkImage($slider->image);
            }
        $slider->delete();
           return redirect()->route('slider.index')->with('success', 'Slider Deleted Successfuly.');
    }

    public function imageProcessing($type, $image)
    {
        $input['imagename'] = $type . time() . '.' . $image->getClientOriginalExtension();
        $thumbPath = public_path('images/thumbnail');
        $listingPath = public_path('images/listing');

        $img1 = Image::make($image->getRealPath());
        $img1->fit(99,88)->save($thumbPath . '/' . $input['imagename']);


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
