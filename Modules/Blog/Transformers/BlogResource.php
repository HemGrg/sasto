<?php

namespace Modules\Blog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */

    public function toArray($request)
    {
        return $this->filterFields([
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'author' => $this->author,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'image_url' => $this->imageUrl(),
            'created_at' => $this->created_at
        ]);
    }

    public function hide(array $fields)
    {
        $this->withoutFields = $fields;
        return $this;
    }

    public static function collection($resource)
    {
        return tap(new BlogCollection($resource), function ($collection) {
            $collection->collects = __CLASS__;
        });
    }

    protected function filterFields($array)
    {
        return collect($array)->forget($this->withoutFields)->toArray();
    }
    
}
