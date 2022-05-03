<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\Blog;
use Modules\Blog\Transformers\BlogCollection;
use Modules\Blog\Transformers\BlogResource;

class BlogApiController extends Controller
{
    public function index()
    {
        $blogs = Blog::published()->get();
        return BlogResource::collection($blogs)->hide([
            'description',
            'id'
        ]);
        // return new BlogCollection($blogs);
    }

    public function show(Blog $blog)
    {
        return new BlogResource($blog);
    }

}
