<?php

namespace Modules\Country\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\Country\Entities\Country;
use Modules\Country\Transformers\CountryCollection;
use Modules\Country\Transformers\CountryResource;

class ApiCountryController extends Controller
{

    public function index()
    {
        $countries = Country::published()->get();

        return new CountryCollection($countries);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Country $country)
    {
        // TODO::DO we also need to send all vendors with country?
        return new CountryResource($country);
    }
}
