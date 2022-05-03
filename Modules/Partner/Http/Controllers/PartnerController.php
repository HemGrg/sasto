<?php

namespace Modules\Partner\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Partner\Entities\Partner;
use Modules\Partner\Entities\PartnerType;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::get();
        return view('partner::index', compact('partners'));
    }

    public function create()
    {
        return $this->showForm(new Partner());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'image' => 'required',
            'partner_type_id' => 'required|numeric|exists:partner_types,id',
            'publish' => 'nullable'
        ]);
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);
        Partner::create([
            'name' => $request->name,
            'partner_type_id' => $request->partner_type_id,
            'publish' => $request->has('publish') ? 1 : 0,
            'path' => $request->hasFile('image') ? $request->file('image')->store('uploads/partners') : null
        ]);

        return redirect()->route('partner.index')->with('success', 'Partner Created Successfuly.');
    }

    public function show($id)
    {
        return view('partner::show');
    }

    public function edit(Partner $partner)
    {
        return $this->showForm($partner);
    }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'name' => 'required|max:255',
            'partner_type_id' => 'required|numeric|exists:partner_types,id',
            'image' => 'required',
            'publish' => 'nullable'
        ]);
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);
        $partner->fill([
            'name' => $request->name,
            'partner_type_id'       => $request->partner_type_id,
            'publish' => $request->has('publish') ? 1 : 0
        ]);

        if ($request->hasFile('image')) {
            $partner->deleteImage();
            $partner->path = $request->file('image')->store('uploads/partners');
        }

        $partner->update();

        return redirect()->route('partner.index')->with('success', 'Partner Updated Successfuly.');
    }

    public function destroy(Partner $partner)
    {
        $partner->deleteImage();
        $partner->delete();

        return redirect()->route('partner.index')->with('success', 'Partner Deleted Successfuly.');
    }

    public function showForm(Partner $partner)
    {
        $updateMode = false;
        $partnerTypes = PartnerType::publish()->positioned()->get();
        if ($partner->exists) {
            $updateMode = true;
        }

        return view('partner::form', compact(['partner', 'updateMode', 'partnerTypes']));
    }
}
