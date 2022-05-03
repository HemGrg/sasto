<?php

namespace Modules\AdminUser\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\User;

class AdminUserController extends Controller
{

    public function index()
    {
        $details = User::with('roles')->whereHas('roles', function ($q) {
            $q->where('slug',  'vendor');
        })
            ->when(request()->filled('search'), function ($query) {
                return $query->where('name', 'like', '%' . request('search') . "%")
                    ->orWhere('email', 'like', '%' . request('search'));
            })->latest()
            ->paginate(15)
            ->withQueryString();
        $role = 'vendor';
        return view('adminuser::index', compact('details','role'));
    }

    public function getAllCustomers()
    {
        $details = User::with('roles')->whereHas('roles', function ($q) {
            $q->where('slug',  'customer');
        })
            ->when(request()->filled('search'), function ($query) {
                return $query->where('name', 'like', '%' . request('search') . "%")
                    ->orWhere('email', 'like', '%' . request('search'));
            })->latest()
            ->paginate(15)
            ->withQueryString();
            $role = 'customer';
        return view('adminuser::index', compact('details','role'));
    }
}
