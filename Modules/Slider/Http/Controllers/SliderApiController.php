<?php

namespace Modules\Slider\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Slider\Entities\Slider;
use Modules\Slider\Transformers\SliderCollection;
use Modules\Slider\Transformers\SliderResource;

class SliderApiController extends Controller
{
    
    public function index()
    {
        $sliders = Slider::published()->get();

        return new SliderCollection($sliders);
    }

}
