<?php

namespace Modules\Blog\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BlogCollection extends ResourceCollection
{
    protected $withoutFields = [];
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function hide(array $fields)
    {
        $this->withoutFields = $fields;
        return $this;
    }

    public function toArray($request)
    {
        return $this->processCollection($request);
    }

    protected function processCollection($request)
    {
        return $this->collection->map(function (BlogResource $resource) use ($request) {
            return $resource->hide($this->withoutFields)->toArray($request);
        })->all();
    }
}
