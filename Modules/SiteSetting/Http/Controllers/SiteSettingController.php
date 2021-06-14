<?php

namespace Modules\SiteSetting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SiteSetting\Entities\SiteSetting;

class SiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $detail = SiteSetting::first();
        return view('sitesetting::site_setting')->with(compact('detail'));
    }

    public function update(Request $request, $id)
    {
        
        $data = $request->validate([
            'favicon' => 'mimes:jpeg,jpg,png|dimensions:min_width=200,min_height=200,max_width=500,max_height=500',
             'logo' => 'mimes:jpeg,jpg,png|dimensions:min_width=200,min_height=200,max_width=500,max_height=500',
        ]);
        $value = $request->except('logo', 'fav_icon','image',);
        $image = SiteSetting::find($id);
        if ($request->hasFile('logo')) {
            if ($image->logo) {
                $this->unlinkImage($image->logo);
            }
            $value['logo'] = $this->imageProcessing($request->file('logo'));
        }
        if ($request->hasFile('fav_icon')) {
            if ($image->fav_icon) {
                $this->unlinkImage($image->fav_icon);
            }
            $value['fav_icon'] = $this->imageProcessing($request->file('fav_icon'));
        }
        SiteSetting::find($id)->update($value);
        return redirect()->back()->with('flash_message_success', 'Data Updated Successfully.');
    }

    public function imageProcessing($image)
    {
        $input['imagename'] = Date("D-h-i-s") . '-' . rand() . '-' . '.' . $image->getClientOriginalExtension();
        $image->move('uploads/siteSetting/', $input['imagename']);
        return $input['imagename'];
    }

    public function unlinkImage($imagename)
    {
        $mainPath = public_path('uploads/siteSetting/') . $imagename;
        unlink($mainPath);
        return;
    }

}
