<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use YubarajShrestha\NCHL\Facades\Nchl;

class TestController extends Controller
{
    public function payment()
    {
        $nchl = Nchl::__init([
            "txn_id" => '3',
            "txn_date" => '1-10-2020',
            "txn_amount" => '500',
            "reference_id" => 'REF-001',
            "remarks" => 'RMKS-001',
            "particulars" => 'PART-001',
        ]);

        return view('payment', compact('nchl'));
    }
}
