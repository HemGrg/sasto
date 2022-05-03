<?php

namespace Modules\Partner\Http\Controllers;

use App\Rules\Mobile;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Partner\Entities\BecomePartner;

class BecomePartnerController extends Controller
{
    public function index(){
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);
        $partners = BecomePartner::get();
        return view('partner::partner-request-index', compact('partners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|max:255',
            'company_email' => 'required',
            'address' => 'required',
            'partner_type_id' => 'required|numeric|exists:partner_types,id',
            'company_phone' => 'required',
            'eastablished_year' => 'required',
            'company_web' => 'nullable|url',
            'full_name' => 'required',
            'email' => 'required',
            'designation' => 'required',
            'phone' => ['required', new Mobile],
        ]);
        
        BecomePartner::create([
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'address' => $request->address,
            'company_phone' => $request->company_phone,
            'eastablished_year' => $request->eastablished_year,
            'partner_type_id' => $request->partner_type_id,
            'company_web' => $request->company_web,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'designation' => $request->designation,
            'phone' => $request->phone
        ]);

        return response()->json(['status' => 'successful', 'message' => 'Form Submitted Successfully.'],200);
    }

    public function viewPartnerRequest(Request $request){
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);
        $detail = BecomePartner::findOrFail($request->id);
        return view('partner::partner-request-view', compact('detail'));
    }

    public function delete(BecomePartner $partner){
        // dd('hi');
        $partner->delete();
        return redirect()->back()->with('success','Partner Request Deleted Successfully!!');

    }
}
