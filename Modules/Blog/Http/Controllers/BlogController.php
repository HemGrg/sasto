<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Requests\BlogRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\Blog;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::get();

        return view('blog::index', compact('blogs'));
    }

    public function create()
    {
        return $this->showForm(new Blog());
    }

    public function store(BlogRequest $request)
    {
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);
        $blog = new Blog();
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->short_description = $request->short_description;
        $blog->author = $request->author;
        $blog->is_active = $request->filled('is_active');

        if ($request->has('image')) {
            $blog->image = $request->image->store('images/blog');
        }
        // dd($blog);
        $blog->save();


        return redirect()->route('blog.index')->with('success', 'Blog added successfully.');
    }

    public function show($id)
    {
        return view('blog::show');
    }

    public function edit(Blog $blog)
    {
        return $this->showForm($blog);
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);
        $blog->title = $request->title;
        $blog->author = $request->author;
        $blog->description = $request->description;
        $blog->short_description = $request->short_description;
        $blog->is_active = $request->filled('is_active');
        if ($request->has('image')) {
            $blog->image = $request->image->store('images/blog');
        }
        $blog->update();

        return redirect()->route('blog.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        $blog->deleteImage();
        $blog->delete();

        return redirect()->route('blog.index')->with('success', 'blog Deleted Successfuly.');
    }

    public function showForm(Blog $blog)
    {
        $updateMode = false;

        if ($blog->exists) {
            $updateMode = true;
        }

        return view('blog::form', compact(['blog', 'updateMode']));
    }
}
