<?php

namespace Modules\Quotation\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Quotation\Entities\Quotation;
use Modules\Quotation\Transformers\QuotationCollection;
use Modules\Quotation\Transformers\QuotationResource;

class QuotationApiController extends Controller
{
    public function index()
    {
        $quotations = auth()->user()->quotations()->withCount('replies')->latest()->cursorPaginate();

        return QuotationCollection::make($quotations);
    }

    public function show(Quotation $quotation)
    {
        $quotation->loadCount('replies');
        $quotation->load([
            'replies',
            'replies.vendor:id,shop_name,user_id'
        ]);

        return new QuotationResource($quotation);
    }
}
