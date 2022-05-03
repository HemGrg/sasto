<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Faq\Entities\Faq;
use Modules\Faq\Transformers\FaqCollection;

class FaqApiController extends Controller
{
    public function index()
    {
        $faqs = Faq::published()->positioned()->get();
        return new FaqCollection($faqs);
    }

}
