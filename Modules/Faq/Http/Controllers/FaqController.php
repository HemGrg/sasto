<?php

namespace Modules\Faq\Http\Controllers;

use App\Http\Requests\FaqRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Faq\Entities\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::get();

        return view('faq::index', compact('faqs'));
    }

    public function create()
    {
        return $this->showForm(new Faq(['position' => Faq::getNextPosition()]));

    }

    public function store(FaqRequest $request)
    {
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);
        $faq = new Faq();
        $faq->title = $request->title;
        $faq->description = $request->description;
        $faq->position = $request->position;
        $faq->is_active = $request->filled('is_active');
        $faq->save();


        return redirect()->route('faq.index')->with('success', 'Faq added successfully.');
    }

    public function show($id)
    {
        return view('faq::show');
    }

    public function edit(Faq $faq)
    {
        return $this->showForm($faq);
    }

    public function update(FaqRequest $request, Faq $faq)
    {
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);
        $faq->title = $request->title;
        $faq->description = $request->description;
        $faq->position = $request->position;
        $faq->is_active = $request->filled('is_active');
        $faq->update();

        return redirect()->route('faq.index')->with('success', 'faq updated successfully.');
    }

    public function destroy(faq $faq)
    {
        $faq->delete();

        return redirect()->route('faq.index')->with('success', 'faq Deleted Successfuly.');
    }

    public function showForm(Faq $faq)
    {
        $updateMode = false;

        if ($faq->exists) {
            $updateMode = true;
        }

        return view('faq::form', compact(['faq', 'updateMode']));
    }
}
