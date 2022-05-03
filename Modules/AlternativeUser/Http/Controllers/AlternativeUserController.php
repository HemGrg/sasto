<?php

namespace Modules\AlternativeUser\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AlternativeUser\Entities\AlternativeUser;
use Modules\AlternativeUser\Http\Requests\AlternativeUserRequest;

class AlternativeUserController extends Controller
{
    public function index()
    {
        abort_unless(!is_alternative_login(), 403);

        $alternativeUsers = AlternativeUser::where('user_id', auth()->id())->latest()->get();

        return view('alternativeuser::index', compact('alternativeUsers'));
    }

    public function create()
    {
        abort_unless(!is_alternative_login(), 403);
        return $this->showForm(new AlternativeUser());
    }

    public function store(AlternativeUserRequest $request)
    {
        abort_unless(!is_alternative_login(), 403);

        $alternativeUser = AlternativeUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => bcrypt($request->password),
            'permissions' => $request->permissions,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('alternative-users.index')->with('success', $alternativeUser->name . ' has been added to user list.');
    }

    public function edit(AlternativeUser $alternativeUser)
    {
        abort_unless(!is_alternative_login(), 403);

        return $this->showForm($alternativeUser);
    }

    public function update(AlternativeUserRequest $request, AlternativeUser $alternativeUser)
    {
        abort_unless(!is_alternative_login(), 403);

        $alternativeUser->name =  $request->name;
        $alternativeUser->email = $request->email;
        $alternativeUser->mobile = $request->mobile;
        if ($request->password) {
            $alternativeUser->password = bcrypt($request->password);
        }
        $alternativeUser->permissions = $request->permissions;
        $alternativeUser->user_id = auth()->id();
        $alternativeUser->update();

        return redirect()->route('alternative-users.index')->with('success', 'Information updated successfully.');
    }

    public function destroy(AlternativeUser $alternativeUser)
    {
        abort_unless(!is_alternative_login(), 403);

        $alternativeUser->delete();

        return redirect()->route('alternative-users.index')->with('error', 'User has been deleted.');
    }

    protected function showForm(AlternativeUser $alternativeUser)
    {
        $updateMode = false;
        if ($alternativeUser->exists) {
            $updateMode = true;
        }
        $permissions = config('constants.alternative_user_permissions');
        
        return view('alternativeuser::form', compact(['alternativeUser', 'updateMode', 'permissions']));
    }
}
