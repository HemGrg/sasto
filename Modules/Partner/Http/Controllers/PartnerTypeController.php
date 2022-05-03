<?php

namespace Modules\Partner\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Partner\Entities\PartnerType;

class PartnerTypeController extends Controller
{
    public function index()
    {
        $partners = PartnerType::get();
        return view('partner::partner-type.index', compact('partners'));
    }

    public function create()
    {
        return $this->showForm(new PartnerType(['position' => PartnerType::getNextPosition()]));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'position' => 'required|integer',
            'publish' => 'nullable'
        ]);
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);
        PartnerType::create([
            'name' => $request->name,
            'position' => $request->position,
            'publish' => $request->has('publish') ? 1 : 0,
        ]);

        return redirect()->route('partner-type.index')->with('success', 'Partner Type Created Successfuly.');
    }

    public function show($id)
    {
        return view('partner::show');
    }

    public function edit(PartnerType $partnerType)
    {
        return $this->showForm($partnerType);
    }

    public function update(Request $request, PartnerType $partnerType)
    {
        $request->validate([
            'name' => 'required|max:255',
            'position' => 'nullable',
            'publish' => 'nullable'
        ]);
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);
        $partnerType->fill([
            'name' => $request->name,
            'position' => $request->position,
            'publish' => $request->has('publish') ? 1 : 0
        ]);

        $partnerType->update();

        return redirect()->route('partner-type.index')->with('success', 'Partner Updated Successfuly.');
    }

    public function destroy(PartnerType $partnerType)
    {
        if (!$partnerType->canBeDeletedSafely()) {
            return redirect()->route('partner-type.index')->with('error', 'Partner Type Cannot be Deleted!.');
        }

        $partnerType->delete();
        return redirect()->route('partner-type.index')->with('success', 'Partner Type Deleted Successfuly.');
    }

    public function showForm(PartnerType $partner)
    {
        $updateMode = false;
        if ($partner->exists) {
            $updateMode = true;
        }

        return view('partner::partner-type.form', compact(['partner', 'updateMode']));
    }
}
