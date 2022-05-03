<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Partner\Entities\Partner;
use Modules\Partner\Entities\PartnerType;
use Modules\Partner\Transformers\PartnerCollection;
use Modules\Partner\Transformers\PartnerTypeCollection;

class PartnerApiController extends Controller
{
    public function allPartners()
    {
        $partners = PartnerType::with('partners')->positioned()->get();

        return new PartnerTypeCollection($partners);
    }

    public function carousel()
    {
        $partners = Partner::get();

        return new PartnerCollection($partners);
    }
}
