<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Country\Entities\Country;

class ProductFilterBarApiController extends Controller
{
    public function __invoke()
    {
        return [
            'seller_type' => $this->getSellerType(),
            'business_types' => $this->getBusinessTypes(),
            'countries' => $this->getCountries(),
        ];
    }

    private function getSellerType()
    {
        return [
            [
                'key' => 'local_seller',
                'tip' => 'Local'
            ],
            [
                'key' => 'international_seller',
                'tip' => 'International'
            ],
        ];
    }

    private function getBusinessTypes()
    {
        foreach (config('constants.business_type') as $businessType) {
            $businessTypes[] = [
                'key' => $businessType,
                'tip' => $businessType
            ];
        }

        return $businessTypes;
    }

    private function getCountries()
    {
        $countries = Cache::remember('product-filter-countries', now()->addMinutes(10), function () {
           return Country::orderBy('name')->get();
        });

        foreach ($countries as $country) {
            $countryList[] = [
                'key' => $country->id,
                'tip' => $country->name
            ];
        }

        return $countryList;
    }
}
