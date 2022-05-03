<?php

namespace Modules\Quotation\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Quotation\Entities\Quotation;
use Modules\User\Entities\Vendor;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $quotations = Quotation::withCount('replies')
            ->with('user:id,name')
            ->when(auth()->user()->hasRole('vendor'), function ($query) {
                $query->whereHas('vendors', function ($query) {
                    $query->where('vendor_id', auth()->user()->vendor->id);
                });
            })->latest()->get();

        return view('quotation::index', compact('quotations'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'purchase'      => 'required|string',
            'category_id'      => 'required',
            'quantity'      => 'required|numeric',
            'unit'      => 'required',
            "specifications"  => "required",
            'image1' =>  'nullable|mimes:jpg,jpeg,png|max:2000',
            'image2' =>  'nullable|mimes:jpg,jpeg,png|max:2000',
            'image3' =>  'nullable|mimes:jpg,jpeg,png|max:2000',
            // 'name'    => 'required|string',
            // 'email'         => 'required|email',
            // 'mobile_num'    => 'required',
            'ship_to'       => 'required',
            'expected_price'  => 'nullable',
            'expected_del_time' => 'nullable',
            'other_contact' => 'nullable',
            "link"  => "nullable",
        ]);

        try {
            DB::beginTransaction();
            $quotation = new Quotation([
                'user_id' => auth()->id(),
                'purchase' => $request->purchase,
                'quantity' => $request->quantity,
                'unit' => $request->unit,
                "specifications" => $request->specifications,
                'image1' => $request->hasFile('image1') ? $request->file('image1')->store('uploads/quotations') : null,
                'image2' => $request->hasFile('image2') ? $request->file('image2')->store('uploads/quotations') : null,
                'image3' => $request->hasFile('image3') ? $request->file('image3')->store('uploads/quotations') : null,
                // 'name' => $request->name,
                // 'email' => $request->email,
                // 'mobile_num'    => $request->mobile_num,
                'ship_to'       => $request->ship_to,
                'expected_price'  => $request->expected_price,
                'expected_del_time' => $request->expected_del_time,
                'other_contact' => $request->other_contact,
                "link"  => $request->link,
            ]);

            $quotation->save();

            $vendors = Vendor::with('user')->whereHas('categories', function ($query) use ($request) {
                $query->where('categories.id', $request->category_id);
            })->get();

            foreach ($vendors as $vendor) {
                DB::table('quotation_vendor')->insert([
                    'vendor_id' => $vendor->id,
                    'quotation_id' => $quotation->id,
                ]);

                $vendor->user->notify(new \Modules\Quotation\Notifications\NewQuotationNotification($quotation));
            }

            DB::commit();

            return response()->json(['status' => 'successful', 'message' => 'Quotation Submitted successfully.', 'data' => $quotation]);
        } catch (\Exception $exception) {
            DB::rollback();
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Quotation $quotation)
    {
        abort_if(is_alternative_login() , 403);
        if (!auth()->user()->hasAnyRole('super_admin|admin')) {
            $vendorId = auth()->user()->vendor->id;
            abort_unless($quotation->vendors->pluck('id')->contains($vendorId), 403);
        }

        $quotation->loadMissing(['vendors', 'user']);

        // $quotation->load(['replies' => function ($query) use($vendorId) {
        //     $query->where('vendor_id', $vendorId);
        // }]);

        $myReply = null;
        if (auth()->user()->hasRole('vendor')) {
            $myReply = $quotation->replies->where('vendor_id', $vendorId)->first();
        }

        return view('quotation::show', compact(['quotation', 'myReply']));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Quotation $quotation)
    {
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);

        if (!$quotation->image1) {
            Storage::delete($quotation->image1);
        }
        if (!$quotation->image2) {
            Storage::delete($quotation->image2);
        }
        if (!$quotation->image3) {
            Storage::delete($quotation->image3);
        }

        DB::table('quotation_vendor')->where('quotation_id', $quotation->id)->delete();

        $quotation->delete();

        return redirect()->back()->with('success', 'Quotation deleted successfully.');
    }

    public function destroyForVendor(Quotation $quotation)
    {
        DB::table('quotation_vendor')->where([
            'quotation_id' => $quotation->id,
            'vendor_id' => auth()->user()->vendor->id
        ])->delete();

        return redirect()->back()->with('success', 'Quotation deleted successfully.');
    }
}
