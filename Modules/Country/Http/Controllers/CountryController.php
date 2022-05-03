<?php

namespace Modules\Country\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Country\Entities\Country;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::get();

        return view('country::index', compact('countries'));
    }

    public function create()
    {
        return $this->showForm(new Country());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'flag' => 'required',
            'publish' => 'nullable'
        ]);
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);
        Country::create([
            'name' => $request->name,
            'publish' => $request->has('publish') ? 1 : 0,
            'path' => $request->hasFile('flag') ? $request->file('flag')->store('uploads/countries') : null
        ]);

        return redirect()->route('country.index')->with('success', 'Country Created Successfuly.');
    }

    public function show($id)
    {
        return view('country::show');
    }

    public function edit(Country $country)
    {
        return $this->showForm($country);
    }

    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|max:255',
            'flag' => 'nullable',
            'publish' => 'nullable'
        ]);
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);
        $country->fill([
            'name' => $request->name,
            'publish' => $request->has('publish') ? 1 : 0
        ]);

        if ($request->hasFile('flag')) {
            $country->deleteFlagImage();
            $country->path = $request->file('flag')->store('uploads/countries');
        }

        $country->update();

        return redirect()->route('country.index')->with('success', 'Country Updated Successfuly.');
    }

    public function destroy(Country $country)
    {
        // check if there are vendors in this country before deleting
        if (!$country->canBeDeletedSafely()) {
            return redirect()->route('country.index')->with('error', 'Country Cannot be Deleted!.');
        }
        $country->deleteFlagImage();
        $country->delete();

        return redirect()->route('country.index')->with('success', 'Country Deleted Successfuly.');
    }

    public function showForm(Country $country)
    {
        $updateMode = false;

        if ($country->exists) {
            $updateMode = true;
        }

        return view('country::form', compact(['country', 'updateMode']));
    }
}
