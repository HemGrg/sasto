<?php

namespace Modules\Quotation\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Quotation\Entities\Quotation;

class QuotationReplyController extends Controller
{
    public function store(Request $request, Quotation $quotation)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $quotation->replies()->updateOrCreate(
            [
                'vendor_id' => auth()->user()->vendor->id
            ],
            [
                'message' => $request->message,
            ]
        );

        return redirect()->back()->with('success', 'Reply sent successfully');
    }
}
