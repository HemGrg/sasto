<?php

namespace Modules\Deal\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DealCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
