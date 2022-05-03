<?php

namespace Modules\Subscriber\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Subscriber\Entities\Subscriber;
use Validator, DB;

class SubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::orderBy('created_at', 'DESC')->get();
        return view('subscriber::index',compact('subscribers'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email'             => 'required|email'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()],422);
                exit;
            }
            $data=['email'=>$request->email];
            $success= Subscriber::create($data);
            return response()->json(['status' => 'successful', 'message' => 'Subscribed Successfully.', 'data' => $success]);
        } catch (\Exception $exception) {
            DB::rollback();
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function delete(Subscriber $subscriber)
    {
        $subscriber->delete();
        return redirect()->route('subscriber.index')->with('success', 'Subscriber Deleted Successfuly.');
    }
}
